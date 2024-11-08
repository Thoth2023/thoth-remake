<?php

namespace App\Livewire\Conducting\StudySelection;

use App\Models\Project;
use App\Models\Project\Conducting\Papers;
use Livewire\Attributes\On;
use Livewire\Component;

class PaperAbstractKeywords extends Component
{
    public $paperId;
    public $abstract;
    public $keywords;

    public function mount($paperId,$projectId)
    {
        $this->projectId = $projectId; // Usar o projectId passado diretamente
        $this->currentProject = Project::find($this->projectId);

        $this->paperId = $paperId;
        $this->loadPaperData();
    }
    #[On('refresh-paper-data')]
    public function loadPaperData()
    {
        $paper = Papers::find($this->paperId);
        $this->abstract = $paper->abstract;
        $this->keywords = $paper->keywords;
    }


    public function render()
    {
        return view('livewire.conducting.study-selection.paper-abstract-keywords');
    }
}
