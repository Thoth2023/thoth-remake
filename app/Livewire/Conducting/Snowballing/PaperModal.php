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

    public $manualBackwardDone = false;
    public $manualForwardDone = false;

    public function mount()
    {
        $this->projectId = request()->segment(2);
        $this->currentProject = Project::findOrFail($this->projectId);
    }

    public function checkJobProgress()
    {
        if (!$this->jobId) return;

        $job = SnowballJob::find($this->jobId);
        if (!$job) return;

        $this->jobProgress = $job->progress ?? 0;
        $this->jobMessage = $job->message ?? __('project/conducting.snowballing.modal.processing');

        if ($job->status === 'completed') {
            $this->dispatch('show-success-snowballing');
        }
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
            DB::table('papers')
                ->where('id_paper', $paperId)
                ->update(['status_snowballing' => 1]);

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

            // Dispara o job em background
            dispatch(new RunFullSnowballingJob($job->id))->onQueue('snowballing');

            DB::commit();

            // Atualiza flags locais
            if ($type === 'backward') $this->manualBackwardDone = true;
            if ($type === 'forward')  $this->manualForwardDone = true;

            // Inicia polling no frontend
            $this->dispatch('start-snowballing-poll', ['jobId' => $job->id]);

            // Feedback inicial
            session()->flash('successMessage', __('project/conducting.snowballing.messages.manual_job_started', [
                'type' => ucfirst($type),
            ]));
            $this->dispatch('show-success-snowballing');

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
            $this->dispatch('show-success-snowballing');
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
            session()->flash('successMessage', __('project/conducting.snowballing.messages.already_complete'));
            $this->dispatch('show-success-snowballing');
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

        // dispara polling no front (mínimo, sem alterar HTML da view)
        $this->dispatch('start-snowballing-poll', ['jobId' => $job->id]);

        session()->flash('successMessage', __('project/conducting.snowballing.modal.processing'));
        $this->dispatch('show-success-snowballing');
    }

// Novo método para o polling: o JS chama isso a cada 2s
    public function pollJobStatus(int $jobId)
    {
        $job = SnowballJob::find($jobId);
        if (!$job) return ['done' => true];

        if ($job->status === 'completed') {
            // marca paper como concluído
            DB::table('papers')->where('id_paper', $this->paper['id_paper'])->update(['status_snowballing' => 1]);

            $this->dispatch('update-references', ['paper_reference_id' => $this->paper['id_paper']]);
            session()->flash('successMessage', __('project/conducting.snowballing.messages.automatic_complete'));
            $this->dispatch('show-success-snowballing');
            return ['done' => true];
        }

        if ($job->status === 'failed') {
            session()->flash('successMessage', __('project/conducting.snowballing.messages.error', ['message' => $job->message]));
            $this->dispatch('show-success-snowballing');
            return ['done' => true];
        }

        // ainda processando
        return [
            'done'     => false,
            'progress' => (int)$job->progress,
            'message'  => (string)$job->message,
        ];
    }

    public function render()
    {
        return view('livewire.conducting.snowballing.paper-modal');
    }
}
