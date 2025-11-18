<?php

namespace App\Livewire\Conducting\Snowballing;

use App\Models\BibUpload;
use App\Models\Member;
use App\Models\Project as ProjectModel;
use App\Models\Project\Conducting\Papers;
use App\Models\Project\Conducting\PaperSnowballing;
use App\Models\ProjectDatabases;
use App\Models\StatusSnowballing;
use Livewire\Attributes\On;
use Livewire\Component;

class Count extends Component
{
    public $papers = [];
    public $done = [];
    public $todo = [];
    public $relevantCount = 0;

    public $donePercentage = 0;
    public $todoPercentage = 0;
    public $totalPapers = 0;

    public $currentProject;

    public function mount()
    {
        $projectId = request()->segment(2);
        $this->currentProject = ProjectModel::findOrFail($projectId);
    }

    public function loadCounters()
    {
        // Membro do projeto
        $member = Member::where('id_user', auth()->user()->id)
            ->where('id_project', $this->currentProject->id_project)
            ->first();

        $idsDatabase = ProjectDatabases::where('id_project', $this->currentProject->id_project)
            ->pluck('id_project_database');

        if ($idsDatabase->isEmpty()) {
            session()->flash('error', __('project/conducting.snowballing.count.toasts.no-databases'));
            return;
        }

        $idsBib = BibUpload::whereIn('id_project_database', $idsDatabase)
            ->pluck('id_bib')
            ->toArray();

        // Papers aceitos na QA
        $this->papers = Papers::whereIn('id_bib', $idsBib)
            ->join('data_base', 'papers.data_base', '=', 'data_base.id_database')
            ->join('status_snowballing', 'papers.status_snowballing', '=', 'status_snowballing.id')
            ->join('papers_qa', 'papers_qa.id_paper', '=', 'papers.id_paper')
            ->leftJoin('paper_decision_conflicts', 'papers.id_paper', '=', 'paper_decision_conflicts.id_paper')
            ->select(
                'papers.*',
                'data_base.name as database_name',
                'status_snowballing.description as status_description'
            )
            ->where(function ($query) {
                $query->where('papers_qa.id_status', 1)
                    ->orWhere('papers.data_base', 16)
                    ->orWhere(function ($query) {
                        $query->where('papers_qa.id_status', 2)
                            ->where('paper_decision_conflicts.phase', 'quality')
                            ->where('paper_decision_conflicts.new_status_paper', 1);
                    });
            })
            ->where('papers.status_qa', 1)
            ->where('papers_qa.id_member', $member->id_members)
            ->distinct()
            ->get();

        // Buscar status válidos (Done, To Do)
        $statuses = StatusSnowballing::whereIn('description', ['Done', 'To Do'])
            ->get()
            ->keyBy('description');

        if (!isset($statuses['Done']) || !isset($statuses['To Do'])) {
            session()->flash('error', 'Os status "Done" e "To Do" não foram encontrados na tabela status_snowballing.');
            return;
        }

        // Filtragem por status
        $this->done = $this->papers->where('status_snowballing', $statuses['Done']->id)->toArray();
        $this->todo = $this->papers->where('status_snowballing', $statuses['To Do']->id)->toArray();

        // Contagem de referências relevantes (is_relevant = true)
        $paperIds = collect($this->papers)->pluck('id_paper')->toArray();
        $this->relevantCount = PaperSnowballing::whereIn('paper_reference_id', $paperIds)
            ->where('is_relevant', true)
            ->count();

        // Totais e porcentagens
        $this->totalPapers = count($this->papers);
        $this->donePercentage = $this->totalPapers > 0 ? count($this->done) / $this->totalPapers * 100 : 0;
        $this->todoPercentage = $this->totalPapers > 0 ? count($this->todo) / $this->totalPapers * 100 : 0;
    }

    #[On('success-relevant-paper')]
    #[On('show-success-snowballing')]
    #[On('refreshPapersCount')]
    #[On('show-success-quality')]
    #[On('show-success-conflicts-quality')]
    #[On('import-success')]
    public function render()
    {
        $this->loadCounters();
        return view('livewire.conducting.snowballing.count');
    }
}
