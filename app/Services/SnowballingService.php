<?php

namespace App\Services;

use App\Jobs\ProcessReferences;
use App\Jobs\ProcessReferencesRelevant;
use App\Models\Project\Conducting\PaperSnowballing;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SnowballingService
{
    private const S2 = 'https://api.semanticscholar.org/graph/v1';

    /**
     * Enriquecimento em lote usando OpenAlex (títulos, autores, ano, URL).
     */
    private function enrichWithOpenAlex(array $refs): array
    {
        /** @var \App\Services\OpenAlexService $openalex */
        $openalex = app(OpenAlexService::class);

        return array_map(fn($r) => $openalex->enrich($r), $refs);
    }

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
     * Obtém backward/forward de CrossRef + Semantic Scholar + OpenAlex.
     * Adiciona 'type_snowballing', calcula relevância, e enriquece via OpenAlex.
     */
    public function getSnowballingData(string $doi): array
    {
        /** @var \App\Services\CrossrefCitedByService $crossref */
        $crossref = App::make(CrossrefCitedByService::class);

        // 1) CrossRef (fonte primária)
        $backward = collect($crossref->fetchReferences($doi))
            ->map(fn($r) => array_merge($r, ['type_snowballing' => 'backward']))
            ->toArray();

        $forward = collect($crossref->fetchCitedBy($doi))
            ->map(fn($r) => array_merge($r, ['type_snowballing' => 'forward']))
            ->toArray();

        // 2) FALLBACK #1 — Semantic Scholar
        if (empty($backward) || empty($forward)) {
            Log::info("[Snowballing] CrossRef não retornou resultados suficientes — ativando fallback S2/OpenAlex", [
                'doi' => $doi,
                'backward_found' => count($backward),
                'forward_found' => count($forward),
            ]);
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

        // 3) FALLBACK #2 — OpenAlex (se CrossRef + S2 falharem)
        if (empty($backward) || empty($forward)) {
            Log::info("[Snowballing] CrossRef não retornou resultados suficientes — ativando fallback S2/OpenAlex", [
                'doi' => $doi,
                'backward_found' => count($backward),
                'forward_found' => count($forward),
            ]);
            /** @var \App\Services\OpenAlexService $openalex */
            $openalex = app(OpenAlexService::class);

            if (empty($backward)) {
                $backRefs = $openalex->fetchReferences($doi);
                $backward = collect($backRefs)
                    ->map(fn($r) => array_merge($r, ['type_snowballing' => 'backward']))
                    ->toArray();

                Log::info("[Snowballing] Fallback OpenAlex usado para BACKWARD", [
                    'doi'   => $doi,
                    'total' => count($backward)
                ]);
            }

            if (empty($forward)) {
                $fwdRefs = $openalex->fetchCitations($doi);
                $forward = collect($fwdRefs)
                    ->map(fn($r) => array_merge($r, ['type_snowballing' => 'forward']))
                    ->toArray();

                Log::info("[Snowballing] Fallback OpenAlex usado para FORWARD", [
                    'doi'   => $doi,
                    'total' => count($forward)
                ]);
            }
        }

        // 4) Relevância local via título do seed (CrossRef)
        $seedTitle = ($crossref->fetchWork($doi)['title'] ?? null) ?: null;
        $backward  = $this->computeLocalRelevance($seedTitle, $backward);
        $forward   = $this->computeLocalRelevance($seedTitle, $forward);

        // 5) Enriquecimento obrigatório via OpenAlex
        $backward = $this->enrichWithOpenAlex($backward);
        $forward  = $this->enrichWithOpenAlex($forward);

        return compact('backward', 'forward');
    }

    /**
     * Snowballing iterativo (até esgotar novas entradas).
     * Mantém depth automático e ancestralidade via parent_snowballing_id.
     */
    public function runIterativeSnowballing(string $seedDoi,int $seedPaperId,array $modes = ['backward','forward'],?callable $onProgress = null): void {

        // Normaliza DOI (remove prefixos)
        $seedDoi = $this->normalizeDoi($seedDoi);
        Log::info("[Iterative] Iniciando para DOI {$seedDoi} com modos", $modes);

        $visited = []; // DOIs já processados → evita ciclos

        /**
         * O seed entra na fila com depth=0, mas NÃO grava no banco.
         * Ele serve apenas como ponto de expansão.
         */
        $queue = [[
            'doi'       => $seedDoi,
            'depth'     => 0,
            'parent_id' => null,
        ]];

        $processed  = 0;
        $discovered = 0;
        $enqueued   = 1;

        if ($onProgress) {
            $onProgress([
                'processed' => 0,
                'discovered'=> 0,
                'enqueued'  => 1,
                'progress'  => 0,
                'note'      => 'Iniciando snowballing...',
            ]);
        }

        // Loop principal (fila)
        while (!empty($queue)) {

            $current  = array_shift($queue);
            $doi      = $current['doi'];
            $depth    = $current['depth'];      // depth interno (0 = seed, não salvo)
            $parentId = $current['parent_id'];  // ancestral

            // ignora inválidos ou repetidos
            if (!$doi || in_array($doi, $visited, true)) {
                continue;
            }

            $visited[] = $doi;

            // obtém referências (CrossRef → S2 → OpenAlex)
            $data = $this->getSnowballingData($doi);

            foreach ($modes as $mode) {

                $list = $data[$mode] ?? [];
                if (empty($list)) continue;

                foreach ($list as $ref) {

                    /**
                     * REGRAS DE DEPTH E PARENT:
                     * - seed (depth=0) nunca é salvo
                     * - primeiro nível salvo = depth 1
                     * - parentSnowId = parentId (null no primeiro nível)
                     * - cada novo filho: depth = depth+1
                     */

                    $childDepth   = $depth + 1;
                    $parentSnowId = $parentId;

                    // salva / atualiza a referência
                    $childId = $this->upsertSnowballingItem(
                        $ref,
                        $seedPaperId,
                        $mode,
                        $parentSnowId,
                        $childDepth
                    );

                    $processed++;

                    // adiciona à fila para continuar expandindo
                    if (!empty($ref['doi']) && !in_array($ref['doi'], $visited, true)) {
                        $queue[] = [
                            'doi'       => $ref['doi'],
                            'depth'     => $childDepth,
                            'parent_id' => $childId,
                        ];
                        $enqueued++;
                    }
                }

                $discovered += count($list);
            }

            // progresso intermediário (até 95%)
            if ($onProgress) {
                $progress = min(
                    95,
                    (int) round(($processed * 100) / max(1, $enqueued + $discovered/2))
                );

                $onProgress([
                    'processed' => $processed,
                    'discovered'=> $discovered,
                    'enqueued'  => $enqueued,
                    'progress'  => $progress,
                    'note'      => "Processando nível {$depth} ({$progress}%)",
                ]);
            }
        }

        // Finalização (100%)
        if ($onProgress) {
            $onProgress([
                'processed' => $processed,
                'discovered'=> $discovered,
                'enqueued'  => $enqueued,
                'progress'  => 100,
                'note'      => 'Snowballing concluído com sucesso.',
            ]);
        }

        Log::info('[Iterative] Finalizado para DOI '.$seedDoi, [
            'visitados' => count($visited)
        ]);
    }



    /**
     * Heurística TF-IDF anti-duplicação com título.
     * - Carrega títulos já existentes para o seedPaperId
     * - Calcula similaridade coseno entre o novo título e cada um
     * - Se similaridade >= threshold, considera duplicata
     */
    private function findDuplicateByTfIdf(int $seedPaperId, string $title, float $threshold = 0.9): ?PaperSnowballing
    {
        $title = trim($title);
        if ($title === '') {
            return null;
        }

        $candidates = PaperSnowballing::where('paper_reference_id', $seedPaperId)
            ->whereNotNull('title')
            ->get(['id', 'title']);

        if ($candidates->isEmpty()) {
            return null;
        }

        // Tokenização simples
        $tokenize = function (string $t): array {
            $t = mb_strtolower($t);
            $t = preg_replace('/[^a-z0-9á-úà-ùâ-ûã-õç\s]/iu', ' ', $t);
            $parts = preg_split('/\s+/', $t, -1, PREG_SPLIT_NO_EMPTY);
            return $parts ?: [];
        };

        $newTokens = $tokenize($title);
        if (empty($newTokens)) {
            return null;
        }

        // Documentos = títulos existentes + novo
        $docs = [];
        $docs['__new__'] = $newTokens;

        foreach ($candidates as $cand) {
            $docs[$cand->id] = $tokenize($cand->title);
        }

        // Calcula DF (document frequency)
        $df = [];
        foreach ($docs as $docTokens) {
            $unique = array_unique($docTokens);
            foreach ($unique as $term) {
                $df[$term] = ($df[$term] ?? 0) + 1;
            }
        }

        $N = count($docs); // total de "documentos" (títulos)

        // Função para vetor TF-IDF
        $buildVector = function (array $tokens) use ($df, $N): array {
            if (!$tokens) return [];
            $tf = [];
            foreach ($tokens as $t) {
                $tf[$t] = ($tf[$t] ?? 0) + 1;
            }
            $vec = [];
            foreach ($tf as $term => $freq) {
                $dfTerm = $df[$term] ?? 1;
                $idf    = log(($N + 1) / ($dfTerm + 1)) + 1;
                $vec[$term] = $freq * $idf;
            }
            return $vec;
        };

        $vNew = $buildVector($newTokens);

        // Cosine similarity
        $cosine = function (array $a, array $b): float {
            if (!$a || !$b) return 0.0;
            $dot = 0.0;
            $normA = 0.0;
            $normB = 0.0;

            foreach ($a as $term => $valA) {
                $normA += $valA * $valA;
                if (isset($b[$term])) {
                    $dot += $valA * $b[$term];
                }
            }
            foreach ($b as $valB) {
                $normB += $valB * $valB;
            }

            if ($normA <= 0.0 || $normB <= 0.0) {
                return 0.0;
            }

            return $dot / (sqrt($normA) * sqrt($normB));
        };

        $bestSim = 0.0;
        $bestId  = null;

        foreach ($candidates as $cand) {
            $tokens = $docs[$cand->id] ?? [];
            if (!$tokens) continue;

            $vCand = $buildVector($tokens);
            $sim   = $cosine($vNew, $vCand);

            if ($sim > $bestSim) {
                $bestSim = $sim;
                $bestId  = $cand->id;
            }
        }

        if ($bestId && $bestSim >= $threshold) {
            Log::info('[Snowballing][TF-IDF] Duplicata detectada por título', [
                'seedPaperId' => $seedPaperId,
                'similarity'  => $bestSim,
                'id_match'    => $bestId,
            ]);

            return PaperSnowballing::find($bestId);
        }

        return null;
    }

    /**
     * Upsert síncrono utilizado pela versão iterativa.
     * - Enriquecimento obrigatório via OpenAlex
     * - Normaliza metadados
     * - Anti-duplicação (DOI → título exato → TF-IDF)
     * - Atualiza contador de duplicidade e relevância
     * - Integra com módulo de screening (se existir)
     * - Agora armazena depth e ancestralidade
     */
    private function upsertSnowballingItem(array $ref,int $seedPaperId,string $type,?int $parentId,int $depth): int {

        // 1) Enriquecimento via OpenAlex (título, autores, ano, URL, source)
        /** @var \App\Services\OpenAlexService $openalex */
        $openalex = app(OpenAlexService::class);
        $ref = $openalex->enrich($ref);

        // 2) Normalização
        $doi     = $ref['DOI'] ?? $ref['doi'] ?? null;
        $title   = $ref['article-title'] ?? $ref['title'] ?? 'unknown';
        $authors = $ref['authors'] ?? $ref['author'] ?? null;
        $year    = $ref['year'] ?? null;
        $url     = $ref['URL'] ?? $ref['url'] ?? null;
        $source  = $ref['source'] ?? 'Unknown';
        $score   = $ref['score'] ?? null;

        // 3) Autores → string unificada
        if (is_array($authors)) {
            if (isset($authors[0]['given']) || isset($authors[0]['family'])) {
                $authors = implode('; ', array_map(
                    fn($a) => trim(($a['given'] ?? '') . ' ' . ($a['family'] ?? '')),
                    $authors
                ));
            } else {
                $authors = implode('; ', array_map(
                    fn($a) => $a['name'] ?? (is_string($a) ? $a : ''),
                    $authors
                ));
            }
        }

        // 4) Anti-duplicação (DOI → título → TF-IDF)
        $existing = PaperSnowballing::query()
            ->when($doi, fn($q) => $q->where('doi', $doi))
            ->when(!$doi && $title, fn($q) => $q->where('title', $title))
            ->where('paper_reference_id', $seedPaperId)
            ->first();

        if (!$existing && $title && $title !== 'unknown') {
            // fallback TF-IDF
            $existing = $this->findDuplicateByTfIdf($seedPaperId, $title);
        }

        if ($existing) {

            // Mescla fontes
            $mergedSources = collect(explode(';', (string)$existing->source))
                ->merge([$source])
                ->filter()
                ->map(fn($s) => trim($s))
                ->unique()
                ->implode('; ');

            // Atualiza relevância média
            if ($score !== null) {
                $existing->relevance_score = $existing->relevance_score
                    ? round(($existing->relevance_score + $score) / 2, 3)
                    : $score;
            }

            $existing->duplicate_count = ($existing->duplicate_count ?? 1) + 1;
            $existing->source          = $mergedSources;

            /**
             * IMPORTANTE:
             * Não alteramos depth nem parent_snowballing_id.
             * Isso preserva a ancestralidade correta da primeira aparição.
             */
            $existing->save();

            return (int) $existing->id;
        }

        // 5) Criação de novo registro com DEPTH correto
        $created = PaperSnowballing::create([
            'paper_reference_id'    => $seedPaperId,
            'parent_snowballing_id' => $parentId,
            'depth'                 => $depth,
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

        // 6) Atualiza metadados (CrossRef) — opcional e assíncrono
        if ($doi) {
            try {
                ProcessReferences::dispatch(
                    [['doi' => $doi]],
                    ['id_paper' => $seedPaperId, 'id' => $created->id],
                    $type
                )->onQueue('snowballing');
            } catch (\Throwable $e) {
                Log::warning('[Iterative] Falha ao enfileirar atualização de metadados: '.$e->getMessage());
            }
        }

        return (int) $created->id;
    }


    /**
     * Execução manual (uma iteração) sem recursão.
     * Usa CrossRef → Semantic → OpenAlex, com relevância local e enriquecimento.
     */
    public function processSingleIteration(string $doi, int $paperId, string $type, bool $iterate = false): void
    {
        $doi = $this->normalizeDoi($doi);
        Log::info("[Manual Snowballing] Iniciado", ['doi' => $doi, 'paperId' => $paperId, 'type' => $type]);

        $references = [];

        try {
            // 1) CrossRef (fonte primária)
            /** @var \App\Services\CrossrefCitedByService $crossref */
            $crossref = App::make(CrossrefCitedByService::class);

            if ($type === 'backward') {
                $cross = $crossref->fetchReferences($doi);
                $references = array_merge($references, $cross);
            } elseif ($type === 'forward') {
                $cross = $crossref->fetchCitedBy($doi);
                $references = array_merge($references, $cross);
            }

            // 2) FALLBACK #1 — Semantic Scholar
            if (empty($references)) {
                $semantic = $this->fetch($doi);

                if ($type === 'backward' && !empty($semantic['references'])) {
                    $references = $semantic['references'];
                } elseif ($type === 'forward' && !empty($semantic['citations'])) {
                    $references = $semantic['citations'];
                }
            }

            // 3) FALLBACK #2 — OpenAlex
            if (empty($references)) {
                /** @var \App\Services\OpenAlexService $openalex */
                $openalex = app(OpenAlexService::class);

                if ($type === 'backward') {
                    $references = $openalex->fetchReferences($doi);
                } else {
                    $references = $openalex->fetchCitations($doi);
                }
            }

            // 4) Nenhuma fonte retornou resultados
            if (empty($references)) {
                Log::warning("[Manual Snowballing] Nenhuma referência encontrada.", [
                    'type' => $type, 'doi' => $doi
                ]);
                return;
            }

            // 5) Tipo + fonte
            $references = collect($references)
                ->map(fn($r) => array_merge($r, [
                    'type_snowballing' => $type,
                    'source' => $r['source'] ?? 'CrossRef/SemanticScholar/OpenAlex'
                ]))
                ->toArray();

            // 6) Relevância local pelo título do seed
            $seedTitle = $crossref->fetchWork($doi)['title'] ?? null;
            $references = $this->computeLocalRelevance($seedTitle, $references);

            // 7) Enriquecimento via OpenAlex
            $references = $this->enrichWithOpenAlex($references);

            // 8) Persiste via job ProcessReferences
            dispatch(new ProcessReferences($references,['id_paper' => $paperId, 'id' => null],$type))->onQueue('snowballing');

            Log::info("[Manual Snowballing] Finalizado", [
                'type'    => $type,
                'total'   => count($references),
                'iterate' => $iterate
            ]);

        } catch (\Throwable $e) {
            Log::error("[Manual Snowballing] Erro", [
                'type'  => $type,
                'doi'   => $doi,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }

    /**
     * Execução manual de snowballing em “relevantes”.
     * Similar ao anterior, mas dispara ProcessReferencesRelevant.
     */
    public function processSingleIterationRelevant(string $doi,int $paperBaseId,int $parentSnowId,string $type): void {
        $doi = $this->normalizeDoi($doi);

        Log::info("[Relevant Snowballing] Iniciado", [
            'doi'       => $doi,
            'parent_id' => $parentSnowId,
            'paper'     => $paperBaseId,
            'type'      => $type
        ]);

        $references = [];

        try {
            // 1) CrossRef
            /** @var \App\Services\CrossrefCitedByService $crossref */
            $crossref = App::make(CrossrefCitedByService::class);

            if ($type === 'backward') {
                $cross = $crossref->fetchReferences($doi);
                $references = array_merge($references, $cross);
            } elseif ($type === 'forward') {
                $cross = $crossref->fetchCitedBy($doi);
                $references = array_merge($references, $cross);
            }

            // 2) Semantic Scholar
            if (empty($references)) {
                $semantic = $this->fetch($doi);

                if ($type === 'backward' && !empty($semantic['references'])) {
                    $references = $semantic['references'];
                } elseif ($type === 'forward' && !empty($semantic['citations'])) {
                    $references = $semantic['citations'];
                }
            }

            // 3) OpenAlex
            if (empty($references)) {
                /** @var \App\Services\OpenAlexService $openalex */
                $openalex = app(OpenAlexService::class);

                if ($type === 'backward') {
                    $references = $openalex->fetchReferences($doi);
                } else {
                    $references = $openalex->fetchCitations($doi);
                }
            }

            // 4) Nenhum resultado
            if (empty($references)) {
                Log::warning("[Relevant Snowballing] Nenhuma referência encontrada.", [
                    'doi'  => $doi,
                    'type' => $type
                ]);
                return;
            }

            // 5) Tipo + fonte
            $references = collect($references)
                ->map(fn($r) => array_merge($r, [
                    'type_snowballing' => $type,
                    'source'           => $r['source'] ?? 'CrossRef/SemanticScholar/OpenAlex'
                ]))
                ->toArray();

            // 6) Relevância local
            $seedTitle = $crossref->fetchWork($doi)['title'] ?? null;
            $references = $this->computeLocalRelevance($seedTitle, $references);

            // 7) Enriquecimento via OpenAlex
            $references = $this->enrichWithOpenAlex($references);

            // 8) Job específico
            dispatch(new ProcessReferencesRelevant($references,$paperBaseId,$parentSnowId,$type))->onQueue('snowballing');

            Log::info("[Relevant Snowballing] Finalizado", [
                'type'      => $type,
                'total'     => count($references),
                'parent_id' => $parentSnowId
            ]);

        } catch (\Throwable $e) {
            Log::error("[Relevant Snowballing] Erro", [
                'doi'   => $doi,
                'type'  => $type,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }

}
