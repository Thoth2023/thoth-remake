<?php

namespace App\Livewire\Conducting\StudySelection;

use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class PaperCount extends Component
{
    public $databaseId;
    public $projectId;
    public $paperCount = 0;

    public function mount($databaseId, $projectId)
    {
        $this->databaseId = $databaseId;
        $this->projectId = $projectId;
        $this->loadPaperCount();
    }
    #[On('refreshPapersCount')]
    public function loadPaperCount()
    {
        $this->paperCount = DB::table('papers')
            ->join('bib_upload', 'papers.id_bib', '=', 'bib_upload.id_bib')
            ->join('project_databases', 'bib_upload.id_project_database', '=', 'project_databases.id_project_database')
            ->where('project_databases.id_project', $this->projectId)
            ->where('project_databases.id_database', $this->databaseId)
            ->count();
    }

    public function render()
    {
        return view('livewire.conducting.study-selection.paper-count');
    }
}
