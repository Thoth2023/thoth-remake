<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SnowballingService
{
    private const S2 = 'https://api.semanticscholar.org/graph/v1';

    public function fetch(string $query): ?array
    {
        $q = trim($query);
        Log::info('Input de busca recebido no SnowballingService', ['query' => $q]);

        try {
            // 1) Detectar se é DOI ou título
            if ($this->isLikelyDoi($q)) {
                $doi  = $this->normalizeDoi($q);
                $seed = $this->getByDoi($doi);
            } else {
                $seed = $this->resolveTitle($q);
            }

            if (!$seed || empty($seed['paperId'])) {
                Log::warning("Nenhum resultado encontrado para '{$q}'");
                return null;
            }

            $paperId  = $seed['paperId'];
            $seedDoi  = $seed['externalIds']['DOI'] ?? null;
            $corpusId = $seed['corpusId'] ?? ($seed['externalIds']['CorpusId'] ?? null);

            $details = $this->getDetails($paperId);
            if (!$details) return null;

            // Preferir metadados atualizados
            $seedDoi  = $details['externalIds']['DOI'] ?? $seedDoi;
            $corpusId = $details['corpusId'] ?? $corpusId;

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

            $references = $this->getAllReferences($paperId, $expectedRef);
            $citations  = $this->getAllCitations($paperId,  $expectedCit);

            // Fallbacks
            if (empty($references) && $seedDoi)
                $references = $this->getAllReferences("DOI:{$seedDoi}", $expectedRef);
            if (empty($references) && $corpusId)
                $references = $this->getAllReferences("CorpusId:{$corpusId}", $expectedRef);

            if (empty($citations) && $seedDoi)
                $citations = $this->getAllCitations("DOI:{$seedDoi}", $expectedCit);
            if (empty($citations) && $corpusId)
                $citations = $this->getAllCitations("CorpusId:{$corpusId}", $expectedCit);

            // Fallback final via detalhes expandidos
            if (empty($references))
                $references = $this->getReferencesFromDetails($paperId, $expectedRef);
            if (empty($citations))
                $citations = $this->getCitationsFromDetails($paperId, $expectedCit);

            return compact('article', 'references', 'citations');

        } catch (\Throwable $e) {
            Log::error("Erro ao buscar dados no Semantic Scholar: " . $e->getMessage(), [
                'query' => $q,
                'trace' => $e->getTraceAsString(),
            ]);
            return null;
        }
    }

    private function http()
    {
        $key = config('services.semantic_scholar.key');
        $headers = [
            'User-Agent' => 'Thoth-SLR/1.0',
            'Accept' => 'application/json',
        ];

        if ($key) {
            $headers['x-api-key'] = $key;
            Log::info('S2_API_KEY aplicada com sucesso.');
        } else {
            Log::warning('S2_API_KEY NÃO definida no .env ou services.php');
        }

        return Http::withHeaders($headers)
            ->timeout(30)
            ->retry(3, 1000, throw: false); // tenta 3x, espera 1s entre tentativas
    }

    public function isLikelyDoi(string $q): bool
    {
        $clean = strtolower(trim($q));
        return preg_match('/^10\.\d{4,9}\/\S+$/', $clean) ||
            str_starts_with($clean, 'doi:') ||
            str_contains($clean, 'doi.org/');
    }

    private function normalizeDoi(string $raw): string
    {
        return preg_replace('#^(https?://(dx\.)?doi\.org/|doi:\s*)#i', '', trim($raw));
    }

    private function resolveTitle(string $title): ?array
    {
        $clean = preg_replace('/\s+/', ' ', trim($title));
        $clean = str_replace(['"', "'"], '', $clean);

        $match = $this->http()->get(self::S2.'/paper/search/match', [
            'query' => $clean,
            'fields' => 'paperId,corpusId,title,year,authors,url,externalIds'
        ]);

        if ($match->status() === 404) {
            Log::info('resolveTitle /match: 404', ['query' => $clean]);
        } elseif ($match->successful() && $match->json('paperId')) {
            return $match->json();
        }

        $fallback = $this->http()->get(self::S2.'/paper/search', [
            'query' => $clean,
            'limit' => 1,
            'offset' => 0,
            'fields' => 'paperId,corpusId,title,year,authors,url,externalIds'
        ]);

        if ($fallback->successful() && !empty($fallback->json('data.0.paperId'))) {
            return $fallback->json('data.0');
        }

        Log::warning('resolveTitle fallback falhou', [
            'query' => $clean,
            'status' => $fallback->status(),
            'body' => $fallback->body(),
        ]);

        return null;
    }

    private function getByDoi(string $doi): ?array
    {
        $res = $this->http()->get(self::S2."/paper/DOI:{$doi}", [
            'fields' => 'paperId,corpusId,title,year,authors,url,externalIds'
        ]);
        return $res->successful() ? $res->json() : null;
    }

    private function getDetails(string $paperId): ?array
    {
        $fields = implode(',', [
            'paperId','corpusId','title','year','abstract','authors','url','externalIds',
            'referenceCount','citationCount',
        ]);
        $res = $this->http()->get(self::S2."/paper/{$paperId}", ['fields' => $fields]);
        return $res->successful() ? $res->json() : null;
    }

    private function getAllReferences(string $id, int $max = 100): array
    {
        return $this->getAll($id, 'references', 'citedPaper', $max);
    }

    private function getAllCitations(string $id, int $max = 100): array
    {
        return $this->getAll($id, 'citations', 'citingPaper', $max);
    }

    private function getAll(string $id, string $type, string $field, int $max): array
    {
        $results = [];
        $offset = 0;
        $limit = min(100, max(25, $max));
        $fields = "{$field}.paperId,{$field}.title,{$field}.year,{$field}.url,{$field}.authors,{$field}.externalIds";

        while (count($results) < $max) {
            $res = $this->http()->get(self::S2."/paper/{$id}/{$type}", compact('fields','limit','offset'));
            if (!$res->successful()) break;

            $chunk = $res->json('data') ?? [];
            foreach ($chunk as $row) {
                $paper = $row[$field] ?? null;
                if (!$paper) continue;
                $results[] = $this->mapPaper($paper);
                if (count($results) >= $max) break;
            }

            if (count($chunk) < $limit) break;
            $offset += $limit;
        }

        return $results;
    }

    private function getReferencesFromDetails(string $id, int $max = 100): array
    {
        $res = $this->http()->get(self::S2."/paper/{$id}", [
            'fields' => 'references.paperId,references.title,references.year,references.url,references.authors,references.externalIds',
        ]);

        if (!$res->successful()) return [];

        $refs = $res->json('references') ?? [];

        return collect($refs)->take($max)->map(fn($p) => $this->mapPaper($p))->toArray();
    }

    private function getCitationsFromDetails(string $id, int $max = 100): array
    {
        $res = $this->http()->get(self::S2."/paper/{$id}", [
            'fields' => 'citations.paperId,citations.title,citations.year,citations.url,citations.authors,citations.externalIds',
        ]);

        if (!$res->successful()) return [];

        $cits = $res->json('citations') ?? [];

        return collect($cits)->take($max)->map(fn($p) => $this->mapPaper($p))->toArray();
    }

    private function mapPaper(array $p): array
    {
        return [
            'paperId' => $p['paperId'] ?? null,
            'title'   => $p['title'] ?? 'Sem título',
            'year'    => $p['year'] ?? null,
            'authors' => $this->authorsToString($p['authors'] ?? []),
            'doi'     => $p['externalIds']['DOI'] ?? null,
            'url'     => $p['url'] ?? null,
        ];
    }

    private function authorsToString(array $authors): string
    {
        $names = array_map(fn($a) => $a['name'] ?? '', $authors);
        $filtered = array_filter($names);
        return count($filtered) > 5
            ? implode(', ', array_slice($filtered, 0, 5)) . ' et al.'
            : implode(', ', $filtered);
    }
}
