<?php

namespace App\Livewire\Conducting\Snowballing;

use App\Models\BibUpload;
use App\Models\Project as ProjectModel;
use App\Models\Project\Conducting\Papers;
use App\Models\ProjectDatabases;
use App\Models\StatusSnowballing;
use Livewire\Attributes\On;
use Livewire\Component;

class Count extends Component
{
    private $toastMessages = 'project/conducting.snowballing.count.toasts';
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

        $idsDatabase = ProjectDatabases::where('id_project', $this->currentProject->id_project)->pluck('id_project_database');

        if ($idsDatabase->isEmpty()) {
            session()->flash('error', __('project/conducting.snowballing.count.toasts.no-databases'));
            return;
        }
        $idsBib = BibUpload::whereIn('id_project_database', $idsDatabase)->pluck('id_bib')->toArray();
        $this->papers = Papers::whereIn('id_bib', $idsBib)->get();

        //dd($papers);

        if ($this->papers->isEmpty()) {
            session()->flash('error', __('project/conducting.snowballing.count.toasts.no-papers'));
            return;
        }

        //carrega os contadores de papers
        $this->loadCounters();
    }


    public function loadCounters()
    {
        $statuses = StatusSnowballing::whereIn('description', ['Rejected', 'Unclassified', 'Removed', 'Accepted', 'Duplicate'])->get()->keyBy('description');
        $requiredStatuses = ['Rejected', 'Unclassified', 'Removed', 'Accepted', 'Duplicate'];

        foreach ($requiredStatuses as $status) {
            if (!isset($statuses[$status])) {
                session()->flash('error', "Status '$status' not found.");
                return;
            }
        }

        //analisar sobre o campo status_snowballing na tabela papers
        $this->rejected = $this->papers->where('status_snowballing', $statuses['Rejected']->id)->toArray();
        $this->unclassified = $this->papers->where('status_snowballing', $statuses['Unclassified']->id)->toArray();
        $this->removed = $this->papers->where('status_snowballing', $statuses['Removed']->id)->toArray();
        $this->accepted = $this->papers->where('status_snowballing', $statuses['Accepted']->id)->toArray();
        $this->duplicates = $this->papers->where('status_snowballing', $statuses['Duplicate']->id)->toArray();

        $totalPapers = count($this->papers);
        $this->rejectedPercentage = $totalPapers > 0 ? count($this->rejected) / $totalPapers * 100 : 0;
        $this->unclassifiedPercentage = $totalPapers > 0 ? count($this->unclassified) / $totalPapers * 100 : 0;
        $this->acceptedPercentage = $totalPapers > 0 ? count($this->accepted) / $totalPapers * 100 : 0;
        $this->removedPercentage = $totalPapers > 0 ? count($this->removed) / $totalPapers * 100 : 0;
        $this->duplicatePercentage = $totalPapers > 0 ? count($this->duplicates) / $totalPapers * 100 : 0;

    }


    #[On('refreshPapersCount')]
    public function refreshCounters()
    {
       $this->loadCounters();

        $this->dispatch('count', [
            'message' => __('project/conducting.snowballing.count.toasts.data-refresh'),
            'type' => 'success',
        ]);


    }

    private function updateDuplicates($duplicatePaperIds, $duplicateStatusId)
    {
        if (count($duplicatePaperIds) === 0) {
            return;
        }

        // Atualiza o status dos papers com IDs encontrados como duplicados
        Papers::whereIn('id_paper', $duplicatePaperIds)->update(['status_selection' => $duplicateStatusId]);
    }


    public function render()
    {
        return view('livewire.conducting.snowballing.count');
    }
}
