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
      'questionId.required' => __('common.required'),
      'scoreRule.required' => __('common.required'),
      'score.required' => __('common.required'),
      'description.required' => __('common.required'),
    ];
  }

  public function mount()
  {
    $this->projectId = request()->segment(2);
    $this->currentProject = ProjectModel::findOrFail($this->projectId);
    $this->questions = Question::where('id_project', $this->projectId)->get();
    $this->score = 50;
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
  }

  /**
   * Dispatch a toast message to the view.
   */
  public function toast(string $message, string $type)
  {
    $this->dispatch('question-score', ToastHelper::dispatch($type, $message));
  }

  public function translate()
  {
    return [
      'unique-score-rule' => 'The score rule already exists in this question.'
    ];
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

      if (!$this->form['isEditing']) {
        $alreadyExists = QualityScoreModel::where([
          'id_qa' => $this->questionId["value"],
          'score_rule' => $this->scoreRule,
        ])->exists();

        if ($alreadyExists) {
          $this->toast(
            message: $this->translate()['unique-score-rule'],
            type: 'info'
          );
          return;
        }
      }

      $create = QualityScoreModel::updateOrCreate([
        'id_score' => $this->currentQuestion?->id_score,
      ], [
        'score_rule' => trim($this->scoreRule),
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

      $this->dispatch('update-qa-table');
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
