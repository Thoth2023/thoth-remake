<?php

namespace App\Livewire\Conducting\Snowballing;

use App\Models\BibUpload;
use App\Models\Criteria;
use App\Models\Member;
use App\Models\Project;
use App\Models\Project\Conducting\StudySelection\PaperDecisionConflict;
use App\Models\ProjectDatabases;
use App\Models\StatusSelection;
use App\Models\Project\Conducting\Papers;
use App\Models\StatusSnowballing;
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
    public int $perPage = 100;
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

        $this->setupCriteria();
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
        $this->dispatch('showPaperSnowballing', paper: $paper, criterias: $this->criterias);
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
    #[On('show-success-snowballing')]
    #[On('show-success-quality')]
    #[On('show-success-conflicts-quality')]
    #[On('refreshPapersCount')]
    #[On('import-success')]
    public function render()
    {

        $idsDatabase = ProjectDatabases::where('id_project', $this->projectId)->pluck('id_project_database');
        $idsBib = BibUpload::whereIn('id_project_database', $idsDatabase)->pluck('id_bib')->toArray();

        // Buscar o membro específico para o projeto atual
        $member = Member::where('id_user', auth()->user()->id)
            ->where('id_project', $this->projectId) // Certificar-se de que o membro pertence ao projeto atual
            ->first();

        $databases = ProjectDatabases::where('id_project', $this->projectId)
            ->join('data_base', 'project_databases.id_database', '=', 'data_base.id_database')
            ->pluck('data_base.name', 'project_databases.id_database')
            ->toArray();

        $statuses = StatusSnowballing::pluck('description', 'id')->toArray();

        if (empty($idsBib)) {
            session()->flash('error', 'Não existem papers importados para este projeto.');
            $papers = new LengthAwarePaginator([], 0, $this->perPage);
        } else {
            //pegar os papers que foram aceitos na fase de QA ou database Snowballing Studies
            $query = Papers::whereIn('id_bib', $idsBib)
                ->join('data_base', 'papers.data_base', '=', 'data_base.id_database')
                ->join('status_snowballing', 'papers.status_extraction', '=', 'status_snowballing.id')
                ->join('papers_qa', 'papers_qa.id_paper', '=', 'papers.id_paper')
                ->leftJoin('paper_decision_conflicts', 'papers.id_paper', '=', 'paper_decision_conflicts.id_paper')

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
                ->select('papers.*', 'data_base.name as database_name', 'status_snowballing.description as status_description');

            if ($this->search) {
                $query = $query->where('title', 'like', '%' . $this->search . '%');
            }

            if ($this->selectedDatabase) {
                $query = $query->where('papers.data_base', $this->selectedDatabase);
            }

            if ($this->selectedStatus) {
                $query = $query->where('papers.status_snowballing', $this->selectedStatus);
            }

            foreach ($this->sorts as $field => $direction) {
                $query = $query->orderBy($field, $direction);
            }

            $papers = $query->paginate($this->perPage);

            // Verificar se há conflitos para cada paper
            foreach ($papers as $paper) {
                // Verificar se o paper foi aceito em "Avaliação por Pares" na fase "quality" com new_status_paper = 1
                $paper->peer_review_accepted = PaperDecisionConflict::where('id_paper', $paper->id_paper)
                    ->where('phase', 'quality') // Verificar se a fase é "quality"
                    ->where('new_status_paper', 1) // Verificar se o status é 1 (Aceito)
                    ->exists();
            }
        }

        return view('livewire.conducting.snowballing.table', compact('papers', 'databases', 'statuses'));
    }

}
