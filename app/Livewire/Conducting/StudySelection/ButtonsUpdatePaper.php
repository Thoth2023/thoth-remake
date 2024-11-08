<?php

namespace App\Livewire\Conducting\StudySelection;

use App\Jobs\AtualizarDadosCrossref;
use App\Jobs\AtualizarDadosSpringer;
use App\Models\Project\Conducting\Papers;
use App\Utils\ToastHelper; // Certifique-se de que o ToastHelper está corretamente importado
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
            // Usar ToastHelper para exibir mensagem de erro
            $this->toast('DOI ou título do paper necessário para buscar dados.', 'error');
            $this->dispatch('refresh-paper-data');
            return;
        }

        Log::info("Despachando Job para paper ID {$this->paperId}, DOI: {$this->doi} e Título: {$this->title}");

        AtualizarDadosCrossref::dispatch($this->paperId, $this->doi, $this->title);

        // Usar ToastHelper para exibir mensagem de sucesso
        $this->toast('A atualização dos dados foi solicitada via CrossRef, verifique se os dados foram atualizados.', 'success');
        $this->dispatch('refresh-paper-data');
    }

    public function atualizarDadosSpringer()
    {
        if (empty($this->doi)) {
            // Usar ToastHelper para exibir mensagem de erro
            $this->toast('DOI necessário para buscar dados via Springer.', 'error');
            $this->dispatch('refresh-paper-data');
            return;
        }

        Log::info("Despachando Job para atualização via Springer para paper ID {$this->paperId}");

        AtualizarDadosSpringer::dispatch($this->paperId, $this->doi);

        // Usar ToastHelper para exibir mensagem de sucesso
        $this->toast('A atualização dos dados foi solicitada via Springer, verifique se os dados foram atualizados.', 'success');
        $this->dispatch('refresh-paper-data');
    }

    // Função auxiliar para enviar mensagens de toast
    private function toast(string $message, string $type)
    {
        $this->dispatch('buttons-update-paper', ToastHelper::dispatch($type, $message));
    }

    public function render()
    {
        return view('livewire.conducting.study-selection.buttons-update-paper');
    }
}
