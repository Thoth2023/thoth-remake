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
use App\Models\Project\Conducting\SnowballJob;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

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
        $paperId = $this->paper['id_paper'] ?? null;
        $total = count($this->references);

        Log::info("Job ProcessReferences iniciado", [
            'type' => $this->type,
            'paper_id' => $paperId,
            'total_references' => $total,
        ]);

        if (!$paperId || $total === 0) {
            return;
        }

        // pega o job correspondente
        $job = SnowballJob::where('paper_id', $paperId)
            ->whereIn('status', ['queued', 'running'])
            ->latest()
            ->first();

        if ($job) {
            $job->update([
                'status' => 'running',
                'progress' => 1,
                'message' => __('project/conducting.snowballing.messages.manual_processing_start'),
                'started_at' => Carbon::now(),
            ]);
        }

        // processamento com progresso contínuo
        $index = 0;
        foreach ($this->references as $ref) {

            $index++;

            // NORMALIZAÇÃO
            $doi     = $ref['DOI'] ?? $ref['doi'] ?? null;
            $title   = $ref['article-title'] ?? $ref['title'] ?? null;
            $authors = $ref['authors'] ?? $ref['author'] ?? null;
            $year    = $ref['year'] ?? null;
            $url     = $ref['URL'] ?? $ref['url'] ?? null;
            $source  = $ref['source'] ?? 'CrossRef';
            $score   = $ref['score'] ?? null;

            if (!$doi && !$title) {
                continue;
            }

            // DUPLICATAS
            $existing = PaperSnowballing::query()
                ->when($doi, fn($q) => $q->where('doi', $doi))
                ->when(!$doi && $title, fn($q) => $q->where('title', $title))
                ->where('paper_reference_id', $paperId)
                ->first();

            if ($existing) {
                $existing->duplicate_count = ($existing->duplicate_count ?? 1) + 1;

                if ($score !== null) {
                    $existing->relevance_score = $existing->relevance_score
                        ? round(($existing->relevance_score + $score) / 2, 3)
                        : $score;
                }

                $existing->save();
            } else {

                // autores → string
                if (is_array($authors)) {
                    if (isset($authors[0]['given']) || isset($authors[0]['family'])) {
                        $authors = implode('; ', array_map(fn($a) =>
                        trim(($a['given'] ?? '') . ' ' . ($a['family'] ?? '')), $authors));
                    } else {
                        $authors = implode('; ', array_map(fn($a) =>
                            $a['name'] ?? (is_string($a) ? $a : ''), $authors));
                    }
                }

                // CRIAÇÃO
                $created = PaperSnowballing::create([
                    'paper_reference_id' => $paperId,
                    'parent_snowballing_id' => null,
                    'depth'=> 1, //nivel_inicial
                    'doi' => $doi,
                    'title' => $title ?? 'unknown',
                    'authors' => $authors,
                    'year' => $year,
                    'url' => $url,
                    'type' => $ref['type'] ?? 'unknown',
                    'abstract' => $ref['abstract'] ?? null,
                    'bib_key' => $ref['key'] ?? null,
                    'type_snowballing' => $this->type,
                    'snowballing_process' => 'manual snowballing',
                    'source' => $source,
                    'relevance_score' => $score,
                    'duplicate_count' => 1,
                ]);

                // meta CrossRef
                if ($doi) {
                    $this->updateMetadata($created, $doi);
                }
            }

            // === PROGRESSO CONTÍNUO ===
            if ($job) {
                $progress = (int) round(($index / $total) * 95); // garante que termina no 95, finalização no 100
                $job->update([
                    'progress' => $progress,
                    'message' => __('project/conducting.snowballing.messages.manual_processing_step', [
                        'current' => $index,
                        'total' => $total
                    ]),
                ]);
            }
        }

        // FINALIZAÇÃO
        if ($job) {
            $job->update([
                'status' => 'completed',
                'progress' => 100,
                'finished_at' => Carbon::now(),
                'message' => __('project/conducting.snowballing.messages.manual_complete'),
            ]);
        }

        // marca paper como concluído SOMENTE AGORA
        DB::table('papers')
            ->where('id_paper', $paperId)
            ->update(['status_snowballing' => 1]);

        Log::info("Job ProcessReferences concluído", [
            'type' => $this->type,
            'total' => $total,
            'paper' => $paperId,
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
