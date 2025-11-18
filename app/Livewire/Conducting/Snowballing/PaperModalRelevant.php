<?php

namespace App\Livewire\Conducting\Snowballing;

use App\Models\Project;
use App\Models\Project\Conducting\PaperSnowballing;
use App\Models\Project\Conducting\SnowballJob;
use App\Services\SnowballingService;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class PaperModalRelevant extends Component
{
    public $currentProject;
    public $projectId;

    public $paper = null;            // referência clicada
    public $doi;
    public $canEdit = false;

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

    #[On('showPaperSnowballingRelevant')]
    public function showPaperSnowballingRelevant($paper)
    {
        $this->paper = $paper;
        $this->doi   = $paper['doi'] ?? null;

        // origem da referência (Crossref, Semantic Scholar, etc.)
        $this->paper['database_name'] = $paper['source']
            ?? ($paper['database'] ?? null)
            ?? __('project/conducting.snowballing.table.none');


        $this->canEdit = true; // sempre permitido

        // referência clicada
        $parentSnowId = $paper['id'];
        // id do paper base (coluna paper_reference_id na tabela paper_snowballing)
        $paperBaseId  = $paper['paper_reference_id'];

        // marcações de trabalhos já existentes (filhas desta referência)
        $this->manualBackwardDone = PaperSnowballing::where('parent_snowballing_id', $parentSnowId)
            ->where('type_snowballing', 'backward')
            ->exists();

        $this->manualForwardDone = PaperSnowballing::where('parent_snowballing_id', $parentSnowId)
            ->where('type_snowballing', 'forward')
            ->exists();

        // Se existir job em andamento vinculado à referência
        $job = SnowballJob::where('parent_snowballing_id', $parentSnowId)
            ->whereIn('status', ['queued','running'])
            ->first();

        if ($job) {
            $this->jobId       = $job->id;
            $this->jobProgress = $job->progress ?? 0;
            $this->jobMessage  = $job->message ?? '';
            $this->isRunning   = true;
        } else {
            $this->isRunning = false;
        }

        // atualiza tabela do modal (filhas dessa referência específica)
        $this->dispatch('update-references-relevant', [
            'parent_snowballing_id' => $parentSnowId,
        ]);

        $this->dispatch('show-paper-snowballing-relevant');
    }

    /**
     * Snowballing Manual – igual ao original, mas adaptado para referências relevantes
     */
    public function handleReferenceType($type)
    {
        $doi          = $this->doi;
        $parentSnowId = $this->paper['id'];               // referência clicada
        $paperBaseId  = $this->paper['paper_reference_id']; // id do paper base

        if (!$paperBaseId || !$parentSnowId || !$doi) {
            $this->dispatch('snowballing-relevant-toast', [
                'type'    => 'error',
                'message' => __('project/conducting.snowballing.messages.doi_missing')
            ]);
            return;
        }

        // bloqueia repetição
        if ($type === 'backward' && $this->manualBackwardDone) return;
        if ($type === 'forward' && $this->manualForwardDone) return;

        // evita duplicar execução para a mesma referência
        if (SnowballJob::where('parent_snowballing_id', $parentSnowId)
            ->whereIn('status', ['queued','running'])->exists()) {

            $this->dispatch('snowballing-relevant-toast', [
                'type' => 'info',
                'message' => __('project/conducting.snowballing.messages.already_running')
            ]);
            return;
        }

        try {
            DB::beginTransaction();

            // Cria registro de job específico para a referência relevante
            $job = SnowballJob::create([
                'project_id'            => $this->currentProject->id_project,
                'paper_id'              => $paperBaseId,     // sempre o paper base
                'parent_snowballing_id' => $parentSnowId,    // referência atual
                'seed_doi'              => $doi,
                'modes'                 => [$type],
                'status'                => 'queued',
                'message'               => ucfirst($type).' snowballing iniciado…',
            ]);

            $this->jobId = $job->id;

            // processamento via serviço especializado
            $svc = app(SnowballingService::class);
            $svc->processSingleIterationRelevant($doi, $paperBaseId, $parentSnowId, $type);

            $job->update([
                'status'  => 'running',
                'message' => __('project/conducting.snowballing.messages.manual_job_started', [
                    'type' => ucfirst($type)
                ]),
            ]);

            DB::commit();

            // flags locais
            if ($type === 'backward') $this->manualBackwardDone = true;
            if ($type === 'forward')  $this->manualForwardDone  = true;

            session()->flash(
                'successMessage',
                __('project/conducting.snowballing.messages.manual_job_started', ['type' => ucfirst($type)])
            );
            $this->dispatch('show-success-snowballing-relevant');

            $this->dispatch('snowballing-relevant-toast', [
                'type' => 'success',
                'message' => __('project/conducting.snowballing.messages.manual_job_started', [
                    'type' => ucfirst($type)
                ])
            ]);

        } catch (\Throwable $e) {

            DB::rollBack();

            session()->flash('successMessage', __('project/conducting.snowballing.messages.error', [
                'message' => $e->getMessage(),
            ]));

            // aqui mantive o mesmo evento que você já estava usando
            $this->dispatch('snowballing-relevant-toast', [
                'type' => 'info',
                'message' => $e->getMessage()
            ]);

        }
    }

    public function checkJobProgress()
    {
        $parentSnowId = $this->paper['id'];

        if (!$this->jobId) {
            $job = SnowballJob::where('parent_snowballing_id', $parentSnowId)
                ->whereIn('status', ['queued','running'])
                ->first();

            if (!$job) return;
            $this->jobId = $job->id;
        }

        $job = SnowballJob::find($this->jobId);
        if (!$job) return;

        $this->jobProgress = (int)($job->progress ?? 0);
        $this->jobMessage  = $job->message ?? '';

        if ($job->status === 'completed') {

            $this->dispatch('update-references-relevant', [
                'parent_snowballing_id' => $parentSnowId
            ]);

            $this->dispatch('snowballing-relevant-toast', [
                'type' => 'success',
                'message' => __('project/conducting.snowballing.messages.automatic_complete')
            ]);

            $this->isRunning = false;
            $this->jobId     = null;

            return;
        }

        if ($job->status === 'failed') {

            $this->dispatch('snowballing-relevant-toast', [
                'type' => 'error',
                'message' => $job->message
            ]);

            $this->dispatch('show-success-snowballing-relevant');

            $this->isRunning = false;
            $this->jobId     = null;

            return;
        }
    }

    public function render()
    {
        return view('livewire.conducting.snowballing.paper-modal-relevant');
    }
}
