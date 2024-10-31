<?php

namespace App\Livewire\Reporting;

use App\Models\BibUpload;
use App\Models\Member;
use App\Models\Project;
use App\Models\Project\Conducting\QualityAssessment\PapersQA;
use App\Models\Project\Conducting\StudySelection\PaperDecisionConflict;
use App\Models\ProjectDatabases;
use App\Models\StatusQualityAssessment;
use App\Models\Project\Conducting\Papers;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Pagination\LengthAwarePaginator;

class PeerReviewQualityTable extends Component
{
    use WithPagination;
    public $currentProject;
    public $projectId;
    public array $sorts = [];
    //public array $statuses = [];
    public array $editingStatus = [];
    public int $perPage = 10;
    public string $search = '';
    public $selectedDatabase = '';
    public $selectedStatus = '';
    public $bulkStatus = '';
    public array $selectedPapers = [];
    public bool $selectAll = false;
    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->projectId = request()->segment(2);
        $this->currentProject = Project::findOrFail($this->projectId);
    }
    public function updatedSelectedDatabase()
    {
        $this->resetPage();
    }
    public function updatedSelectedStatus()
    {
        $this->resetPage();
    }
    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedPapers = $this->papers->pluck('id_paper')->toArray();
        } else {
            $this->selectedPapers = [];
        }
    }
    public function openPaper($paper)
    {
        $this->dispatch('showPaperQuality', paper: $paper);
    }
    public function openConflictModalQuality($paper)
    {
        $this->dispatch('showPaperConflictQuality', paper: $paper);
    }

    public function updateStatus(string $papersId, $status)
    {
        $paper = Papers::findOrFail($papersId);
        $status = StatusQualityAssessment::where('status', $status)->first()->id_status;
        $paper->status_selection = $status;
        $paper->save();

        $value = 'Updated papers status.';
        Log::info('action: ' . $value . ' status: ' . $paper, ['projectId' => $this->currentProject->id_project]);
    }

    public function updateBulkStatus()
    {
        if ($this->bulkStatus && !empty($this->selectedPapers)) {
            $statusId = StatusQualityAssessment::find($this->bulkStatus)->id_status;

            Papers::whereIn('id_paper', $this->selectedPapers)->update(['status_qa' => $statusId]);

            $value = 'Updated papers status in bulk.';
            Log::info('action: ' . $value, ['projectId' => $this->currentProject->id_project]);
        }
    }
    public function sortBy($field)
    {
        if (!isset($this->sorts[$field])) {
            $this->sorts[$field] = 'asc';
        } else {
            $this->sorts[$field] = $this->sorts[$field] === 'asc' ? 'desc' : 'asc';
        }
    }
    public function applyFilters()
    {
        $this->resetPage();
    }

    #[On('refreshPapersCount')]
    #[On('show-success-quality')]
    #[On('show-success')]
    #[On('show-success-conflicts')]
    #[On('show-success-conflicts-quality')]
    #[On('import-success')]
    public function render()
    {
        $idsDatabase = ProjectDatabases::where('id_project', $this->projectId)->pluck('id_project_database');
        $idsBib = BibUpload::whereIn('id_project_database', $idsDatabase)->pluck('id_bib')->toArray();

        $member = Member::where('id_user', auth()->user()->id)->first();

        $databases = ProjectDatabases::where('id_project', $this->projectId)
            ->join('data_base', 'project_databases.id_database', '=', 'data_base.id_database')
            ->pluck('data_base.name', 'project_databases.id_database')
            ->toArray();

        $statuses = StatusQualityAssessment::pluck('status', 'id_status')->toArray();

        if (empty($idsBib)) {
            session()->flash('error', 'Não existem papers importados para este projeto.');
            $papers = new LengthAwarePaginator([], 0, $this->perPage);
        } else {
            // Consulta inicial dos papers com joins necessários
            $query = Papers::whereIn('papers.id_bib', $idsBib)
                ->join('data_base', 'papers.data_base', '=', 'data_base.id_database')
                ->join('papers_qa', 'papers_qa.id_paper', '=', 'papers.id_paper')
                ->join('status_qa', 'papers_qa.id_status', '=', 'status_qa.id_status')
                ->join('papers_selection', 'papers_selection.id_paper', '=', 'papers_qa.id_paper')
                ->join('general_score', 'papers_qa.id_gen_score', '=', 'general_score.id_general_score')
                ->leftJoin('paper_decision_conflicts', 'papers.id_paper', '=', 'paper_decision_conflicts.id_paper');

            // Filtro para id_status = 1 ou id_status = 2
            $query->where(function ($query) {
                $query->where('papers_selection.id_status', 1)
                    ->orWhere(function ($query) {
                        $query->where('papers_selection.id_status', 2)
                            ->where('paper_decision_conflicts.phase', 'study-selection')
                            ->where('paper_decision_conflicts.new_status_paper', 1);
                    });
            })

            // Filtrando pelo membro correto
            ->where('papers_selection.id_member', $member->id_members)
                ->where('papers_qa.id_member', $member->id_members)
                ->distinct()
                ->select(
                    'papers.*',
                    'data_base.name as database_name',
                    'status_qa.status as status_description',
                    'papers_qa.score as score',
                    'general_score.description as general_score'
                );

            if ($this->search) {
                $query = $query->where('papers.title', 'like', '%' . $this->search . '%');
            }

            if ($this->selectedDatabase) {
                $query = $query->where('papers.data_base', $this->selectedDatabase);
            }

            foreach ($this->sorts as $field => $direction) {
                $query = $query->orderBy($field, $direction);
            }

            $papers = $query->paginate($this->perPage);

            // Obtendo os statuses por membro para todos os papers
            $paperIds = $papers->pluck('id_paper');

            $statusesByMember = PapersQA::whereIn('id_paper', $paperIds)
                ->join('members', 'papers_qa.id_member', '=', 'members.id_members')
                ->join('status_qa', 'papers_qa.id_status', '=', 'status_qa.id_status')
                ->join('users', 'members.id_user', '=', 'users.id')
                ->select('papers_qa.id_paper', 'users.firstname as member_name', 'status_qa.status as status_description')
                ->get()
                ->groupBy('id_paper');


            // Verificação de decisão "Avaliação por Pares"
            $peerReviewDecisions = PaperDecisionConflict::whereIn('id_paper', $paperIds)
                ->where('phase', 'quality')
                ->select('id_paper', 'new_status_paper')
                ->get()
                ->keyBy('id_paper');

            // Inicializar coleções vazias caso não existam dados
            $statusesByMember = $statusesByMember ?? collect();
            $peerReviewDecisions = $peerReviewDecisions ?? collect();

            // Associar as informações aos papers
            foreach ($papers as $paper) {
                // Utilizar a função `get` com valor padrão caso o item não exista
                $paper->statuses_by_member = $statusesByMember->get($paper->id_paper, collect());
                $paper->peer_review_decision = $peerReviewDecisions->get($paper->id_paper, null);
            }
        }

        $isAdministrator = $member->level == 1 || $member->level == 3;

        return view('livewire.reporting.peer-review-selection-table', compact('papers', 'databases', 'statuses', 'isAdministrator'));
    }

}
