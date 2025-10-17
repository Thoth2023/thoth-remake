<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CrossrefCitedByService
{
    private string $baseUrl = 'https://api.crossref.org/works';
    private string $mailto;

    public function __construct()
    {
        $this->mailto = config('services.crossref.mailto', 'thothslr@gmail.com');
    }

    /**
     * Cria cliente HTTP com identificação "polite"
     */
    private function http()
    {
        return Http::withHeaders([
            'User-Agent' => 'Thoth-SLR (mailto:' . $this->mailto . ')',
            'Accept'     => 'application/json',
        ])->timeout(20)->retry(3, 1000);
    }

    /**
     * FORWARD (citações) via CrossRef /works/{doi}/cited-by
     */
    public function fetchCitedBy(string $doi): array
    {
        $doi = $this->normalizeDoi($doi);
        $url = "{$this->baseUrl}/{$doi}/cited-by?mailto=" . urlencode($this->mailto);
        Log::info("[Crossref] Buscando citações (Cited-by)", ['url' => $url]);

        try {
            $response = $this->http()->get($url);

            if ($response->status() === 404) {
                Log::warning("[Crossref] Nenhuma citação encontrada (404)", ['doi' => $doi]);
                return [];
            }

            if (!$response->successful()) {
                Log::warning("[Crossref] Falha ao buscar citações", [
                    'status' => $response->status(),
                    'url'    => $url,
                ]);
                return [];
            }

            $items = $response->json('message.items') ?? [];
            return collect($items)->map(function ($i) {
                $title   = $i['title'][0] ?? 'Sem título';
                $year    = $i['issued']['date-parts'][0][0] ?? null;
                $idDoi   = $i['DOI'] ?? null;
                $url     = $i['URL'] ?? ($idDoi ? "https://doi.org/{$idDoi}" : null);
                $authors = collect($i['author'] ?? [])
                    ->map(fn($a) => trim(($a['family'] ?? '') . ', ' . ($a['given'] ?? '')))
                    ->filter()
                    ->implode('; ');

                return [
                    'title'   => $title,
                    'year'    => $year,
                    'doi'     => $idDoi,
                    'url'     => $url,
                    'authors' => $authors ?: null,
                    'source'  => 'CrossRef',
                    'score'   => null,
                ];
            })->toArray();

        } catch (\Throwable $e) {
            Log::error("[Crossref] Erro no Cited-by", [
                'doi'   => $doi,
                'error' => $e->getMessage(),
            ]);
            return [];
        }
    }

    /**
     * BACKWARD (referências) via CrossRef /works/{doi}
     */
    public function fetchReferences(string $doi): array
    {
        $doi = $this->normalizeDoi($doi);
        $url = "{$this->baseUrl}/{$doi}?mailto=" . urlencode($this->mailto);
        Log::info("[Crossref] Buscando referências (backward)", ['url' => $url]);

        try {
            $res = $this->http()->get($url);
            if (!$res->successful()) {
                Log::warning("[Crossref] Falha ao buscar referências", [
                    'status' => $res->status(),
                    'url'    => $url,
                ]);
                return [];
            }

            $refs = $res->json('message.reference') ?? [];
            return collect($refs)->map(function ($r) {
                $idDoi = $r['DOI'] ?? $r['doi'] ?? null;

                // autores podem vir como array de objetos ou string
                $authors = null;
                if (isset($r['author'])) {
                    if (is_array($r['author'])) {
                        $authors = implode('; ', array_map(
                            fn($a) => trim(($a['given'] ?? '') . ' ' . ($a['family'] ?? '')),
                            $r['author']
                        ));
                    } elseif (is_string($r['author'])) {
                        $authors = $r['author'];
                    }
                }

                return [
                    'title'   => $r['article-title'] ?? $r['journal-title'] ?? 'Sem título',
                    'year'    => $r['year'] ?? null,
                    'doi'     => $idDoi,
                    'url'     => $idDoi ? "https://doi.org/{$idDoi}" : null,
                    'authors' => $authors,
                    'source'  => 'CrossRef',
                    'score'   => null,
                ];
            })
                ->filter(fn($r) => !empty($r['title']) || !empty($r['doi']))
                ->unique('doi')
                ->values()
                ->toArray();

        } catch (\Throwable $e) {
            Log::error("[Crossref] Erro ao buscar referências", [
                'doi'   => $doi,
                'error' => $e->getMessage(),
            ]);
            return [];
        }
    }

    /**
     * Metadados básicos (título) — usado para relevância local
     */
    public function fetchWork(string $doi): array
    {
        $doi = $this->normalizeDoi($doi);
        $url = "{$this->baseUrl}/{$doi}?mailto=" . urlencode($this->mailto);
        Log::info("[Crossref] FetchWork", ['url' => $url]);

        try {
            $res = $this->http()->get($url);
            if (!$res->successful()) {
                Log::warning("[Crossref] Falha no fetchWork", ['status' => $res->status()]);
                return [];
            }

            return [
                'title' => $res->json('message.title.0') ?? null,
            ];
        } catch (\Throwable $e) {
            Log::warning("[Crossref] Erro em fetchWork", [
                'doi'   => $doi,
                'error' => $e->getMessage(),
            ]);
            return [];
        }
    }

    /**
     * Normaliza DOIs (remove prefixos e URLs)
     */
    private function normalizeDoi(string $raw): string
    {
        return preg_replace('#^(https?://(dx\.)?doi\.org/|doi:\s*)#i', '', trim($raw));
    }
}
