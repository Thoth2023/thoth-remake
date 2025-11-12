<?php

namespace App\Livewire\Conducting\StudySelection;

use App\Jobs\AtualizarDadosCrossref;
use App\Jobs\AtualizarDadosSpringer;
use App\Jobs\AtualizarDadosSemantic;
use App\Models\Project\Conducting\Papers;
use App\Utils\ToastHelper;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;

class ButtonsUpdatePaper extends Component
{
    public $paperId;
    public $abstract;
    public $keywords;
    public $doi;
    public $title;

    public function mount($paperId, $projectId)
    {
        $this->projectId = $projectId;
        $this->paperId = $paperId;
        $this->refreshData();
    }

    #[On('refresh-paper-data')]
    public function refreshData()
    {
        $paper = Papers::find($this->paperId);
        if ($paper) {
            $this->abstract = $paper->abstract;
            $this->keywords = $paper->keywords;
            $this->doi = $paper->doi;
            $this->title = $paper->title;
        }
    }

    public function atualizarDadosFaltantes()
    {
        if (empty($this->doi) && empty($this->title)) {
            $this->toast(__('project/conducting.study-selection.modal.buttons.crossref.error_missing_data'), 'error');
            $this->dispatch('refresh-paper-data');
            return;
        }

        Log::info("Despachando Job para paper ID {$this->paperId}, DOI: {$this->doi} e Título: {$this->title}");
        AtualizarDadosCrossref::dispatch($this->paperId, $this->doi, $this->title)->onQueue('updates');

        $this->toast(__('project/conducting.study-selection.modal.buttons.crossref.success'), 'success');
        $this->dispatch('refresh-paper-data');
    }

    public function atualizarDadosSpringer()
    {
        if (empty($this->doi)) {
            $this->toast(__('project/conducting.study-selection.modal.buttons.springer.error_missing_doi'), 'error');
            $this->dispatch('refresh-paper-data');
            return;
        }

        Log::info("Despachando Job para atualização via Springer para paper ID {$this->paperId}");
        AtualizarDadosSpringer::dispatch($this->paperId, $this->doi)->onQueue('updates');

        $this->toast(__('project/conducting.study-selection.modal.buttons.springer.success'), 'success');
        $this->dispatch('refresh-paper-data');
    }

    public function atualizarDadosSemantic()
    {
        if (empty($this->doi) && empty($this->title)) {
            $this->toast(__('project/conducting.study-selection.modal.buttons.semantic.error_missing_query'), 'error');
            $this->dispatch('refresh-paper-data');
            return;
        }

        try {
            $queryType = !empty($this->doi) ? 'DOI' : 'Título';
            Log::info("Atualizando via Semantic Scholar ({$queryType}) → paper ID {$this->paperId}");

            AtualizarDadosSemantic::dispatch($this->paperId, $this->doi, $this->title)->onQueue('updates');

            $this->toast(__('project/conducting.study-selection.modal.buttons.semantic.success'), 'success');
        } catch (\Throwable $e) {
            Log::error("Falha ao atualizar via Semantic Scholar: " . $e->getMessage(), [
                'paperId' => $this->paperId,
                'trace' => $e->getTraceAsString(),
            ]);

            $this->toast(__('project/conducting.study-selection.modal.buttons.semantic.failed'), 'error');
        }

        $this->dispatch('refresh-paper-data');
    }


    private function toast(string $message, string $type)
    {
        $this->dispatch('buttons-update-paper', ToastHelper::dispatch($type, $message));
    }

    public function render()
    {
        return view('livewire.conducting.study-selection.buttons-update-paper');
    }
}
