<?php

namespace App\Livewire\Planning\QualityAssessment;

use App\Models\Project;
use App\Models\Project\Planning\QualityAssessment\Question;
use Livewire\Attributes\On;
use Livewire\Component;

class QuestionQaTable extends Component
{
  public $currentProject;
  public $questions = [];

  public function mount()
  {
    $projectId = request()->segment(2);
    $this->currentProject = Project::findOrFail($projectId);
    $this->populateQuestions();
  }

  #[On('update-qa-table')]
  public function populateQuestions()
  {
    $projectId = $this->currentProject->id_project;
    $questions = Question::where('id_project', $projectId)->with('qualityScores')->get();
    $this->questions = $questions;
  }

  public function render()
  {
    return view('livewire.planning.quality-assessment.question-qa-table');
  }
}
