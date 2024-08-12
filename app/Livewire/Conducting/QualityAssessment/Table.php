<?php

namespace App\Livewire\Conducting\QualityAssessment;

use App\Models\BibUpload;
use App\Models\Criteria;
use App\Models\Project;
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
        $this->dispatch('showPaper', paper: $paper, criterias: $this->criterias);
    }
    #[On('refreshPapers')]
    public function refreshPapers()
    {
        $this->papers = $this->render();
        $this->dispatch('papersUpdated');
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



    public function render()
    {

        $idsDatabase = ProjectDatabases::where('id_project', $this->projectId)->pluck('id_project_database');
        $idsBib = BibUpload::whereIn('id_project_database', $idsDatabase)->pluck('id_bib')->toArray();

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
                ->join('status_selection', 'papers.status_selection', '=', 'status_selection.id_status')
                ->select('papers.*', 'data_base.name as database_name', 'status_selection.description as status_description')
                ->where('status_selection', 1);

            if ($this->search) {
                $query = $query->where('title', 'like', '%' . $this->search . '%');
            }

            if ($this->selectedDatabase) {
                $query = $query->where('papers.data_base', $this->selectedDatabase);
            }

            if ($this->selectedStatus) {
                $query = $query->where('papers.status_selection', $this->selectedStatus);
            }

            foreach ($this->sorts as $field => $direction) {
                $query = $query->orderBy($field, $direction);
            }

            $papers = $query->paginate($this->perPage);
        }

        return view('livewire.conducting.quality-assessment.table', compact('papers', 'databases', 'statuses'));
    }

}
