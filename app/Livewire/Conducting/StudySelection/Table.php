<?php

namespace App\Livewire\Conducting\StudySelection;

use App\Models\BibUpload;
use App\Models\Criteria;
use App\Models\Database;
use App\Models\EvaluationCriteria;
use App\Models\Project;
use App\Models\Project\Conducting\Papers;
use App\Models\ProjectDatabases;
use App\Models\StatusSelection;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Table extends Component
{

    /**
     * The current project.
     * 
     */
    public Project $currentProject;

    public $projectId;

    public $papers;
    /**
     * The sort fields.
     * 
     */
    public array $sorts = [];

    public array $statuses = [];

    public array $editingStatus = []; 

    public bool $filterDuplicates = false;

   /**
     * Executed when the component is mounted. It sets the
     * project id and retrieves the items.
     * @return void
     */
    public function mount()
    {
        $this->statuses = [
            __('project/conducting.study-selection.status.duplicated'), 
            __('project/conducting.study-selection.status.removed'), 
            __('project/conducting.study-selection.status.unclassified'),
            __('project/conducting.study-selection.status.included'),
            __('project/conducting.study-selection.status.approved'),
        ];

        $projectId = request()->segment(2);
        $this->currentProject = Project::findOrFail($projectId);

        $idsDatabase = ProjectDatabases::where('id_project', $projectId)->pluck('id_project_database');

        $idsBib = [];

        if (count($idsDatabase) > 0) {
            $idsBib = BibUpload::whereIn('id_project_database', $idsDatabase)->pluck('id_bib')->toArray();
        }

        $this->papers = Papers::whereIn('id_bib', $idsBib)->get();
        
        $this->papers = $this->setupDatabase($this->papers);
        $this->papers = $this->setupCriteria($this->papers);
        $this->papers = $this->setupStatus($this->papers);
        $this->papers = $this->setupDuplicates($this->papers);
        
    }

    private function setupDuplicates() {
        $papers = $this->papers;
        $uniquePapers = [];
        $titles = [];

        foreach ($papers as $paper) {
            if (!in_array($paper->title, $titles)) {
                $uniquePapers[] = $paper;
                $titles[] = $paper->title;
            }
        }

        foreach ($papers as $paper) {
            if (!in_array($paper, $uniquePapers)) {
                $status_selection = StatusSelection::where('description', 'Duplicated')->first();
                $paper['status_selection'] = $status_selection->id_status;
                $paper['status'] = $status_selection->description;
            }
        }

        return $uniquePapers;
    }



    private function setupCriteria($papers)
    {
        $criterias = Criteria::where('id_project', $this->projectId)->get();
        
        foreach($criterias as $criteria) {
            foreach($papers as $paper) {
                
            }
        }

        return $papers;
    }

    private function setupDatabase($papers) 
    {
        foreach($papers as $paper) {
            $database = $paper->database;
            
            $paper['data_base'] = $database->name;
        }

        return $papers;
    }   

    public function openPaper($paperId)
    {
        $paper = $this->papers->firstWhere('id_paper', $paperId);
        $this->dispatch('showPaper', paper: $paper);
    }

    private function setupStatus($papers)
    {
        foreach($papers as $paper) {
            $paper['status'] = "Selecionar";
        }
        return $papers;
    }

    public function updateStatus(string $papersId, $status)
    {
        $paper = Papers::findOrFail($papersId);
        $status = StatusSelection::where('description', $status)->first()->id_status;
        $paper->status_selection = $status;
        $paper->save();

        $value = 'Updated papers status.';

        Log::info(
            'action: ' + $value + 
            'description:' + $paper, 
            projectId: $this->currentProject->id_project
        );
    }

    public function sortBy($field)
    {
        if (!isset($this->sorts[$field])) {
            $this->sorts[$field] = 'asc';
        } else {
            $this->sorts[$field] = $this->sorts[$field] === 'asc' ? 'desc' : 'asc';
        }
    }


    public function render()
    {
        $papers = $this->papers;

        foreach ($this->sorts as $field => $direction) {
            $papers = $direction === 'asc' ? $papers->sortBy($field) : $papers->sortByDesc($field);
        }

        return view('livewire.conducting.study-selection.table', [
            'papers' => $papers,
        ])->extends('layouts.app');
    }

}
