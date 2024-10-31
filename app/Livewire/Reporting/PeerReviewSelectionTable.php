<?php

namespace App\Livewire\Reporting;

use App\Models\BibUpload;
use App\Models\Member;
use App\Models\Project;
use App\Models\Project\Conducting\StudySelection\PaperDecisionConflict;
use App\Models\Project\Conducting\StudySelection\PapersSelection;
use App\Models\ProjectDatabases;
use App\Models\StatusSelection;
use App\Models\Project\Conducting\Papers;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Pagination\LengthAwarePaginator;

class PeerReviewSelectionTable extends Component
{
    use WithPagination;

    public $currentProject;
    public $projectId;
    public $criterias;
    public array $sorts = [];


    public string $search = '';
    public $perPage = 10;
    public $selectedDatabase = '';
    public $selectedStatus = '';

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->projectId = request()->segment(2);
        $this->currentProject = Project::findOrFail($this->projectId);

    }

    public function updatedSearch()
    {
        $this->resetPage();
    }
    public function updatedSelectedDatabase()
    {
        $this->resetPage();
    }

    public function updatedSelectedStatus()
    {
        $this->resetPage();
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

    #[On('show-success')]
    #[On('show-success-conflicts')]
    #[On('show-success-duplicates')]
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

        $statuses = StatusSelection::pluck('description', 'id_status')->toArray();

        if (empty($idsBib)) {
            session()->flash('error', 'Não existem papers importados para este projeto.');
            $papers = new LengthAwarePaginator([], 0, $this->perPage);
        } else {
            // Consulta inicial dos papers com joins necessários
            $query = Papers::whereIn('papers.id_bib', $idsBib)
                ->join('data_base', 'papers.data_base', '=', 'data_base.id_database')
                ->select('papers.*', 'data_base.name as database_name')
                ->addSelect([
                    // Coluna virtual para priorizar papers com id_status != 3 (Unclassified)
                    'is_unclassified' => PapersSelection::selectRaw('IF(id_status = 3, 1, 0)')
                        ->whereColumn('papers.id_paper', 'papers_selection.id_paper')
                        ->limit(1)
                ]);


            if ($this->search) {
                $query = $query->where('papers.title', 'like', '%' . $this->search . '%');
            }

            if ($this->selectedDatabase) {
                $query = $query->where('papers.data_base', $this->selectedDatabase);
            }

            foreach ($this->sorts as $field => $direction) {
                $query = $query->orderBy($field, $direction);
            }

            // Ordenação principal: Exibir papers com id_status != 3 primeiro e depois os duplicados
            $query->orderBy('is_unclassified', 'asc');

            $papers = $query->paginate($this->perPage);

            // Obtendo os statuses por membro para todos os papers
            $paperIds = $papers->pluck('id_paper');

            $statusesByMember = PapersSelection::whereIn('id_paper', $paperIds)
                ->join('members', 'papers_selection.id_member', '=', 'members.id_members')
                ->join('status_selection', 'papers_selection.id_status', '=', 'status_selection.id_status')
                ->join('users', 'members.id_user', '=', 'users.id')
                ->select('papers_selection.id_paper', 'users.firstname  as member_name', 'status_selection.description as status_description')
                ->get()
                ->groupBy('id_paper');


            // Verificando decisão de "Avaliação por Pares"
            $peerReviewDecisions = PaperDecisionConflict::whereIn('id_paper', $paperIds)
                ->where('phase', 'study-selection')
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
