<?php

namespace App\Livewire\Conducting\Snowballing;

use App\Jobs\RunFullSnowballingJob;
use App\Models\Project;
use App\Models\Project\Conducting\PaperSnowballing;
use App\Models\Project\Conducting\SnowballJob;
use App\Services\SnowballingService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Traits\ProjectPermissions;

class PaperModal extends Component
{
    use ProjectPermissions;

    public $currentProject;
    public $projectId;
    public $paper = null;
    public $canEdit = false;
    public $doi;
    public $jobId = null;
    public $jobProgress = 0;
    public $jobMessage = '';

    public $isRunning = false;

    public $manualBackwardDone = false;
    public $manualForwardDone = false;

    public function mount()
    {
        $this->projectId = request()->segment(2);
        $this->currentProject = Project::findOrFail($this->projectId);
    }

    #[On('showPaperSnowballing')]
    public function showPaperSnowballing($paper)
    {
        $this->canEdit = $this->userCanEdit();
        $this->paper = $paper;
        $this->doi = $paper['doi'] ?? null;

        $paperId = $paper['id_paper'] ?? null;
        if ($paperId) {
            $this->manualBackwardDone = PaperSnowballing::where('paper_reference_id', $paperId)
                ->where('type_snowballing', 'backward')
                ->exists();
            $this->manualForwardDone = PaperSnowballing::where('paper_reference_id', $paperId)
                ->where('type_snowballing', 'forward')
                ->exists();
        }

        //Detecta job ativo diretamente no controller
        if ($paperId) {
            $job = SnowballJob::where('paper_id', $paperId)
                ->whereIn('status', ['queued','running'])
                ->first();

            if ($job) {
                $this->jobId = $job->id;
                $this->jobProgress = $job->progress ?? 0;
                $this->jobMessage  = $job->message ?? '';
                $this->isRunning = true;
            } else {
                $this->isRunning = false;
            }
        }

        $databaseName = DB::table('data_base')
            ->where('id_database', $this->paper['data_base'])
            ->value('name');

        $this->paper['database_name'] = $databaseName;

        $this->dispatch('update-references', [
            'paper_reference_id' => $this->paper['id_paper'] ?? null,
        ]);

        $this->dispatch('show-paper-snowballing');
    }

