<?php

namespace App\Livewire\Planning\QualityAssessment;

use Livewire\Attributes\On;
use Livewire\Component;

class QuestionQaTable extends Component
{
  public $questions = [];

  #[On('populate-questions')]
  public function populateQuestions($questions)
  {
    $this->questions = $questions;
  }

  public function render()
  {
    return view('livewire.planning.quality-assessment.question-qa-table');
  }
}
