<?php

namespace App\Livewire\Conducting\StudySelection;

use App\Models\Project;
use App\Models\Project\Conducting\Papers;
use Livewire\Attributes\On;
use Livewire\Component;

class PaperDoiUrl extends Component
{
    public $paperId;
    public $projectId;
    public $doi;
    public $url;

    public function mount($paperId, $projectId)
    {
        $this->projectId = $projectId;
        $this->paperId = $paperId;
        $this->loadPaperData();
    }

    #[On('refresh-paper-data')]
    public function loadPaperData()
    {
        $paper = Papers::find($this->paperId);

        if ($paper) {
            $this->doi = $paper->doi;
            $this->url = $paper->url;

            // Caso a URL esteja vazia, preencher com o link completo do DOI (se existir)
            if (empty($this->url) && !empty($this->doi)) {
                $this->url = $this->buildDoiUrl($this->doi);
            }
        }
    }

    private function buildDoiUrl(?string $doi): ?string
    {
        if (empty($doi)) {
            return null;
        }

        // Se já contiver "doi.org", retorna como está
        if (str_contains($doi, 'doi.org')) {
            return $doi;
        }

        // Se já for um link completo (http/https), retorna direto
        if (preg_match('/^https?:\/\//', $doi)) {
            return $doi;
        }

        // Caso contrário, monta o link padrão
        return "https://doi.org/" . ltrim($doi, '/');
    }

    public function render()
    {
        return view('livewire.conducting.study-selection.paper-doi-url');
    }
}
