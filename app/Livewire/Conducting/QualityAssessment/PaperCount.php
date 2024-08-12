<?php

namespace App\Livewire\Conducting\QualityAssessment;

use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class PaperCount extends Component
{
    public $databaseId;
    public $projectId;
    public $paperCount = 0;

    //protected $listeners = ['refreshPapers' => 'loadPaperCount'];

    public function mount($databaseId, $projectId)
    {
        $this->databaseId = $databaseId;
        $this->projectId = $projectId;
        $this->loadPaperCount();
    }
    #[On('refreshPapers')]
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
        return view('livewire.conducting.quality-assessment.paper-count');
    }
}
