<?php

namespace App\Livewire\Conducting\StudySelection;

use App\Jobs\AtualizarDadosCrossref;
use App\Jobs\AtualizarDadosSpringer;
use App\Models\Project;
use App\Models\Project\Conducting\Papers;
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
        // Recarrega as informações do paper
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
            session()->flash('errorMessage', 'DOI ou título do paper necessário para buscar dados.');
            $this->dispatch('refresh-paper-data');
            return;
        }

        Log::info("Despachando Job para paper ID {$this->paperId}, DOI: {$this->doi} e Título: {$this->title}");

        AtualizarDadosCrossref::dispatch($this->paperId, $this->doi, $this->title);

        session()->flash('successMessage', 'A atualização dos dados foi solicitada via CrossRef, verifique se os dados foram atualizados.');
        $this->dispatch('refresh-paper-data');
    }

    public function atualizarDadosSpringer()
    {
        if (empty($this->doi)) {
            session()->flash('errorMessage', 'DOI necessário para buscar dados via Springer.');
            $this->dispatch('refresh-paper-data');
            return;
        }

        Log::info("Despachando Job para atualização via Springer para paper ID {$this->paperId}");

        AtualizarDadosSpringer::dispatch($this->paperId, $this->doi);

        session()->flash('successMessage', 'A atualização dos dados foi solicitada via Springer, verifique se os dados foram atualizados.');
        $this->dispatch('refresh-paper-data');
    }

    public function render()
    {
        return view('livewire.conducting.study-selection.buttons-update-paper');
    }
}
