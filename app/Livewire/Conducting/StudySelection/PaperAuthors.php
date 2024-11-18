<?php

namespace App\Livewire\Conducting\StudySelection;

use App\Models\Project;
use App\Models\Project\Conducting\Papers;
use Livewire\Attributes\On;
use Livewire\Component;

class PaperAuthors extends Component
{
    public $paperId;
    public $author;

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
        $this->author = $paper->author;

    }

    public function render()
    {
        return view('livewire.conducting.study-selection.paper-authors');
    }
}
