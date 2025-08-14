<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SnowballingController extends Controller
{
    private const S2 = 'https://api.semanticscholar.org/graph/v1';

    public function index()
    {
        return view('snowballing');
    }

    public function fetchReferences(Request $request)
    {
        $request->validate([
            'q' => ['required','string'],
        ]);

        $q = trim($request->input('q'));

        try {
            // 1) Resolver artigo “semente” a partir de q (DOI ou Título)
            if ($this->isLikelyDoi($q)) {
                $doi  = $this->normalizeDoi($q);
                $seed = $this->getByDoi($doi);
                if (!$seed) {
                    return back()->with('error', 'DOI não encontrado no Semantic Scholar.')->withInput();
                }
            } else {
                // tenta match → fallback para /paper/search (primeiro resultado)
                $seed = $this->resolveTitle($q);
                if (!$seed) {
                    return back()->with('error', 'Nenhum artigo encontrado para esse título.')->withInput();
                }
            }

            $paperId  = $seed['paperId'] ?? null;
            $seedDoi  = $seed['externalIds']['DOI']     ?? null;
            $corpusId = $seed['corpusId']               ?? ($seed['externalIds']['CorpusId'] ?? null);

            if (!$paperId) {
                return back()->with('error', 'Artigo encontrado sem identificador válido.')->withInput();
            }

            // 2) Detalhes com contadores
            $details = $this->getDetails($paperId);
            if (!$details) {
                return back()->with('error', 'Não foi possível carregar metadados do artigo.')->withInput();
            }

            // preferir valores dos details
            $seedDoi  = $details['externalIds']['DOI'] ?? $seedDoi;
            $corpusId = $details['corpusId']           ?? $corpusId;

            $article = [
                'title'    => $details['title'] ?? null,
                'year'     => $details['year'] ?? null,
                'authors'  => $this->authorsToString($details['authors'] ?? []),
                'doi'      => $seedDoi,
                'url'      => $details['url'] ?? null,
                'abstract' => $details['abstract'] ?? null,
            ];

            $expectedRef = (int)($details['referenceCount'] ?? 0);
            $expectedCit = (int)($details['citationCount'] ?? 0);

            // 3) Coletar referências e citações com fallback de IDs
            $candidates = $this->buildIdCandidates($paperId, $seedDoi, $corpusId);

            $references = $this->collectWithFallback($candidates, 'references', $expectedRef, 1000);
            $citations  = $this->collectWithFallback($candidates, 'citations',  $expectedCit, 1000);

            return view('snowballing', [
                'article'    => $article,
                'references' => $references,
                'citations'  => $citations,
                'q'          => $q,
            ]);

        }catch (\Throwable $e) {
            Log::error('Snowballing error', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);
            return back()
                ->with('error', 'Erro inesperado ao buscar dados.')
                ->withInput();
        }
    }

    /* ======================= HTTP ======================= */

    private function http(): \Illuminate\Http\Client\PendingRequest
    {
        $key = env('S2_API_KEY'); // opcional, mas recomendado qdo tiver API KEY
        $h = Http::withHeaders([
            'User-Agent' => 'Thoth-SLR/1.0',
        ]);

        if ($key) {
            $h = $h->withHeaders(['x-api-key' => $key]);
        }

        // ✅ Callback correto: apenas ($exception, $request)
        return $h->timeout(25)->retry(4, 400, function ($exception, $request) {
            // Se quiser, você pode inspecionar a exception para decidir se deve tentar de novo
            // ex.: return $exception instanceof \Illuminate\Http\Client\RequestException;
            return true; // tenta novamente para 429/5xx e falhas transitórias
        });
    }

    /* ======================= Heurísticas DOI/Título ======================= */

    private function isLikelyDoi(string $q): bool
    {
        $q = trim($q);
        if (preg_match('#^https?://(dx\.)?doi\.org/.*#i', $q)) return true;
        if (preg_match('#^10\.\d{4,9}/\S+#i', $q)) return true;
        if (preg_match('#^doi:\s*\S+#i', $q)) return true;
        return false;
    }

    private function normalizeDoi(string $raw): string
    {
        $raw = trim($raw);
        $raw = preg_replace('#^https?://(dx\.)?doi\.org/#i', '', $raw);
        $raw = preg_replace('#^doi:\s*#i', '', $raw);
        return $raw;
    }

    /* ======================= RESOLUÇÃO ======================= */

    private function resolveTitle(string $title): ?array
    {
        // Tenta /paper/search/match
        $seed = $this->searchByTitleMatch($title);
        if ($seed && !empty($seed['paperId'])) {
            return $seed;
        }
        // Fallback para /paper/search (1º resultado)
        return $this->searchByTitleFallback($title);
    }

    private function getByDoi(string $doi): ?array
    {
        $fields = 'paperId,corpusId,title,year,authors,url,externalIds';
        $r = $this->http()->get(self::S2."/paper/DOI:{$doi}", ['fields' => $fields]);
        return $r->successful() ? $r->json() : null;
    }

    private function searchByTitleMatch(string $title): ?array
    {
        $fields = 'paperId,corpusId,title,year,authors,url,externalIds,matchScore';
        $r = $this->http()->get(self::S2.'/paper/search/match', [
            'query'  => $title,
            'fields' => $fields,
        ]);

        if ($r->status() === 404) return null; // "Title match not found"
        if (!$r->successful())   return null;

        $data = $r->json();
        return (!empty($data['paperId'])) ? $data : null;
    }

    private function searchByTitleFallback(string $title): ?array
    {
        $fields = 'paperId,corpusId,title,year,authors,url,externalIds';
        $r = $this->http()->get(self::S2.'/paper/search', [
            'query'  => $title,
            'limit'  => 5,
            'offset' => 0,
            'fields' => $fields,
        ]);

        if (!$r->successful()) return null;

        $data = $r->json();
        if (empty($data['data']) || !is_array($data['data'])) return null;

        $first = $data['data'][0] ?? null;
        return (!empty($first['paperId'])) ? $first : null;
    }

    private function getDetails(string $paperId): ?array
    {
        $fields = implode(',', [
            'paperId','corpusId','title','year','abstract','authors','url','externalIds',
            'referenceCount','citationCount',
        ]);
        $r = $this->http()->get(self::S2."/paper/{$paperId}", ['fields' => $fields]);
        return $r->successful() ? $r->json() : null;
    }

    /* ======================= FALLBACK ======================= */

    private function buildIdCandidates(?string $paperId, ?string $doi, $corpusId): array
    {
        $ids = [];
        if ($paperId)  $ids[] = $paperId;               // "a1b2c3..."
        if ($doi)      $ids[] = "DOI:{$doi}";           // "DOI:10.1109/ESEM.2019.8870160"
        if ($corpusId) $ids[] = "CorpusId:{$corpusId}"; // "CorpusId:204815808"
        return array_values(array_unique(array_filter($ids)));
    }

    private function collectWithFallback(array $idCandidates, string $mode, int $expected, int $max): array
    {
        // $mode: 'references' | 'citations'
        $collected = [];
        foreach ($idCandidates as $i => $id) {
            $chunk = $mode === 'references'
                ? $this->getAllReferences($id, $max)
                : $this->getAllCitations($id, $max);

            $collected = $this->mergeUnique($collected, $chunk);

            if ($expected > 0 && count($collected) >= $expected) break;
            if ($i === count($idCandidates) - 1) break; // último candidato
        }

        // Se ainda vazio, tenta via detalhes expandido (pode vir quando os endpoints de lista falham)
        if (count($collected) === 0 && !empty($idCandidates)) {
            $firstId = $idCandidates[0];
            $collected = $mode === 'references'
                ? $this->getReferencesFromDetails($firstId)
                : $this->getCitationsFromDetails($firstId);
        }

        return $collected;
    }

    private function mergeUnique(array $base, array $extra): array
    {
        $seen = [];
        $out  = [];

        $push = function ($p) use (&$seen, &$out) {
            $key = mb_strtolower(trim(
                ($p['paperId'] ?? '') . '|' .
                ($p['title']   ?? '') . '|' .
                ($p['year']    ?? '') . '|' .
                ($p['doi']     ?? '') . '|' .
                ($p['url']     ?? '')
            ));
            if ($key === '||||') return;
            if (!isset($seen[$key])) {
                $seen[$key] = true;
                $out[] = $p;
            }
        };

        foreach ($base as $p)  $push($p);
        foreach ($extra as $p) $push($p);

        return $out;
    }

    /* ======================= PAGINAÇÃO ======================= */

    private function getAllReferences(string $idOrQualified, int $max = 500): array
    {
        $out = [];
        $offset = 0;
        $limit = 100;

        $fields = implode(',', [
            'citedPaper.paperId','citedPaper.title','citedPaper.year','citedPaper.url',
            'citedPaper.authors','citedPaper.externalIds',
        ]);

        while (count($out) < $max) {
            $res = $this->http()->get(self::S2."/paper/{$idOrQualified}/references", [
                'fields' => $fields,
                'limit'  => $limit,
                'offset' => $offset,
            ]);

            if (!$res->successful()) break;

            $chunk = $res->json()['data'] ?? [];
            if (empty($chunk)) break;

            foreach ($chunk as $row) {
                $p = $row['citedPaper'] ?? ($row['paper'] ?? null);
                if (!$p) continue;
                $out[] = $this->mapPaper($p, true);
                if (count($out) >= $max) break;
            }

            if (count($chunk) < $limit) break;
            $offset += $limit;

            usleep(120000);
        }

        return $out;
    }

    private function getAllCitations(string $idOrQualified, int $max = 500): array
    {
        $out = [];
        $offset = 0;
        $limit = 100;

        $fields = implode(',', [
            'citingPaper.paperId','citingPaper.title','citingPaper.year','citingPaper.url',
            'citingPaper.authors','citingPaper.externalIds',
        ]);

        while (count($out) < $max) {
            $res = $this->http()->get(self::S2."/paper/{$idOrQualified}/citations", [
                'fields' => $fields,
                'limit'  => $limit,
                'offset' => $offset,
            ]);

            if (!$res->successful()) break;

            $chunk = $res->json()['data'] ?? [];
            if (empty($chunk)) break;

            foreach ($chunk as $row) {
                $p = $row['citingPaper'] ?? ($row['paper'] ?? null);
                if (!$p) continue;
                $out[] = $this->mapPaper($p, true);
                if (count($out) >= $max) break;
            }

            if (count($chunk) < $limit) break;
            $offset += $limit;

            usleep(120000);
        }

        return $out;
    }

    /* ============ FALLBACK via detalhes expandido ============ */

    private function getReferencesFromDetails(string $idOrQualified, int $max = 500): array
    {
        if (!$idOrQualified) return [];
        $fields = implode(',', [
            'references.paperId','references.title','references.year','references.url',
            'references.authors','references.externalIds',
        ]);

        $res = $this->http()->get(self::S2."/paper/{$idOrQualified}", ['fields' => $fields]);
        if (!$res->successful()) return [];

        $refs = $res->json()['references'] ?? [];
        $out  = [];
        foreach ($refs as $p) {
            $out[] = $this->mapPaper($p, true);
            if (count($out) >= $max) break;
        }
        return $out;
    }

    private function getCitationsFromDetails(string $idOrQualified, int $max = 500): array
    {
        if (!$idOrQualified) return [];
        $fields = implode(',', [
            'citations.paperId','citations.title','citations.year','citations.url',
            'citations.authors','citations.externalIds',
        ]);

        $res = $this->http()->get(self::S2."/paper/{$idOrQualified}", ['fields' => $fields]);
        if (!$res->successful()) return [];

        $cits = $res->json()['citations'] ?? [];
        $out  = [];
        foreach ($cits as $p) {
            $out[] = $this->mapPaper($p, true);
            if (count($out) >= $max) break;
        }
        return $out;
    }

    /* ======================= UTIL ======================= */

    private function mapPaper(array $p, bool $includeId = false): array
    {
        return [
            'paperId' => $includeId ? ($p['paperId'] ?? null) : null,
            'title'   => $p['title'] ?? 'Título não disponível',
            'year'    => $p['year'] ?? null,
            'authors' => $this->authorsToString($p['authors'] ?? []),
            'doi'     => $p['externalIds']['DOI'] ?? null,
            'url'     => $p['url'] ?? null,
        ];
    }

    private function authorsToString(array $authors): string
    {
        if (!$authors) return '';
        $names = array_values(array_filter(array_map(fn($a) => $a['name'] ?? '', $authors)));
        return count($names) > 5 ? implode(', ', array_slice($names, 0, 5)).' et al.' : implode(', ', $names);
    }
}
