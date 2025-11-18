<?php

namespace App\Livewire\Conducting\Snowballing;

use App\Models\BibUpload;
use App\Models\Criteria;
use App\Models\Member;
use App\Models\Project;
use App\Models\Project\Conducting\Papers;
use App\Models\Project\Conducting\PaperSnowballing;
use App\Models\Project\Conducting\StudySelection\PaperDecisionConflict;
use App\Models\ProjectDatabases;
use App\Models\StatusSelection;
use App\Models\StatusSnowballing;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    public $currentProject;
    public $projectId;
    public $criterias;
    public array $sorts = [];
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

    private function setupCriteria()
    {
        $this->criterias = Criteria::where('id_project', $this->projectId)->get();
    }

    public function updatedSelectedDatabase() { $this->resetPage(); }
    public function updatedSelectedStatus() { $this->resetPage(); }

    public function updatedSelectAll($value)
    {
        $this->selectedPapers = $value
            ? $this->papers->pluck('id_paper')->toArray()
            : [];
    }

    public function openPaper($paper)
    {
        $this->dispatch('showPaperSnowballing', paper: $paper, criterias: $this->criterias);
    }

    public function openPaperRelevant($ref)
    {
        // Dispara o evento para abrir o modal do paper relevante
        $this->dispatch('showPaperSnowballingRelevant', paper: $ref);
    }

    public function updateStatus(string $papersId, $status)
    {
        $paper = Papers::findOrFail($papersId);
        $statusId = StatusSelection::where('description', $status)->first()->id_status;
        $paper->status_selection = $statusId;
        $paper->save();

        Log::info('Updated paper status', [
            'paper_id' => $papersId,
            'projectId' => $this->currentProject->id_project
        ]);
    }

    public function updateBulkStatus()
    {
        if ($this->bulkStatus && !empty($this->selectedPapers)) {
            $statusId = StatusSelection::find($this->bulkStatus)->id_status;
            Papers::whereIn('id_paper', $this->selectedPapers)
                ->update(['status_selection' => $statusId]);

            Log::info('Bulk status update', [
                'projectId' => $this->currentProject->id_project
            ]);
        }
    }

    public function sortBy($field)
    {
        $this->sorts[$field] = $this->sorts[$field] === 'asc' ?? null
            ? 'desc' : 'asc';
    }

    public function applyFilters() { $this->resetPage(); }

    #[On('success-relevant-paper')]
    #[On('show-success-snowballing')]
    #[On('show-success-quality')]
    #[On('show-success-conflicts-quality')]
    #[On('refreshPapersCount')]
    #[On('import-success')]
    public function render()
    {
        $idsDatabase = ProjectDatabases::where('id_project', $this->projectId)->pluck('id_project_database');
        $idsBib = BibUpload::whereIn('id_project_database', $idsDatabase)->pluck('id_bib')->toArray();

        $member = Member::where('id_user', auth()->user()->id)
            ->where('id_project', $this->projectId)
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
            $query = Papers::whereIn('id_bib', $idsBib)
                ->join('data_base', 'papers.data_base', '=', 'data_base.id_database')
                ->join('status_snowballing', 'papers.status_snowballing', '=', 'status_snowballing.id')
                ->leftJoin('papers_qa', 'papers_qa.id_paper', '=', 'papers.id_paper')
                ->leftJoin('paper_decision_conflicts', 'papers.id_paper', '=', 'paper_decision_conflicts.id_paper')
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
                ->distinct()
                ->select('papers.*', 'data_base.name as database_name', 'status_snowballing.description as status_description');

            if ($this->search) $query->where('title', 'like', '%' . $this->search . '%');
            if ($this->selectedDatabase) $query->where('papers.data_base', $this->selectedDatabase);
            if ($this->selectedStatus) $query->where('papers.status_snowballing', $this->selectedStatus);

            foreach ($this->sorts as $field => $direction) {
                $query->orderBy($field, $direction);
            }

            $papers = $query->paginate($this->perPage);

            foreach ($papers as $paper) {
                $paper->peer_review_accepted = PaperDecisionConflict::where('id_paper', $paper->id_paper)
                    ->where('phase', 'quality')
                    ->where('new_status_paper', 1)
                    ->exists();

                // Verifica se possui referências relevantes (filhas)
                $paper->relevant_children = PaperSnowballing::where('paper_reference_id', $paper->id_paper)
                    ->where('is_relevant', true)
                    ->get();
            }
        }

        $this->dispatch('papers-updated', hasPapers: $papers->isNotEmpty());

        return view('livewire.conducting.snowballing.table', compact('papers', 'databases', 'statuses'));
    }
}
