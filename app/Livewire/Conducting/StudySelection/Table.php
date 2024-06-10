<?php

namespace App\Livewire\Conducting\StudySelection;

use App\Models\BibUpload;
use App\Models\Database;
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
        $this->statuses    = [
            __('project.conducting.study-selection.status.duplicated'), 
            __('project.conducting.study-selection.status.removed'), 
            __('project.conducting.study-selection.status.unclassifield'),
            __('project.conducting.study-selection.status.included'),
            __('project.conducting.study-selection.status.approved'),
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
        // $this->papers = $this->setupCriteria($this->papers);
        $this->papers = $this->setupStatus($this->papers);
        
        if ($this->filterDuplicates) {
            $this->papers = $this->filterDuplicates($this->papers);
        }
    }

    private function setupCriteria($papers)
    {
        foreach($papers as $paper) {
            $criteria = $paper->bib->criteria;
            $paper['criteria'] = $criteria;
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

    private function setupStatus($papers)
    {
        foreach($papers as $paper) {
            $status_selection = StatusSelection::where('id_status', $paper->status_selection)->first();
            $paper['status'] = $status_selection->description;
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

        Log::logActivity(
            action: $value, 
            description: $paper, 
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
            $papers = $papers->sortBy($field, SORT_REGULAR, $direction === 'desc');
        }

        return view('livewire.conducting.study-selection.table', [
            'papers' => $papers,
        ])->extends('layouts.app');
    }

    public function filterDuplicates($papers){

        $uniquePapers = collect();

        foreach($papers as $paper){
            if(!$uniquePapers->contains('title', $paper->title)){
                $uniquePapers->push($paper);
            }
        }

        return $uniquePapers;
    }

    public function toggleFilterDuplicates()
    {
        $this->filterDuplicates = !$this->filterDuplicates;

        if ($this->filterDuplicates) {
            $this->papers = $this->filterDuplicates($this->papers);
        } else {
            $this->mount(); 
        }
    }

}
