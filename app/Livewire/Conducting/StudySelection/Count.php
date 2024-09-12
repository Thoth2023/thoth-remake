<?php

namespace App\Livewire\Conducting\StudySelection;

use App\Models\BibUpload;
use App\Models\Member;
use App\Models\Project as ProjectModel;
use App\Models\Project\Conducting\Papers;
use App\Models\ProjectDatabases;
use App\Models\StatusSelection;
use Livewire\Attributes\On;
use Livewire\Component;

class Count extends Component
{
    private $toastMessages = 'project/conducting.import-studies.count.toasts';
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
    public $duplicatePercentage = 0;
    public $currentProject;

    public function mount()
    {
        $projectId = request()->segment(2);
        $this->currentProject = ProjectModel::findOrFail($projectId);

    }

    public function loadCounters()
    {
        $idsDatabase = ProjectDatabases::where('id_project', $this->currentProject->id_project)->pluck('id_project_database');
        if ($idsDatabase->isEmpty()) {
            session()->flash('error', __('project/conducting.study-selection.count.toasts.no-databases'));
            return;
        }
        $idsBib = BibUpload::whereIn('id_project_database', $idsDatabase)->pluck('id_bib')->toArray();

        $member = Member::where('id_user', auth()->user()->id)->first();

        //$this->papers = Papers::whereIn('id_bib', $idsBib)->get();
        // contar apenas os papers que contenham o id_member
        $this->papers = Papers::whereIn('id_bib', $idsBib)
            ->join('data_base', 'papers.data_base', '=', 'data_base.id_database')
            ->join('papers_selection', 'papers_selection.id_paper', '=', 'papers.id_paper')
            ->join('status_selection', 'papers_selection.id_status', '=', 'status_selection.id_status')
            ->select('papers.*', 'data_base.name as database_name', 'status_selection.description as status_description')
            ->where('papers_selection.id_member', $member->id_members)
            ->get();

        $statuses = StatusSelection::whereIn('description', ['Rejected', 'Unclassified', 'Removed', 'Accepted', 'Duplicate'])->get()->keyBy('description');

        // Filtra os papers com o status Rejected conforme o id_status em papers_selection
        $this->rejected = Papers::whereIn('id_bib', $idsBib)
            ->join('data_base', 'papers.data_base', '=', 'data_base.id_database')
            ->join('papers_selection', 'papers_selection.id_paper', '=', 'papers.id_paper')
            ->join('status_selection', 'papers_selection.id_status', '=', 'status_selection.id_status')
            ->select('papers.*', 'data_base.name as database_name', 'status_selection.description as status_description')
            ->where('papers_selection.id_member', $member->id_members)
            ->where('papers_selection.id_status', $statuses['Rejected']->id_status)
            ->get();

        $this->unclassified = Papers::whereIn('id_bib', $idsBib)
            ->join('data_base', 'papers.data_base', '=', 'data_base.id_database')
            ->join('papers_selection', 'papers_selection.id_paper', '=', 'papers.id_paper')
            ->join('status_selection', 'papers_selection.id_status', '=', 'status_selection.id_status')
            ->select('papers.*', 'data_base.name as database_name', 'status_selection.description as status_description')
            ->where('papers_selection.id_member', $member->id_members)
            ->where('papers_selection.id_status', $statuses['Unclassified']->id_status)
            ->get();

        //$this->unclassified = $this->papers->where('status_selection', $statuses['Unclassified']->id_status)->toArray();
        $this->removed = Papers::whereIn('id_bib', $idsBib)
            ->join('data_base', 'papers.data_base', '=', 'data_base.id_database')
            ->join('papers_selection', 'papers_selection.id_paper', '=', 'papers.id_paper')
            ->join('status_selection', 'papers_selection.id_status', '=', 'status_selection.id_status')
            ->select('papers.*', 'data_base.name as database_name', 'status_selection.description as status_description')
            ->where('papers_selection.id_member', $member->id_members)
            ->where('papers_selection.id_status', $statuses['Removed']->id_status)
            ->get();

        $this->accepted = Papers::whereIn('id_bib', $idsBib)
            ->join('data_base', 'papers.data_base', '=', 'data_base.id_database')
            ->join('papers_selection', 'papers_selection.id_paper', '=', 'papers.id_paper')
            ->join('status_selection', 'papers_selection.id_status', '=', 'status_selection.id_status')
            ->select('papers.*', 'data_base.name as database_name', 'status_selection.description as status_description')
            ->where('papers_selection.id_member', $member->id_members)
            ->where('papers_selection.id_status', $statuses['Accepted']->id_status)
            ->get();

        $this->duplicates = Papers::whereIn('id_bib', $idsBib)
            ->join('data_base', 'papers.data_base', '=', 'data_base.id_database')
            ->join('papers_selection', 'papers_selection.id_paper', '=', 'papers.id_paper')
            ->join('status_selection', 'papers_selection.id_status', '=', 'status_selection.id_status')
            ->select('papers.*', 'data_base.name as database_name', 'status_selection.description as status_description')
            ->where('papers_selection.id_member', $member->id_members)
            ->where('papers_selection.id_status', $statuses['Duplicate']->id_status)
            ->get();

        $totalPapers = count($this->papers);
        $this->rejectedPercentage = $totalPapers > 0 ? count($this->rejected) / $totalPapers * 100 : 0;
        $this->unclassifiedPercentage = $totalPapers > 0 ? count($this->unclassified) / $totalPapers * 100 : 0;
        $this->acceptedPercentage = $totalPapers > 0 ? count($this->accepted) / $totalPapers * 100 : 0;
        $this->removedPercentage = $totalPapers > 0 ? count($this->removed) / $totalPapers * 100 : 0;
        $this->duplicatePercentage = $totalPapers > 0 ? count($this->duplicates) / $totalPapers * 100 : 0;

    }

    /*#[On('show-success')]
    #[On('import-success')]
    public function refreshCounters()
    {
        $this->loadCounters();
        $this->dispatch('reload-count');

    }*/

    private function updateDuplicates($duplicatePaperIds, $duplicateStatusId)
    {
        if (count($duplicatePaperIds) === 0) {
            return;
        }
        // Atualiza o status dos papers com IDs encontrados como duplicados
        Papers::whereIn('id_paper', $duplicatePaperIds)->update(['status_selection' => $duplicateStatusId]);
    }

    #[On('show-success')]
    #[On('show-success-conflicts')]
    #[On('import-success')]
    public function render()
    {
        $this->loadCounters();
        //$this->dispatch('reload-count');
        return view('livewire.conducting.study-selection.count');
    }

}
