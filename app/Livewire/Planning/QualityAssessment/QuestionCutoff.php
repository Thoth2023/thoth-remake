<?php

namespace App\Livewire\Planning\QualityAssessment;

use Livewire\Component;

class QuestionCutoff extends Component
{
  public $sum = 0;
  public $cutoff = 0;
  public $questions = [];

  public function mount()
  {
    $this->sum = 0;
    $this->cutoff = 0;
  }

  public function render()
  {
    return view('livewire.planning.quality-assessment.question-cutoff');
  }
}
