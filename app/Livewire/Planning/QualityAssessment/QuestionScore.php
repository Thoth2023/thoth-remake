<?php

namespace App\Livewire\Planning\QualityAssessment;

use Livewire\Attributes\On;
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
  public $currentQuestion;
  public $questions = [];
  public $sum = 0;

  /**
   * Fields to be filled by the form.
   */
  public $questionId;
  public $scoreRule;
  public $score;
  public $description;
  public $weight;


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
    'weight' => 'required|numeric',
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
      'weight.required' => __($this->translationPath . '.weight.required'),
    ];
  }

  public function mount()
  {
    $this->projectId = request()->segment(2);
    $this->currentProject = ProjectModel::findOrFail($this->projectId);
    $this->questions = Question::where('id_project', $this->projectId)->get();
    $this->score = 50;
    $this->sum = $this->questions->sum('weight');
  }

  #[On('update-score-questions')]
  public function updateQuestions()
  {
    $projectId = $this->currentProject->id_project;
    $this->questions = Question::where('id_project', $projectId)->get();
  }

  function resetFields()
  {
    $this->questionId = '';
    $this->scoreRule = '';
    $this->score = 50;
    $this->description = '';
    $this->weight = '';
  }

  /**
   * Dispatch a toast message to the view.
   */
  public function toast(string $message, string $type)
  {
    $this->dispatch('question-score', ToastHelper::dispatch($type, $message));
  }

  /**
   * Submit the form. It validates the input fields
   * and creates or updates an item.
   */
  public function submit()
  {
    $this->validate();

    try {
      $value = $this->form['isEditing'] ? 'Updated the quality score ' : 'Added a quality score';
      $toastMessage = __($this->toastMessages . ($this->form['isEditing']
        ? '.updated' : '.added'));

      $create = QualityScoreModel::create([
        'score_rule' => $this->scoreRule,
        'description' => $this->description,
        'score' => $this->score,
        'id_qa' => $this->questionId["value"],
      ]);

      Log::logActivity(
        action: $value,
        description: $create->description,
        projectId: $this->currentProject->id_project
      );

      $this->toast(
        message: $toastMessage,
        type: 'success'
      );
    } catch (\Exception $e) {
      $this->toast(
        message: $e->getMessage(),
        type: 'error'
      );
    } finally {
      $this->resetFields();
    }
  }

  public function render()
  {
    return view('livewire.planning.quality-assessment.question-score');
  }
}
