<?php

namespace App\Livewire\Planning\QualityAssessment;

use Livewire\Component;
use App\Models\Project as ProjectModel;
use App\Models\Project\Planning\QualityAssessment\Question;
use App\Models\Project\Planning\QualityAssessment\QualityScore as QualityScoreModel;
use App\Utils\ActivityLogHelper as Log;
use App\Utils\ToastHelper;

class QuestionScore extends Component
{
  private $translationPath = 'project/planning.quality-assessment.quality-score.livewire';
  private $toastMessages = 'project/planning.quality-assessment.quality-score.livewire.toasts';
  public $currentProject;
  public $questions = [];

  /**
   * Fields to be filled by the form.
   */
  public $questionId;
  public $scoreRule;
  public $score;
  public $description;


  /**
   * Form state.
   */
  public $form = [
    'isEditing' => false,
  ];

  /**
   * Validation rules.
   */
  protected $rules = [
    'questionId' => 'required',
    'scoreRule' => 'required|string|max:25',
    'score' => 'required|numeric',
    'description' => 'required|string|max:255',
  ];

  /**
   * Custom error messages for the validation rules.
   */
  protected function messages()
  {
    return [
      'questionId.required' => __($this->translationPath . '.questionId.required'),
      'scoreRule.required' => __($this->translationPath . '.rule.required'),
      'score.required' => __($this->translationPath . '.score.required'),
      'description.required' => __($this->translationPath . '.description.required'),
    ];
  }

  public function mount()
  {
    $this->projectId = request()->segment(2);
    $this->currentProject = ProjectModel::findOrFail($this->projectId);
    $this->questions = Question::where('id_project', $this->projectId)->get();
  }

  public function render()
  {
    dd($this->questions);
    return view('livewire.planning.quality-assessment.question-score');
  }
}
