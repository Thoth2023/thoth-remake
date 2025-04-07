<?php

namespace App\Livewire\Planning\QualityAssessment;

use App\Models\Project\Planning\QualityAssessment\QualityScore;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\Project as ProjectModel;
use App\Models\Project\Planning\QualityAssessment\Question;
use App\Models\Project\Planning\QualityAssessment\QualityScore as QualityScoreModel;
use App\Utils\ActivityLogHelper as Log;
use App\Utils\ToastHelper;

class QuestionScore extends Component
{
  private $toastMessages = 'project/planning.quality-assessment.question-score.toasts';
  public $currentProject;
  public $currentQuestionScore;
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
    'questionId' => 'array|required',
    'scoreRule' => 'required|string|max:25|regex:/^[a-zA-ZÀ-ÿ\s]+$/u',
    'score' => 'required|numeric',
    'description' => 'required|string|max:255|regex:/^[a-zA-ZÀ-ÿ0-9\s]+$/u',
  ];

  /**
   * Custom error messages for the validation rules.
   */
  protected function messages()
  {
    return [
      'questionId.required' => __('common.required'),
      'questionId.array' => __('common.required'),
      'scoreRule.required' => __('common.required'),
      'scoreRule.regex' => 'A regra de pontuação só pode conter letras e espaços.',
      'score.required' => __('common.required'),
      'description.required' => __('common.required'),
      'description.regex' => 'A descrição só pode conter letras, números e espaços.',
  ];
  }

  public function mount()
  {
    $this->projectId = request()->segment(2);
    $this->currentProject = ProjectModel::findOrFail($this->projectId);
    $this->currentQuestionScore = null;
    $this->questions = Question::where('id_project', $this->projectId)->get();
    $this->score = 50;
    $this->questionId = null;
  }

  #[On('update-score-questions')]
  public function updateQuestions()
  {
    $projectId = $this->currentProject->id_project;
    $this->questions = Question::where('id_project', $projectId)->get();
  }

  #[On('edit-question-score')]
  public function editQuestionScore($questionScoreId)
  {
    $this->currentQuestionScore = QualityScore::findOrFail($questionScoreId);
    $this->questionId["value"] = $this->currentQuestionScore->id_qa;
    $this->scoreRule = $this->currentQuestionScore->score_rule;
    $this->score = $this->currentQuestionScore->score;
    $this->description = $this->currentQuestionScore->description;
    $this->form['isEditing'] = true;
  }

  function resetFields()
  {
    $this->currentQuestionScore = null;
    $this->questionId = null;
    $this->scoreRule = '';
    $this->score = 50;
    $this->description = '';
    $this->form['isEditing'] = false;
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
        'id_score' => $this->currentQuestionScore?->id_score,
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
      $this->resetFields();
    } catch (\Exception $e) {
      $this->toast(
        message: $e->getMessage(),
        type: 'error'
      );
    }
  }

  public function updatedScoreRule($value)
  {
      switch ($value) {
          case 'sim':
              $this->score = 100;
              break;
          case 'partial':
              $this->score = 50;
              break;
          case 'nao':
              $this->score = 0;
              break;
          default:
              $this->score = 50;
              break;
      }

      // $this->toast(
      //     message: __('project/planning.quality-assessment.question-score.form.rule-selected', ['rule' => $value]),
      //     type: 'info'
      // );
  }

  public function render()
  {
    return view('livewire.planning.quality-assessment.question-score');
  }
}
