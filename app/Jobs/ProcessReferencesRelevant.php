<?php

namespace App\Jobs;

use App\Models\Project\Conducting\PaperSnowballing;
use App\Models\Project\Conducting\SnowballJob;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;

class ProcessReferencesRelevant implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected array $references;       // refs processadas pelo SnowballingService
    protected int $paperBaseId;        // id do paper base
    protected int $parentSnowId;       // referência clicada
    protected string $type;            // backward | forward

    public function __construct(array $references, int $paperBaseId, int $parentSnowId, string $type)
    {
        $this->references   = $references;
        $this->paperBaseId  = $paperBaseId;
        $this->parentSnowId = $parentSnowId;
        $this->type         = $type;
    }

    public function handle()
    {
        $total = count($this->references);

        Log::info("Job ProcessReferencesRelevant iniciado", [
            'type'           => $this->type,
            'paper_base_id'  => $this->paperBaseId,
            'parent_snow_id' => $this->parentSnowId,
            'total'          => $total
        ]);

        // Obtém depth do pai para calcular ancestralidade
        $parent = PaperSnowballing::find($this->parentSnowId);
        $parentDepth = $parent?->depth ?? 0;
        $newDepth = $parentDepth + 1;

        // obtém job associado
        $job = SnowballJob::where('parent_snowballing_id', $this->parentSnowId)
            ->whereIn('status', ['queued', 'running'])
            ->latest()
            ->first();

        if ($job) {
            $job->update([
                'status'     => 'running',
                'progress'   => 1,
                'message'    => __('project/conducting.snowballing.messages.manual_processing_start'),
                'started_at' => Carbon::now(),
            ]);
        }

        if ($total === 0) {
            if ($job) {
                $job->update([
                    'status'   => 'completed',
                    'progress' => 100,
                    'message'  => 'Nenhuma referência encontrada.',
                    'finished_at' => Carbon::now()
                ]);
            }
            return;
        }

        // PROCESSAMENTO
        $index = 0;

        foreach ($this->references as $ref) {

            $index++;

            // normalização
            $doi     = $ref['DOI'] ?? $ref['doi'] ?? null;
            $title   = $ref['article-title'] ?? $ref['title'] ?? null;
            $authors = $ref['authors'] ?? null;
            $year    = $ref['year'] ?? null;
            $url     = $ref['URL'] ?? $ref['url'] ?? null;
            $source  = $ref['source'] ?? 'CrossRef';
            $score   = $ref['score'] ?? null;

            if (!$doi && !$title) {
                continue;
            }

            // DUPLICATAS (por DOI ou TÍTULO)
            $existing = PaperSnowballing::query()
                ->when($doi, fn($q) => $q->where('doi', $doi))
                ->when(!$doi && $title, fn($q) => $q->where('title', $title))
                ->where('paper_reference_id', $this->paperBaseId)
                ->where('parent_snowballing_id', $this->parentSnowId)
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

                PaperSnowballing::create([
                    'paper_reference_id'    => $this->paperBaseId,
                    'parent_snowballing_id' => $this->parentSnowId,
                    'depth'                 => $newDepth,
                    'doi'                   => $doi,
                    'title'                 => $title ?? 'unknown',
                    'authors'               => $authors,
                    'year'                  => $year,
                    'url'                   => $url,
                    'type'                  => $ref['type'] ?? 'unknown',
                    'abstract'              => $ref['abstract'] ?? null,
                    'bib_key'               => $ref['key'] ?? null,
                    'type_snowballing'      => $this->type,
                    'snowballing_process'   => 'manual snowballing relevant',
                    'source'                => $source,
                    'relevance_score'       => $score,
                    'duplicate_count'       => 1,
                ]);
            }

            // === atualizar progresso ===
            if ($job) {
                $progress = (int) round(($index / $total) * 95);

                $job->update([
                    'progress' => $progress,
                    'message'  => "Processando referência {$index} de {$total}…",
                ]);
            }
        }

        // FINALIZA
        if ($job) {
            $job->update([
                'status'      => 'completed',
                'progress'    => 100,
                'message'     => __('project/conducting.snowballing.messages.manual_complete'),
                'finished_at' => Carbon::now(),
            ]);
        }

        Log::info("Job ProcessReferencesRelevant FINALIZADO", [
            'parent' => $this->parentSnowId,
            'paper'  => $this->paperBaseId,
            'total'  => $total
        ]);
    }
}

