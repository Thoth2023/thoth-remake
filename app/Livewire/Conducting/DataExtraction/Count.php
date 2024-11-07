<?php

namespace App\Livewire\Conducting\DataExtraction;

use App\Models\BibUpload;
use App\Models\Member;
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

    }

    public function loadCounters()
    {
        // Buscar o membro específico para o projeto atual
        $member = Member::where('id_user', auth()->user()->id)
            ->where('id_project', $this->currentProject->id_project) // Certificar-se de que o membro pertence ao projeto atual
            ->first();

        $idsDatabase = ProjectDatabases::where('id_project', $this->currentProject->id_project)->pluck('id_project_database');

        if ($idsDatabase->isEmpty()) {
            session()->flash('error', __('project/conducting.data-extraction.count.toasts.no-databases'));
            return;
        }
        $idsBib = BibUpload::whereIn('id_project_database', $idsDatabase)->pluck('id_bib')->toArray();
        $this->papers = Papers::whereIn('id_bib', $idsBib)
            ->join('data_base', 'papers.data_base', '=', 'data_base.id_database')
            ->join('status_extraction', 'papers.status_extraction', '=', 'status_extraction.id_status')
            ->join('papers_qa', 'papers_qa.id_paper', '=', 'papers.id_paper')
            ->leftJoin('paper_decision_conflicts', 'papers.id_paper', '=', 'paper_decision_conflicts.id_paper')

            // Filtrar papers que tenham `id_status = 1` ou `id_status = 2` com base em condições
            ->where(function ($query) {
                $query->where('papers_qa.id_status', 1)
                    ->orWhere(function ($query) {
                        $query->where('papers_qa.id_status', 2)
                            ->where('paper_decision_conflicts.phase', 'quality')
                            ->where('paper_decision_conflicts.new_status_paper', 1);
                    });
            })
            // Filtrando pelo membro correto
            ->where('papers.status_qa', 1)
            ->where('papers_qa.id_member', $member->id_members)
            ->distinct()
            ->select('papers.*', 'data_base.name as database_name', 'status_extraction.description as status_description')
            ->get();

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


    /*#[On('refreshPapersCount')]
    public function refreshCounters()
    {
       $this->loadCounters();

        $this->dispatch('count', [
            'message' => __('project/conducting.data-extraction.count.toasts.data-refresh'),
            'type' => 'success',
        ]);

    }*/
    #[On('show-success-quality')]
    #[On('show-success-extraction')]
    #[On('show-success-conflicts-quality')]
    #[On('refreshPapersCount')]
    #[On('import-success')]
    public function render()
    {

        //carrega os contadores de papers
        $this->loadCounters();
        return view('livewire.conducting.data-extraction.count');
    }
}
