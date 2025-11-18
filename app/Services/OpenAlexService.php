<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class OpenAlexService
{
    private const API = 'https://api.openalex.org/works';

    /**
     * Retorna e-mail obrigatório para Polite Pool.
     */
    private function mailto(): string
    {
        return config('services.openalex.mailto')
            ?? env('OPENALEX_MAILTO')
            ?? 'thothslr@gmail.com';
    }

    /**
     * Cliente HTTP com User-Agent + Polite Pool
     */
    private function http()
    {
        return Http::withHeaders([
            'User-Agent' => 'Thoth-SLR/1.0 (mailto=' . $this->mailto() . ')',
            'Accept'     => 'application/json',
        ])
            ->timeout(20)
            ->retry(3, 1000)
            ->acceptJson();
    }

    // FETCH BY DOI

    /**
     * Busca um trabalho pelo DOI usando OpenAlex.
     * Retorna SEMPRE dados normalizados incluindo `id` (W123...).
     */
    public function fetchByDoi(string $doi): ?array
    {
        $doi = strtolower(trim($doi));
        $cacheKey = "openalex_doi_" . md5($doi);

        return Cache::remember($cacheKey, now()->addDays(7), function () use ($doi) {
            $url = self::API . "/doi:" . urlencode($doi);

            $response = $this->http()->get($url, [
                'mailto' => $this->mailto(),
            ]);

            if (!$response->successful()) {
                Log::warning("[OpenAlex] Falha ao consultar DOI '{$doi}'", [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return null;
            }

            $data = $response->json();
            if (!$data || empty($data['id'])) {
                Log::warning("[OpenAlex] Resposta sem 'id' para DOI '{$doi}'");
                return null;
            }

            return $this->mapWork($data);
        });
    }

    /**
     * Converte o JSON bruto da OpenAlex para nosso formato padronizado.
     */
    private function mapWork(array $w): array
    {
        return [
            'id'      => $w['id'] ?? null,  // ESSENCIAL para referenced_works e cited-by
            'title'   => $w['title'] ?? null,
            'year'    => $w['publication_year'] ?? null,
            'url'     => $w['primary_location']['landing_page_url']
                ?? $w['primary_location']['pdf_url']
                    ?? null,
            'authors' => $this->authorsToString($w['authorships'] ?? []),
            'doi'     => $w['doi'] ?? null,
            'source'  => 'OpenAlex',
            'score'   => null,
        ];
    }

    private function authorsToString(array $authorships): string
    {
        $names = array_map(
            fn($a) => $a['author']['display_name'] ?? null,
            $authorships
        );

        return implode(', ', array_filter($names));
    }

    // ENRICH


    /**
     * Enriquecimento obrigatório via OpenAlex
     */
    public function enrich(array $item): array
    {
        $doi = $item['doi'] ?? null;
        if (!$doi) return $item;

        $oa = $this->fetchByDoi($doi);
        if (!$oa) return $item;

        return [
            'id'      => $oa['id']     ?? ($item['id']     ?? null),
            'doi'     => $doi,
            'title'   => $oa['title']  ?? ($item['title']  ?? null),
            'authors' => $oa['authors']?? ($item['authors']?? null),
            'year'    => $oa['year']   ?? ($item['year']   ?? null),
            'url'     => $oa['url']    ?? ($item['url']    ?? null),
            'source'  => trim(($item['source'] ?? '') . '; OpenAlex'),
            'score'   => $item['score'] ?? null,
            'type_snowballing' => $item['type_snowballing'] ?? null,
        ];
    }


    // FETCH REFERENCES (BACKWARD)
    public function fetchReferences(string $doi): array
    {
        $seed = $this->fetchByDoi($doi);
        if (!$seed || empty($seed['id'])) {
            return [];
        }

        $workId = $seed['id'];   // Ex: "https://openalex.org/W1234..."
        $shortId = basename($workId);

        $cacheKey = "openalex_refs_" . md5($shortId);

        return Cache::remember($cacheKey, now()->addDays(7), function () use ($shortId) {

            $response = $this->http()->get(self::API . "/{$shortId}", [
                'mailto' => $this->mailto(),
                'select' => 'referenced_works'
            ]);

            if (!$response->successful()) {
                return [];
            }

            $json = $response->json();
            $ids = $json['referenced_works'] ?? [];

            if (empty($ids)) return [];

            $refs = [];
            foreach ($ids as $workFullId) {

                $wid = basename($workFullId);

                $w = $this->http()->get(self::API . "/{$wid}", [
                    'mailto' => $this->mailto(),
                ]);

                if (!$w->successful()) continue;
                $data = $w->json();

                $refs[] = $this->mapWork($data);
            }

            return $refs;
        });
    }

    // FETCH CITATIONS (FORWARD)

    public function fetchCitations(string $doi): array
    {
        $seed = $this->fetchByDoi($doi);
        if (!$seed || empty($seed['id'])) {
            return [];
        }

        $shortId = basename($seed['id']);
        $cacheKey = "openalex_cits_" . md5($shortId);

        return Cache::remember($cacheKey, now()->addDays(7), function () use ($shortId) {

            $citations = [];
            $cursor = '*';

            // paginação cursor-based
            while ($cursor) {

                $res = $this->http()->get(self::API . "/{$shortId}/cited-by", [
                    'mailto' => $this->mailto(),
                    'per-page' => 200,
                    'cursor' => $cursor
                ]);

                if (!$res->successful()) break;

                $json = $res->json();
                $results = $json['results'] ?? [];

                foreach ($results as $r) {
                    if (!isset($r['citing_work'])) continue;
                    $citations[] = $this->mapWork($r['citing_work']);
                }

                // próxima página
                $cursor = $json['meta']['next_cursor'] ?? null;
            }

            return $citations;
        });
    }
}