    /**
     * Snowballing manual — somente nível 1 (sem iteração)
     */
    public function handleReferenceType($type)
    {
        if (!$this->canEdit) return;

        $paperId = $this->paper['id_paper'] ?? null;
        $doi = $this->doi;

        if (!$paperId || !$doi) {
            session()->flash('successMessage', __('project/conducting.snowballing.messages.doi_missing'));
            $this->dispatch('show-success-snowballing');
            return;
        }

        // bloqueia repetição
        if ($type === 'backward' && $this->manualBackwardDone) {
            session()->flash('successMessage', __('project/conducting.snowballing.messages.backward_done'));
            $this->dispatch('show-success-snowballing');
            return;
        }
        if ($type === 'forward' && $this->manualForwardDone) {
            session()->flash('successMessage', __('project/conducting.snowballing.messages.forward_done'));
            $this->dispatch('show-success-snowballing');
            return;
        }

        // evita duplicar execução
        $runningExists = SnowballJob::where('paper_id', $paperId)
            ->whereIn('status', ['queued', 'running'])
            ->exists();

        if ($runningExists) {
            session()->flash('successMessage', __('project/conducting.snowballing.messages.already_running'));
            $this->dispatch('show-success-snowballing');
            return;
        }

        try {
            DB::beginTransaction();

            // Marca paper como "Done"
            //DB::table('papers')
            //  ->where('id_paper', $paperId)
            //  ->update(['status_snowballing' => 1]);

            // Cria registro na tabela de jobs
            $job = SnowballJob::create([
                'project_id' => $this->currentProject->id_project,
                'paper_id'   => $paperId,
                'seed_doi'   => $doi,
                'modes'      => [$type],
                'status'     => 'queued',
                'message'    => ucfirst($type) . ' snowballing iniciado…',
            ]);

            $this->jobId = $job->id;

            // executa o snowballing manual (CrossRef → fallback Semantic Scholar)
            $svc = app(SnowballingService::class);
            $svc->processSingleIteration($doi, $paperId, $type, false);

            // atualiza status do job
            $job->update([
                'status'  => 'running',
                'message' => __('project/conducting.snowballing.messages.manual_job_started', ['type' => ucfirst($type)]),
            ]);

            DB::commit();

            // Atualiza flags locais
            if ($type === 'backward') $this->manualBackwardDone = true;
            if ($type === 'forward')  $this->manualForwardDone = true;

            // Feedback inicial
            $this->dispatch('snowballing-toast', [
                'type' => 'info',
                'message' => __('project/conducting.snowballing.messages.manual_job_started', [
                    'type' => ucfirst($type)
                ])
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('[Snowballing] Erro no modo manual assíncrono', [
                'type'  => $type,
                'doi'   => $doi,
                'error' => $e->getMessage(),
            ]);

            session()->flash('successMessage', __('project/conducting.snowballing.messages.error', [
                'message' => $e->getMessage(),
            ]));
            // Feedback de erro
            $this->dispatch('snowballing-toast', [
                'type' => 'error',
                'message' => __('project/conducting.snowballing.messages.error', [
                    'type' => ucfirst($type)
                ])
            ]);
        }
    }

    /**
     * Snowballing completo automático (iterações até esgotar)
     */
    public function handleFullSnowballing()
    {
        $paperId = (int)($this->paper['id_paper'] ?? 0);
        if (!$paperId || !$this->doi) {
            session()->flash('successMessage', __('project/conducting.snowballing.messages.missing_paper'));
            $this->dispatch('show-success-snowballing');
            return;
        }

        if ($this->manualBackwardDone || $this->manualForwardDone) {
            session()->flash('successMessage', __('project/conducting.snowballing.messages.manual_disabled'));
            $this->dispatch('show-success-snowballing');
            return;
        }

        // evita duplicar execução
        $runningExists = SnowballJob::where('paper_id', $paperId)
            ->whereIn('status', ['queued','running'])->exists();
        if ($runningExists) {
            session()->flash('successMessage', __('project/conducting.snowballing.messages.already_running'));
            $this->dispatch('show-success-snowballing');
            return;
        }

        // modos pendentes (igual sua lógica)
        $hasBackward = PaperSnowballing::where('paper_reference_id', $paperId)->where('type_snowballing', 'backward')->exists();
        $hasForward  = PaperSnowballing::where('paper_reference_id', $paperId)->where('type_snowballing', 'forward')->exists();

        if ($hasBackward && $hasForward) {
            //session()->flash('successMessage', __('project/conducting.snowballing.messages.already_complete'));
            //$this->dispatch('show-success-snowballing');
            $this->dispatch('snowballing-toast', [
                'type' => 'success',
                'message' => __('project/conducting.snowballing.messages.already_complete')
            ]);
            return;
        }

        $modes = [];
        if (!$hasBackward) $modes[] = 'backward';
        if (!$hasForward)  $modes[] = 'forward';
        if (empty($modes)) $modes = ['backward','forward'];

        // cria o registro de job
        $job = SnowballJob::create([
            'project_id' => $this->currentProject->id_project,
            'paper_id'   => $paperId,
            'seed_doi'   => $this->doi,
            'modes'      => $modes,
            'status'     => 'queued',
            'message'    => 'Aguardando worker…',
        ]);

        $this->jobId = $job->id;

        // dispara o job
        dispatch(new RunFullSnowballingJob($job->id))->onQueue('snowballing');

        $this->dispatch('snowballing-toast', [
            'type' => 'info',
            'message' => __('project/conducting.snowballing.modal.processing')
        ]);
    }

    public function checkJobProgress()
    {
        $paperId = $this->paper['id_paper'] ?? null;
        if (!$paperId) return;

        // Se não tiver jobId armazenado, tenta pegar automaticamente
        if (!$this->jobId) {
            $job = SnowballJob::where('paper_id', $paperId)
                ->whereIn('status', ['queued','running'])
                ->first();

            if (!$job) return;
            $this->jobId = $job->id;
        }

        // Recarrega job
        $job = SnowballJob::find($this->jobId);
        if (!$job) {
            $this->jobId = null;
            return;
        }

        // Atualiza progresso na classe
        $this->jobProgress = (int) ($job->progress ?? 0);
        $this->jobMessage  = $job->message ?? __('project/conducting.snowballing.modal.processing');

        if ($job->status === 'completed') {

            // marca paper como finalizado
            DB::table('papers')
                ->where('id_paper', $paperId)
                ->update(['status_snowballing' => 1]);

            // atualiza tabela de referências
            $this->dispatch('update-references', [
                'paper_reference_id' => $paperId
            ]);

            // feedback
            session()->flash('successMessage', __('project/conducting.snowballing.messages.automatic_complete'));
            $this->dispatch('show-success-snowballing');

            // Para o polling
            $this->jobId = null;
            $this->isRunning = false;
            return;
        }

        // se falhou
        if ($job->status === 'failed') {

            session()->flash(
                'successMessage',
                __('project/conducting.snowballing.messages.error', [
                    'message' => $job->message
                ])
            );

            $this->dispatch('show-success-snowballing');

            // Para polling
            $this->jobId = null;
            $this->isRunning = false;
            return;
        }
        $this->isRunning = true;
    }


    public function render()
    {
        return view('livewire.conducting.snowballing.paper-modal');
    }
}
