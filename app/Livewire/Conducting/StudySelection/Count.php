<?php

namespace App\Livewire\Conducting\StudySelection;

use App\Models\BibUpload;
use App\Models\Project\Conducting\Papers;
use App\Models\ProjectDatabases;
use App\Models\StatusSelection;
use Livewire\Component;

class Count extends Component
{

    public $papers;

    public $accepted;

    public $duplicates;

    public $removed;

    public $rejected;

    public $unclassified;

    public $rejectedPercentage;

    public $unclassifiedPercentage;

    public $acceptedPercentage;

    public $removedPercentage;

    public $duplicatePercentage;

    public function mount()
    {
        $projectId = request()->segment(2);

        $idsDatabase = ProjectDatabases::where('id_project', $projectId)->pluck('id_project_database');

        $idsBib = [];
        $this->duplicates = [];

        if (count($idsDatabase) > 0) {
            $idsBib = BibUpload::whereIn('id_project_database', $idsDatabase)->pluck('id_bib')->toArray();
        }

        $this->papers = Papers::whereIn('id_bib', $idsBib)->get();

        if ($this->papers->isEmpty()) {
            session()->flash('error', 'No papers imported for this project.');
            return;
        }

        $this->duplicates = $this->findDuplicates($this->papers);
        $this->accepted = $this->findAccepted($this->papers);
        $this->removed = $this->findRemoved($this->papers);
        $this->rejected = $this->findRejected($this->papers);
        $this->unclassified = $this->findUnclassified($this->papers);

        // Use operadores ternários para lidar com arrays potencialmente vazios
        $this->rejectedPercentage = $this->rejected ? count($this->rejected) / count($this->papers) * 100 : 0;
        $this->unclassifiedPercentage = $this->unclassified ? count($this->unclassified) / count($this->papers) * 100 : 0;
        $this->acceptedPercentage = $this->accepted ? count($this->accepted) / count($this->papers) * 100 : 0;
        $this->removedPercentage = $this->removed ? count($this->removed) / count($this->papers) * 100 : 0;
        $this->duplicatePercentage = $this->duplicates ? count($this->duplicates) / count($this->papers) * 100 : 0;


        $this->updateDuplicates($this->duplicates);
    }

    private function findRejected($papers) {
        $papersWithRejectedStatus = $papers->map(function ($paper) {
            $isRejected = $paper->status_selection == StatusSelection::where('description', 'Rejected')->first()->id_status;
            return $isRejected ? $paper : null;
        })->filter(function ($paper) {  // Add filter to remove null values
            return $paper !== null;
        });

        return $papersWithRejectedStatus->toArray();
    }

    private function findUnclassified($papers) {
        $papersWithUnclassifiedStatus = $papers->map(function ($paper) {
            $isUnclassified = $paper->status_selection == StatusSelection::where('description', 'Unclassified')->first()->id_status;
            return $isUnclassified ? $paper : null;
        })->filter(function ($paper) {  // Add filter to remove null values
            return $paper !== null;
        });

        return $papersWithUnclassifiedStatus->toArray();
    }

    private function findRemoved($papers) {
        $papersWithRemovedStatus = $papers->map(function ($paper) {
            $isRemoved = $paper->status_selection == StatusSelection::where('description', 'Removed')->first()->id_status;
            return $isRemoved ? $paper : null;
        })->filter(function ($paper) {  // Add filter to remove null values
            return $paper !== null;
        });

        return $papersWithRemovedStatus->toArray();
    }

    private function cleanArr($array) {
        return array_filter($array, fn($value) => !is_null($value));
    }


    private function findAccepted($papers) {
        $papersWithAcceptedStatus = $papers->map(function ($paper) {
            $isAccepted = $paper->status_selection == StatusSelection::where('description', 'Accepted')->first()->id_status;
            return $isAccepted ? $paper : null;
        })->filter(function ($paper) {  // Add filter to remove null values
            return $paper !== null;
        });

        return $papersWithAcceptedStatus->toArray();
    }

    private function updateDuplicates($papers) {
        if (count($papers) == 0) {
            return;
        }



        $papers->map(function ($paper) {
            $paper->status_selection = StatusSelection::where('description', 'Duplicated')->first()->id_status;
            $paper->save();
        });
    }

    private function findDuplicates($papers) {

        $duplicatePaperIds = $papers->map(function ($paper) {
            $isDuplicated = Papers::isDuplicate($paper->title, $paper->id_paper);
            return $isDuplicated ? $paper->id_paper : null;  // Return only id if duplicated
        })->filter(function ($id) {  // Filter non-null IDs
            return $id !== null;
        })->toArray();

        return $duplicatePaperIds;
    }


    public function render()
    {
        return view('livewire.conducting.study-selection.count');
    }
}
