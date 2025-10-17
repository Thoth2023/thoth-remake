<?php

namespace App\Livewire\Conducting\Snowballing;

use App\Models\Project;
use App\Models\Project\Conducting\PaperSnowballing;
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

        if (!$paperId || !$this->doi) {
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

        try {
            DB::beginTransaction();

            /** @var SnowballingService $service */
            $service = app(SnowballingService::class);

            // Executa apenas 1 iteração (sem loop)
            $service->processSingleIteration($this->doi, $paperId, $type, false);

            // Atualiza flags locais
            if ($type === 'backward') $this->manualBackwardDone = true;
            if ($type === 'forward') $this->manualForwardDone = true;

            //  Atualiza o status do paper para "Done" (id = 1)
            DB::table('papers')
                ->where('id_paper', $paperId)
                ->update(['status_snowballing' => 1]);

            DB::commit();

            $this->dispatch('update-references', ['paper_reference_id' => $paperId]);
            session()->flash(
                'successMessage',
                __('project/conducting.snowballing.messages.manual_done', ['type' => ucfirst($type)])
            );
            $this->dispatch('show-success-snowballing');

        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('[Snowballing] Erro no modo manual', [
                'type' => $type,
                'error' => $e->getMessage(),
            ]);

            session()->flash('successMessage', __('project/conducting.snowballing.messages.error', [
                'message' => $e->getMessage()
            ]));
            $this->dispatch('show-success-snowballing');
        }
    }

    /**
     * Snowballing completo automático (iterações até esgotar)
     */
    public function handleFullSnowballing()
    {
        Log::info('[Snowballing] Iniciando modo automático', ['doi' => $this->doi]);

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

        $hasBackward = PaperSnowballing::where('paper_reference_id', $paperId)
            ->where('type_snowballing', 'backward')
            ->exists();
        $hasForward = PaperSnowballing::where('paper_reference_id', $paperId)
            ->where('type_snowballing', 'forward')
            ->exists();

        if ($hasBackward && $hasForward) {
            session()->flash('successMessage', __('project/conducting.snowballing.messages.already_complete'));
            $this->dispatch('show-success-snowballing');
            return;
        }

        $modes = [];
        if (!$hasBackward) $modes[] = 'backward';
        if (!$hasForward)  $modes[] = 'forward';

        try {
            DB::beginTransaction();

            $service = app(SnowballingService::class);
            $service->runIterativeSnowballing($this->doi, $paperId, $modes);

            // Atualiza o status do paper para "Done" (id = 1)
            DB::table('papers')
                ->where('id_paper', $paperId)
                ->update(['status_snowballing' => 1]);

            DB::commit();

            $this->dispatch('update-references', ['paper_reference_id' => $paperId]);
            session()->flash('successMessage', __('project/conducting.snowballing.messages.automatic_complete'));
            $this->dispatch('show-success-snowballing');

        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('[Snowballing] Erro no modo automático', [
                'doi' => $this->doi,
                'error' => $e->getMessage(),
            ]);

            session()->flash('successMessage', __('project/conducting.snowballing.messages.error', [
                'message' => $e->getMessage()
            ]));
            $this->dispatch('show-success-snowballing');
        }
    }



    public function render()
    {
        return view('livewire.conducting.snowballing.paper-modal');
    }
}
