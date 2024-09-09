<?php

namespace App\Livewire\Conducting\QualityAssessment;

use App\Models\BibUpload;
use App\Models\Member;
use App\Models\Project as ProjectModel;
use App\Models\Project\Conducting\Papers;
use App\Models\ProjectDatabases;
use App\Models\StatusQualityAssessment;
use Livewire\Attributes\On;
use Livewire\Component;

class Count extends Component
{
    private $toastMessages = 'project/conducting.quality-assessment.count.toasts';
    public $papers = [];
    public $accepted = [];
    public $duplicates = [];
    public $removed = [];
    public $rejected = [];
    public $unclassified = [];
    public $rejectedPercentage = 0;
    public $unclassifiedPercentage = 0;
    public $acceptedPercentage = 0;
    public $removedPercentage = 0;
    public $currentProject;

    public function mount()
    {
        $projectId = request()->segment(2);
        $this->currentProject = ProjectModel::findOrFail($projectId);

        $member = Member::where('id_user', auth()->user()->id)->first();

        $idsDatabase = ProjectDatabases::where('id_project', $this->currentProject->id_project)->pluck('id_project_database');

        if ($idsDatabase->isEmpty()) {
            session()->flash('error', __('project/conducting.quality-assessment.count.toasts.no-databases'));
            return;
        }
        $idsBib = BibUpload::whereIn('id_project_database', $idsDatabase)->pluck('id_bib')->toArray();
        //busca paper aceitos em Study Selection
        //$this->papers = Papers::whereIn('id_bib', $idsBib)->where('status_selection', 1)->get();
        $this->papers = Papers::whereIn('id_bib', $idsBib)
            ->join('data_base', 'papers.data_base', '=', 'data_base.id_database')
            ->join('status_selection', 'papers.status_selection', '=', 'status_selection.id_status')
            ->join('papers_qa', 'papers_qa.id_paper', '=', 'papers.id_paper')
            ->select('papers.*', 'data_base.name as database_name', 'status_selection.description as status_description')
            ->where('papers.status_selection', 1)
            ->where('papers_qa.id_member', $member->id_members)
            ->get();

    }

    #[On('show-success-quality')]
    #[On('show-success')]
    #[On('refreshPapersCount')]
    #[On('import-success')]
    public function loadCounters()
    {
        $statuses = StatusQualityAssessment::whereIn('status', ['Rejected', 'Unclassified', 'Removed', 'Accepted'])->get()->keyBy('status');
        $requiredStatuses = ['Rejected', 'Unclassified', 'Removed', 'Accepted'];

        foreach ($requiredStatuses as $status) {
            if (!isset($statuses[$status])) {
                session()->flash('error', "Status '$status' not found.");
                return;
            }
        }

        $this->rejected = $this->papers->where('status_qa', $statuses['Rejected']->id_status)->toArray();
        $this->unclassified = $this->papers->where('status_qa', $statuses['Unclassified']->id_status)->toArray();
        $this->removed = $this->papers->where('status_qa', $statuses['Removed']->id_status)->toArray();
        $this->accepted = $this->papers->where('status_qa', $statuses['Accepted']->id_status)->toArray();

        //pegar os papers aceitos na fase de seleção e passa para a fase de QA, mas algo está estranho no DB, analisar melhor.
        $totalPapers = count($this->papers);
        $this->rejectedPercentage = $totalPapers > 0 ? count($this->rejected) / $totalPapers * 100 : 0;
        $this->unclassifiedPercentage = $totalPapers > 0 ? count($this->unclassified) / $totalPapers * 100 : 0;
        $this->acceptedPercentage = $totalPapers > 0 ? count($this->accepted) / $totalPapers * 100 : 0;
        $this->removedPercentage = $totalPapers > 0 ? count($this->removed) / $totalPapers * 100 : 0;

    }

    #[On('show-success-quality')]
    #[On('show-success')]
    #[On('refreshPapersCount')]
    #[On('import-success')]
    public function render()
    {
        $this->loadCounters();
        return view('livewire.conducting.quality-assessment.count');

    }
}
