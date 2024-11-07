<?php

namespace App\Livewire\Conducting\Snowballing;

use App\Models\BibUpload;
use App\Models\Member;
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


    }

    public function loadCounters()
    {

        // Buscar o membro específico para o projeto atual
        $member = Member::where('id_user', auth()->user()->id)
            ->where('id_project', $this->currentProject->id_project) // Certificar-se de que o membro pertence ao projeto atual
            ->first();

        $idsDatabase = ProjectDatabases::where('id_project', $this->currentProject->id_project)->pluck('id_project_database');

        if ($idsDatabase->isEmpty()) {
            session()->flash('error', __('project/conducting.snowballing.count.toasts.no-databases'));
            return;
        }
        $idsBib = BibUpload::whereIn('id_project_database', $idsDatabase)->pluck('id_bib')->toArray();

        //busca paper aceitos em QA
        $this->papers = Papers::whereIn('id_bib', $idsBib)
            ->join('data_base', 'papers.data_base', '=', 'data_base.id_database')
            ->join('status_snowballing', 'papers.status_extraction', '=', 'status_snowballing.id')
            ->join('papers_qa', 'papers_qa.id_paper', '=', 'papers.id_paper')
            ->leftJoin('paper_decision_conflicts', 'papers.id_paper', '=', 'paper_decision_conflicts.id_paper')
            ->select('papers.*', 'data_base.name as database_name', 'status_snowballing.description as status_description')

            // Filtrar papers que tenham `id_status = 1` ou `id_status = 2` com base em condições
            ->where(function ($query) {
                $query->where('papers_qa.id_status', 1)
                    ->orWhere('papers.data_base', 16)
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
            ->get();

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

    private function updateDuplicates($duplicatePaperIds, $duplicateStatusId)
    {
        if (count($duplicatePaperIds) === 0) {
            return;
        }

        // Atualiza o status dos papers com IDs encontrados como duplicados
        Papers::whereIn('id_paper', $duplicatePaperIds)->update(['status_selection' => $duplicateStatusId]);
    }

    #[On('show-success-snowballing')]
    #[On('show-success-quality')]
    #[On('show-success-conflicts-quality')]
    #[On('refreshPapersCount')]
    #[On('import-success')]
    public function render()
    {
        //carrega os contadores de papers
        $this->loadCounters();
        return view('livewire.conducting.snowballing.count');
    }
}
