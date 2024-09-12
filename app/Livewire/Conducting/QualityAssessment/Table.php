<?php

namespace App\Livewire\Conducting\QualityAssessment;

use App\Models\BibUpload;
use App\Models\Criteria;
use App\Models\Member;
use App\Models\Project;
use App\Models\Project\Conducting\QualityAssessment\GeneralScore;
use App\Models\Project\Planning\QualityAssessment\Cutoff;
use App\Models\Project\Planning\QualityAssessment\Question;
use App\Models\ProjectDatabases;
use App\Models\StatusQualityAssessment;
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
        $this->dispatch('showPaperQuality', paper: $paper, criterias: $this->criterias);
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
            //pegar os papers que foram aceitos na fase de study select
            $query = Papers::whereIn('papers.id_bib', $idsBib)
                // Junção com outras tabelas
                ->join('data_base', 'papers.data_base', '=', 'data_base.id_database')
                ->join('papers_qa', 'papers_qa.id_paper', '=', 'papers.id_paper')
                ->join('status_qa', 'papers_qa.id_status', '=', 'status_qa.id_status')
                ->join('papers_selection', 'papers_selection.id_paper', '=', 'papers_qa.id_paper')
                ->join('general_score', 'papers_qa.id_gen_score', '=', 'general_score.id_general_score')
                ->leftJoin('paper_decision_conflicts', 'papers.id_paper', '=', 'paper_decision_conflicts.id_paper')

                // Filtrar papers que tenham `id_status = 1` ou `id_status = 2` com base em condições
                ->where(function ($query) {
                    $query->where('papers_selection.id_status', 1)
                        ->orWhere(function ($query) {
                            $query->where('papers_selection.id_status', 2)
                                ->where('paper_decision_conflicts.new_status_paper', 1);
                        });
                })
                // Filtrando pelo membro correto
                ->where('papers_selection.id_member', $member->id_members)
                ->where('papers_qa.id_member', $member->id_members)

                // Selecionar os campos desejados
                ->select(
                    'papers.*',
                    'data_base.name as database_name',
                    'status_qa.status as status_description',
                    'papers_qa.score as score',
                    'general_score.description as general_score'
                );

            if ($this->search) {
                $query = $query->where('title', 'like', '%' . $this->search . '%');
            }
            if ($this->selectedDatabase) {
                $query = $query->where('papers.data_base', $this->selectedDatabase);
            }
            if ($this->selectedStatus) {
                $query = $query->where('papers.status_qa', $this->selectedStatus);
            }
            foreach ($this->sorts as $field => $direction) {
                $query = $query->orderBy($field, $direction);
            }
            //dd($query);
            $papers = $query->paginate($this->perPage);
        }
        return view('livewire.conducting.quality-assessment.table', compact('papers', 'databases', 'statuses'));
    }

}
