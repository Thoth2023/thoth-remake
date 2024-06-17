<?php

namespace App\Livewire\Planning\QualityAssessment;

use App\Models\Project;
use App\Models\Project\Planning\QualityAssessment\MinToApp;
use App\Models\Project\Planning\QualityAssessment\Question;
use Livewire\Attributes\On;
use Livewire\Component;

class QuestionCutoff extends Component
{
  public $currentProject;
  public $questions = [];

  public $sum = 0;
  public $cutoff = 0;

  public function mount()
  {
    $projectId = request()->segment(2);
    $this->currentProject = Project::findOrFail($projectId);
    $this->questions = Question::where('id_project', $projectId)->get();
    $this->sum = $this->questions->sum('weight');
    $this->cutoff = $this->questions->first() || 0;
  }

  #[On('update-weight-sum')]
  public function updateSum()
  {
    $projectId = $this->currentProject->id_project;
    $this->questions = Question::where('id_project', $projectId)->get();
    $this->sum = $this->questions->sum('weight');
  }

  public function updateCutoff()
  {
    $cutoff = $this->cutoff;
    $projectId = $this->currentProject->id;

    $this->questions->each(function ($question) use ($cutoff, $projectId) {
      MinToApp::where('id_project', $projectId)->update(['min_to_app' => $cutoff]);
    });
  }

  public function render()
  {
    return view('livewire.planning.quality-assessment.question-cutoff');
  }
}
