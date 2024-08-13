<?php

namespace App\Livewire\Conducting\DataExtraction;

use App\Models\BibUpload;
use App\Models\Project as ProjectModel;
use App\Models\Project\Conducting\Papers;
use App\Models\ProjectDatabases;
use App\Models\StatusExtraction;
use Livewire\Attributes\On;
use Livewire\Component;

class Count extends Component
{
    private $toastMessages = 'project/conducting.data-extraction.count.toasts';
    public $papers = [];
    public $done = [];
    public $removed = [];
    public $to_do = [];
    public $to_doPercentage = 0;
    public $donePercentage = 0;
    public $removedPercentage = 0;

    public $currentProject;

    public function mount()
    {
        $projectId = request()->segment(2);
        $this->currentProject = ProjectModel::findOrFail($projectId);

        $idsDatabase = ProjectDatabases::where('id_project', $this->currentProject->id_project)->pluck('id_project_database');

        if ($idsDatabase->isEmpty()) {
            session()->flash('error', __('project/conducting.data-extraction.count.toasts.no-databases'));
            return;
        }
        $idsBib = BibUpload::whereIn('id_project_database', $idsDatabase)->pluck('id_bib')->toArray();
        $this->papers = Papers::whereIn('id_bib', $idsBib)->get();

        //dd($papers);

        if ($this->papers->isEmpty()) {
            session()->flash('error', __('project/conducting.data-extraction.count.toasts.no-papers'));
            return;
        }

        //carrega os contadores de papers
        $this->loadCounters();
    }


    public function loadCounters()
    {
        $statuses = StatusExtraction::whereIn('description', ['Done', 'To Do', 'Removed'])->get()->keyBy('description');
        $requiredStatuses = ['Done', 'To Do', 'Removed'];

        foreach ($requiredStatuses as $status) {
            if (!isset($statuses[$status])) {
                session()->flash('error', "Status '$status' not found.");
                return;
            }
        }

        $this->done = $this->papers->where('status_extraction', $statuses['Done']->id_status)->toArray();
        $this->to_do = $this->papers->where('status_extraction', $statuses['To Do']->id_status)->toArray();
        $this->removed = $this->papers->where('status_extraction', $statuses['Removed']->id_status)->toArray();

        //pegar os papers aceitos na fase de QA, mas algo está estranho no DB, nas colunas, analisar melhor.
        $totalPapers = count($this->papers);
        $this->donePercentage = $totalPapers > 0 ? count($this->done) / $totalPapers * 100 : 0;
        $this->to_doPercentage = $totalPapers > 0 ? count($this->to_do) / $totalPapers * 100 : 0;
        $this->removedPercentage = $totalPapers > 0 ? count($this->removed) / $totalPapers * 100 : 0;

    }

    #[On('refreshPapers')]
    public function refreshCounters()
    {
       $this->loadCounters();

        $this->dispatch('count', [
            'message' => __('project/conducting.data-extraction.count.toasts.data-refresh'),
            'type' => 'success',
        ]);

    }

    public function render()
    {
        return view('livewire.conducting.data-extraction.count');
    }
}
