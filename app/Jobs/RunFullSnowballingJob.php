<?php

namespace App\Jobs;

use App\Models\Project\Conducting\SnowballJob;
use App\Services\SnowballingService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RunFullSnowballingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $jobId;

    public function __construct(int $jobId)
    {
        $this->jobId = $jobId;
    }

    public function handle(): void
    {
        /** @var SnowballJob $job */
        $job = SnowballJob::find($this->jobId);
        if (!$job) return;

        $modesLabel = implode(' & ', array_map('ucfirst', $job->modes ?? ['backward','forward']));
        $isManual = count($job->modes) === 1;
        $prefix = $isManual ? "Manual Snowballing ({$modesLabel})" : "Automatic Snowballing";

        $job->update([
            'status' => 'running',
            'started_at' => Carbon::now(),
            'message' => "{$prefix} in progress…",
        ]);

        try {
            /** @var SnowballingService $svc */
            $svc = app(SnowballingService::class);

            // Callback de progresso chamado pelo service
            $onProgress = function (array $stats) use ($job) {
                // stats: processed, discovered, enqueued, progress (0..100), note
                SnowballJob::whereKey($job->id)->update([
                    'processed'  => $stats['processed']  ?? DB::raw('processed'),
                    'discovered' => $stats['discovered'] ?? DB::raw('discovered'),
                    'enqueued'   => $stats['enqueued']   ?? DB::raw('enqueued'),
                    'progress'   => max(0, min(100, (int)($stats['progress'] ?? 0))),
                    'message'    => $stats['note'] ?? $job->message,
                ]);
            };

            $modes = $job->modes ?: ['backward','forward'];
            $svc->runIterativeSnowballing(
                $job->seed_doi,
                $job->paper_id,
                $modes,
                $onProgress // <<<<<< progresso em tempo real
            );

            $job->refresh();
            $job->update([
                'status' => 'completed',
                'progress' => 100,
                'finished_at' => Carbon::now(),
                'message' => 'Snowballing concluído com sucesso.',
            ]);

        } catch (\Throwable $e) {
            Log::error('[Snowballing] Job falhou', ['jobId' => $job->id, 'error' => $e->getMessage()]);
            $job->update([
                'status' => 'failed',
                'message' => 'Erro: '.$e->getMessage(),
                'finished_at' => Carbon::now(),
            ]);
            throw $e; // respeita política de retries se houver
        }
    }
}
