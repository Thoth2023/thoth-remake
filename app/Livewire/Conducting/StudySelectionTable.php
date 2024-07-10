<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Project as ProjectModel;
use App\Models\Project\Planning\QualityAssessment\GeneralScore as GeneralScoreModel;

class StudySelectionTable extends Component
{
    public $currentProject;
    public $generalscore = [];

    public function mount()
    {
        $projectId = request()->segment(2);

        // Debug the projectId
        dd('Project ID: ' . $projectId);

        $this->currentProject = ProjectModel::findOrFail($projectId);

        // Debug the currentProject
        dd($this->currentProject);
        $this->currentProject = ProjectModel::findOrFail($projectId);
        $this->currentGeneralScore = null;
        $this->generalscore = GeneralScoreModel::where(
            'id_project',
            $this->currentProject->id_project
        )->get();

        dd($this->generalscore);
    }

    public function render()
    {

        dd('Render');
        return view('livewire.study-selection-table', [
            'generalscore' => $this->generalscore,
            'currentProject' => $this->currentProject,
        ]);
    }
}
