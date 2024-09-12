<?php

namespace App\Livewire\Conducting\StudySelection;

use App\Models\BibUpload;
use App\Models\Criteria;
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

class Table extends Component
{
    use WithPagination;

    public $currentProject;
    public $projectId;
    public $criterias;
    public array $sorts = [];
    //public array $statuses = [];
    public array $editingStatus = [];

    public string $search = '';
    public $perPage = 100;
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

        $this->setupCriteria();
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

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedPapers = $this->papers->pluck('id_paper')->toArray();
        } else {
            $this->selectedPapers = [];
        }
    }

    private function setupCriteria()
    {
        $criterias = Criteria::where('id_project', $this->projectId)->get();
        $this->criterias = $criterias;
    }

    public function openPaper($paper)
    {
        $this->dispatch('showPaper', paper: $paper, criterias: $this->criterias);
    }

    public function openConflictModal($paper)
    {
        $this->dispatch('showPaperConflict', paper: $paper, criterias: $this->criterias);
    }

    public function updateStatus(string $papersId, $status)
    {
        $paper = Papers::findOrFail($papersId);
        $status = StatusSelection::where('description', $status)->first()->id_status;
        $paper->status_selection = $status;
        $paper->save();

        $value = 'Updated papers status.';
        Log::info('action: ' . $value . ' description: ' . $paper, ['projectId' => $this->currentProject->id_project]);
    }

    public function updateBulkStatus()
    {
        if ($this->bulkStatus && !empty($this->selectedPapers)) {
            $statusId = StatusSelection::find($this->bulkStatus)->id_status;

            Papers::whereIn('id_paper', $this->selectedPapers)->update(['status_selection' => $statusId]);

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

    #[On('show-success')]
    #[On('show-success-conflicts')]
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

            $query = Papers::whereIn('id_bib', $idsBib)
                ->join('data_base', 'papers.data_base', '=', 'data_base.id_database')
                ->join('papers_selection', 'papers_selection.id_paper', '=', 'papers.id_paper')
                ->join('status_selection', 'papers_selection.id_status', '=', 'status_selection.id_status')
                ->select('papers.*', 'data_base.name as database_name', 'status_selection.description as status_description')
                ->where('papers_selection.id_member', $member->id_members);

            if ($this->search) {
                $query = $query->where(function ($query) {
                    $query->where('papers.title', 'like', '%' . $this->search . '%');
                });
            }

            // Aplicar filtros adicionais (database e status)
            if ($this->selectedDatabase) {
                $query = $query->where('papers.data_base', $this->selectedDatabase);
            }

            if ($this->selectedStatus) {
                $query = $query->where('papers.status_selection', $this->selectedStatus);
            }

            // Ordenação
            foreach ($this->sorts as $field => $direction) {
                $query = $query->orderBy($field, $direction);
            }

            // Paginação
            $papers = $query->paginate($this->perPage);

            // Verificar se há conflitos para cada paper
            foreach ($papers as $paper) {
                $paper->has_conflict = PapersSelection::where('id_paper', $paper->id_paper)
                        ->where('id_status', '!=', 3) // Excluindo Unclassified (id=3)
                        ->distinct()
                        ->count('id_status') > 1;
                // Verificar se o paper já foi confirmado na tabela paper_decision_conflicts
                $paper->is_confirmed = PaperDecisionConflict::where('id_paper', $paper->id_paper)->exists();
            }
        }
        // Passa se o membro é administrador/pesquisador
        $isAdministrator = $member->level == 1 || $member->level == 3;
        return view('livewire.conducting.study-selection.table', compact('papers', 'databases', 'statuses','isAdministrator'));
    }


}
