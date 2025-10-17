<?php

namespace App\Jobs;

use App\Models\Project\Conducting\PaperSnowballing;
use App\Services\SnowballingService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProcessReferences implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected array $references;
    protected array $paper;
    protected string $type;

    public function __construct(array $references, array $paper, string $type)
    {
        $this->references = $references;
        $this->paper = $paper;
        $this->type = $type; // backward | forward | automatic
    }

    public function handle()
    {
        Log::info("Job ProcessReferences iniciado", [
            'type' => $this->type,
            'paper_id' => $this->paper['id_paper'] ?? null,
            'reference_id' => $this->paper['id'] ?? null,
            'total_references' => count($this->references),
        ]);

        if (empty($this->references)) {
            Log::warning("Nenhuma referência fornecida para processamento.");
            return;
        }

        foreach ($this->references as $ref) {
            // normalize
            $doi     = $ref['DOI'] ?? $ref['doi'] ?? null;
            $title   = $ref['article-title'] ?? $ref['title'] ?? null;
            $authors = $ref['authors'] ?? $ref['author'] ?? null;
            $year    = $ref['year'] ?? null;
            $url     = $ref['URL'] ?? $ref['url'] ?? null;
            $source  = $ref['source'] ?? 'CrossRef';
            $score   = $ref['score'] ?? null;

            if (!$doi && !$title) {
                Log::warning("Ref ignorada: sem DOI e título");
                continue;
            }

            // duplicata no contexto do semente
            $existing = PaperSnowballing::query()
                ->when($doi, fn($q) => $q->where('doi', $doi))
                ->when(!$doi && $title, fn($q) => $q->where('title', $title))
                ->where(function ($q) {
                    $q->where('paper_reference_id', $this->paper['id_paper'] ?? null)
                        ->orWhere('parent_snowballing_id', $this->paper['id'] ?? null);
                })
                ->first();

            if ($existing) {
                $existing->duplicate_count = ($existing->duplicate_count ?? 1) + 1;

                if ($score !== null) {
                    $existing->relevance_score = $existing->relevance_score
                        ? round(($existing->relevance_score + $score) / 2, 3)
                        : $score;
                }

                $mergedSources = collect(explode(';', (string)$existing->source))
                    ->merge([$source])
                    ->filter()
                    ->map(fn($s) => trim($s))
                    ->unique()
                    ->implode('; ');

                $existing->source = $mergedSources;
                $existing->save();
                continue;
            }

            // parent id válido?
            $parentId = null;
            if (!empty($this->paper['id'])) {
                if (PaperSnowballing::where('id', $this->paper['id'])->exists()) {
                    $parentId = $this->paper['id'];
                }
            }

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

            $created = PaperSnowballing::create([
                'paper_reference_id'    => $this->paper['id_paper'] ?? null,
                'parent_snowballing_id' => $parentId,
                'doi'      => $doi,
                'title'    => $title ?? 'unknown',
                'authors'  => $authors,
                'year'     => $year,
                'url'      => $url,
                'type'     => $ref['type'] ?? 'unknown',
                'abstract' => $ref['abstract'] ?? null,
                'bib_key'  => $ref['key'] ?? null,
                'type_snowballing' => in_array($this->type, ['backward','forward']) ? $this->type : ($ref['type_snowballing'] ?? 'backward'),
                'snowballing_process' => in_array($this->type, ['backward','forward'])
                    ? 'manual snowballing'
                    : 'automatic snowballing',
                'source'   => $source,
                'relevance_score' => $score,
                'duplicate_count' => 1,
                'is_duplicate'    => false,
                'is_relevant'     => null,
            ]);

            // atualiza metadados CrossRef (se DOI)
            if ($doi) {
                $this->updateMetadata($created, $doi);
            }
        }

        Log::info("Job ProcessReferences concluído", [
            'type' => $this->type,
            'total' => count($this->references),
        ]);
    }

    private function updateMetadata(PaperSnowballing $reference, string $doi): void
    {
        try {
            $response = Http::timeout(15)->get('https://api.crossref.org/works/' . $doi);

            if ($response->successful()) {
                $data = $response->json('message') ?? [];

                $reference->update([
                    'title' => $data['title'][0] ?? $reference->title,
                    'authors' => isset($data['author'])
                        ? implode('; ', array_map(
                            fn($a) => trim(($a['given'] ?? '') . ' ' . ($a['family'] ?? '')),
                            $data['author']
                        ))
                        : $reference->authors,
                    'year' => $data['issued']['date-parts'][0][0] ?? $reference->year,
                    'url'  => $data['URL'] ?? $reference->url,
                    'type' => $data['type'] ?? $reference->type,
                    'abstract' => $data['abstract'] ?? $reference->abstract,
                    'keywords' => isset($data['subject']) ? implode('; ', $data['subject']) : $reference->keywords,
                ]);
            } else {
                Log::warning("Falha meta CrossRef", ['doi' => $doi, 'status' => $response->status()]);
            }

            // fallback Semantic Scholar se faltarem metadados importantes
            if (empty($reference->abstract) || empty($reference->keywords) || empty($reference->authors)) {
                $semantic = App::make(SnowballingService::class)->fetch($doi);
                if ($semantic && !empty($semantic['article'])) {
                    $details = $semantic['article'];

                    $reference->update([
                        'title'    => $reference->title ?: ($details['title'] ?? null),
                        'authors'  => $reference->authors ?: ($details['authors'] ?? null),
                        'abstract' => $reference->abstract ?: ($details['abstract'] ?? null),
                        'year'     => $reference->year ?: ($details['year'] ?? null),
                        'url'      => $reference->url ?: ($details['url'] ?? null),
                    ]);
                }
            }

        } catch (\Throwable $e) {
            Log::error("Erro meta CrossRef/S2", ['doi' => $doi, 'error' => $e->getMessage()]);
        }
    }

}
