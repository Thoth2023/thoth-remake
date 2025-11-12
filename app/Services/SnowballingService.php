<?php

namespace App\Services;

use App\Jobs\ProcessReferences;
use App\Models\Project\Conducting\PaperSnowballing;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SnowballingService
{
    private const S2 = 'https://api.semanticscholar.org/graph/v1';

    /**
     * Híbrido Semantic Scholar: resolve título/doi e obtém refs/citações.
     */
    public function fetch(string $query): ?array
    {
        $q = trim($query);
        Log::info('Input de busca recebido no SnowballingService', ['query' => $q]);

        try {
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

            if (empty($references) && $seedDoi)
                $references = $this->getAllReferences("DOI:{$seedDoi}", $expectedRef);
            if (empty($references) && $corpusId)
                $references = $this->getAllReferences("CorpusId:{$corpusId}", $expectedRef);

            if (empty($citations) && $seedDoi)
                $citations = $this->getAllCitations("DOI:{$seedDoi}", $expectedCit);
            if (empty($citations) && $corpusId)
                $citations = $this->getAllCitations("CorpusId:{$corpusId}", $expectedCit);

            if (empty($references))
                $references = $this->getReferencesFromDetails($paperId, $expectedRef);
            if (empty($citations))
                $citations = $this->getCitationsFromDetails($paperId, $expectedCit);

            // OBS: cálculo de relevância é feito no pipeline iterativo com base no título do semente

            return compact('article', 'references', 'citations');

        } catch (\Throwable $e) {
            Log::error("Erro no Semantic Scholar: " . $e->getMessage(), [
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
            ->retry(3, 1000, throw: false);
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
            'source'  => 'SemanticScholar',
            'score'   => null,
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

    /**
     * Calcula relevância local (0..1) por similaridade de título.
     */
    private function computeLocalRelevance(?string $seedTitle, array $papers): array
    {
        if (!$seedTitle) return $papers;
        $seed = mb_strtolower($seedTitle);

        foreach ($papers as &$p) {
            $title = mb_strtolower($p['title'] ?? '');
            if (!$title) { $p['score'] = $p['score'] ?? null; continue; }
            similar_text($seed, $title, $pct);
            $score = round(($pct / 100), 3);
            // mantém score existente (se houver), senão aplica local
            $p['score'] = $p['score'] ?? $score;
        }
        return $papers;
    }

    /**
     * Obtém backward/forward de CrossRef + fallback SemanticScholar.
     * Adiciona a chave 'type_snowballing' em cada item.
     */
    public function getSnowballingData(string $doi): array
    {
        /** @var CrossrefCitedByService $crossref */
        $crossref = App::make(CrossrefCitedByService::class);

        $backward = collect($crossref->fetchReferences($doi))
            ->map(fn($r) => array_merge($r, ['type_snowballing' => 'backward']))
            ->toArray();

        $forward = collect($crossref->fetchCitedBy($doi))
            ->map(fn($r) => array_merge($r, ['type_snowballing' => 'forward']))
            ->toArray();

        // fallback via Semantic Scholar se necessário
        if (empty($backward) || empty($forward)) {
            $semantic = $this->fetch($doi);
            if (empty($backward)) {
                $backward = collect($semantic['references'] ?? [])
                    ->map(fn($r) => array_merge($r, ['type_snowballing' => 'backward']))
                    ->toArray();
            }
            if (empty($forward)) {
                $forward = collect($semantic['citations'] ?? [])
                    ->map(fn($r) => array_merge($r, ['type_snowballing' => 'forward']))
                    ->toArray();
            }
        }

        // relevance local com base no título do semente (CrossRef -> mais barato)
        $seedTitle = ($crossref->fetchWork($doi)['title'] ?? null) ?: null;
        $backward  = $this->computeLocalRelevance($seedTitle, $backward);
        $forward   = $this->computeLocalRelevance($seedTitle, $forward);

        return compact('backward', 'forward');
    }

    /**
     * Snowballing iterativo infinito (até esgotar novas entradas)
     * $modes: ['backward','forward'] (pode reduzir se já houver um deles no banco)
     */
    public function runIterativeSnowballing(string $seedDoi,int $seedPaperId,array $modes = ['backward','forward'],?callable $onProgress = null): void
    {
        $seedDoi = $this->normalizeDoi($seedDoi);
        Log::info("[Iterative] Iniciando para DOI {$seedDoi} com modos", $modes);

        $visited = [];
        $queue = [[ 'doi' => $seedDoi, 'depth' => 0, 'parent_id' => null ]];

        $processed = 0;
        $discovered = 0;
        $enqueued = 1;

        // inicializa progresso
        if ($onProgress) {
            $onProgress([
                'processed' => 0,
                'discovered'=> 0,
                'enqueued'  => 1,
                'progress'  => 0,
                'note'      => 'Iniciando snowballing...',
            ]);
        }

        while (!empty($queue)) {
            $current = array_shift($queue);
            $doi      = $current['doi'];
            $depth    = $current['depth'];
            $parentId = $current['parent_id'];

            if (!$doi || in_array($doi, $visited, true)) {
                continue;
            }
            $visited[] = $doi;

            $data = $this->getSnowballingData($doi);

            foreach ($modes as $mode) {
                $list = $data[$mode] ?? [];
                if (empty($list)) continue;

                foreach ($list as $ref) {
                    $parentSnowId = ($depth === 0) ? null : ($parentId ?: null);
                    $childId = $this->upsertSnowballingItem($ref, $seedPaperId, $mode, $parentSnowId);

                    $processed++;
                    if (!empty($ref['doi']) && !in_array($ref['doi'], $visited, true)) {
                        $queue[] = [
                            'doi'       => $ref['doi'],
                            'depth'     => $depth + 1,
                            'parent_id' => $childId,
                        ];
                        $enqueued++;
                    }
                }

                $discovered += count($list);
            }

            // Atualiza progresso
            if ($onProgress) {
                $progress = min(95, (int) round(($processed * 100) / max(1, $enqueued + $discovered/2)));
                $onProgress([
                    'processed' => $processed,
                    'discovered'=> $discovered,
                    'enqueued'  => $enqueued,
                    'progress'  => $progress,
                    'note'      => "Processando nível {$depth} ({$progress}%)",
                ]);
            }
        }

        // Finaliza progresso
        if ($onProgress) {
            $onProgress([
                'processed' => $processed,
                'discovered'=> $discovered,
                'enqueued'  => $enqueued,
                'progress'  => 100,
                'note'      => 'Snowballing concluído com sucesso.',
            ]);
        }

        Log::info('[Iterative] Finalizado para DOI '.$seedDoi, ['visitados' => count($visited)]);
    }


    /**
     * Upsert síncrono (similar ao Job ProcessReferences) para permitir encadeamento.
     */
    private function upsertSnowballingItem(array $ref, int $seedPaperId, string $type, ?int $parentId): int
    {
        // normalização de campos
        $doi     = $ref['DOI'] ?? $ref['doi'] ?? null;
        $title   = $ref['article-title'] ?? $ref['title'] ?? 'unknown';
        $authors = $ref['authors'] ?? $ref['author'] ?? null;
        $year    = $ref['year'] ?? null;
        $url     = $ref['URL'] ?? $ref['url'] ?? null;
        $source  = $ref['source'] ?? 'Unknown';
        $score   = $ref['score'] ?? null;

        // autores -> string
        if (is_array($authors)) {
            if (isset($authors[0]['given']) || isset($authors[0]['family'])) {
                $authors = implode('; ', array_map(fn($a) =>
                trim(($a['given'] ?? '') . ' ' . ($a['family'] ?? '')), $authors));
            } else {
                $authors = implode('; ', array_map(fn($a) =>
                    $a['name'] ?? (is_string($a) ? $a : ''), $authors));
            }
        }

        // duplicata?
        $existing = PaperSnowballing::query()
            ->when($doi, fn($q) => $q->where('doi', $doi))
            ->when(!$doi && $title, fn($q) => $q->where('title', $title))
            ->where('paper_reference_id', $seedPaperId)
            ->first();

        if ($existing) {
            // fonte
            $mergedSources = collect(explode(';', (string)$existing->source))
                ->merge([$source])
                ->filter()
                ->map(fn($s) => trim($s))
                ->unique()
                ->implode('; ');

            // score (média simples se vier um novo)
            if ($score !== null) {
                $existing->relevance_score = $existing->relevance_score
                    ? round(($existing->relevance_score + $score) / 2, 3)
                    : $score;
            }

            $existing->duplicate_count = ($existing->duplicate_count ?? 1) + 1;
            $existing->source = $mergedSources;
            // mantém o type_snowballing mais “forte”? aqui não alteramos
            $existing->save();

            return (int)$existing->id;
        }

        // criar novo
        $created = PaperSnowballing::create([
            'paper_reference_id'    => $seedPaperId,
            'parent_snowballing_id' => $parentId,
            'doi'                   => $doi,
            'title'                 => $title,
            'authors'               => $authors,
            'year'                  => $year,
            'url'                   => $url,
            'type'                  => $ref['type'] ?? 'unknown',
            'abstract'              => $ref['abstract'] ?? null,
            'bib_key'               => $ref['key'] ?? null,
            'type_snowballing'      => $type,
            'snowballing_process'   => 'automatic snowballing',
            'source'                => $source,
            'relevance_score'       => $score,
            'duplicate_count'       => 1,
            'is_duplicate'          => false,
            'is_relevant'           => null,
        ]);

        // metadados (CrossRef) se tiver DOI
        if ($doi) {
            try {
                // delega p/ job para manter padronização
                ProcessReferences::dispatch([['doi' => $doi]], [
                    'id_paper' => $seedPaperId,
                    'id'       => $created->id, // parent id irrelevante aqui; job só atualiza metadados
                ], $type);
            } catch (\Throwable $e) {
                Log::warning('[Iterative] Falha ao enfileirar atualização de metadados: '.$e->getMessage());
            }
        }

        return (int)$created->id;
    }

    /**
     * Executa apenas uma iteração simples (manual), sem recursão.
     * Tipo: 'backward' => referências diretas | 'forward' => citações diretas.
     * Inclui dados do Crossref e do Semantic Scholar.
     */
    public function processSingleIteration(string $doi, int $paperId, string $type, bool $iterate = false): void
    {
        $doi = $this->normalizeDoi($doi);
        Log::info("[Manual Snowballing] Iniciado", ['doi' => $doi, 'paperId' => $paperId, 'type' => $type]);

        $references = [];

        try {
            // Busca Crossref
            /** @var \App\Services\CrossrefCitedByService $crossref */
            $crossref = App::make(CrossrefCitedByService::class);

            if ($type === 'backward') {
                $cross = $crossref->fetchReferences($doi);
                $references = array_merge($references, $cross);
            } elseif ($type === 'forward') {
                $cross = $crossref->fetchCitedBy($doi);
                $references = array_merge($references, $cross);
            }

            // Fallback com Semantic Scholar se Crossref vazio
            if (empty($references)) {
                $semantic = $this->fetch($doi);

                if ($type === 'backward' && !empty($semantic['references'])) {
                    $references = $semantic['references'];
                } elseif ($type === 'forward' && !empty($semantic['citations'])) {
                    $references = $semantic['citations'];
                }
            }

            if (empty($references)) {
                Log::warning("[Manual Snowballing] Nenhuma referência encontrada.", [
                    'type' => $type, 'doi' => $doi
                ]);
                return;
            }

            // Adiciona metadados de tipo e fonte
            $references = collect($references)
                ->map(fn($r) => array_merge($r, [
                    'type_snowballing' => $type,
                    'source' => $r['source'] ?? 'CrossRef/SemanticScholar'
                ]))
                ->toArray();

            // Calcula relevância local apenas no contexto atual (sem iteração)
            $seedTitle = $crossref->fetchWork($doi)['title'] ?? null;
            $references = $this->computeLocalRelevance($seedTitle, $references);

            // Dispara o job de processamento (persistência)
            dispatch(new ProcessReferences(
                $references,
                ['id_paper' => $paperId, 'id' => null],
                $type
            ));

            // Iteração opcional (apenas se explicitamente solicitada)
            if ($iterate) {
                $this->runIterativeSnowballing($doi, $paperId, [$type]);
            }

            Log::info("[Manual Snowballing] Finalizado", [
                'type' => $type,
                'total' => count($references),
                'iterate' => $iterate
            ]);

        } catch (\Throwable $e) {
            Log::error("[Manual Snowballing] Erro", [
                'type' => $type,
                'doi' => $doi,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }



}
