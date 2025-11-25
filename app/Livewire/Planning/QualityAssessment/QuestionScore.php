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
use App\Traits\ProjectPermissions;

/**
 * Componente Livewire para gerenciar pontuações de questões.
 *
 * Este componente permite criar, editar e gerenciar regras de pontuação
 * para questões de qualidade, incluindo suas descrições e valores.
 */
class QuestionScore extends Component
{

  use ProjectPermissions;

  /** @var string Caminho para as mensagens de toast */
  private $toastMessages = 'project/planning.quality-assessment.question-score.toasts';
  public $currentProject;
  public $currentQuestionScore;
  public $questions = [];
  public $sum = 0;

  /**
   * Campos a serem preenchidos pelo formulário.
   */
  /** @var array ID da questão selecionada */
  public $questionId;
  public $scoreRule;
  public $score;
  public $scoreRuleOptions = ['yes','partial','insufficient','no'];
  public $description;


  /**
   * Estado do formulário.
   */
  /** @var array Estado do formulário */
  public $form = [
    'isEditing' => false,
  ];

  /**
   * Regras de validação para os campos do formulário.
   */
  protected $rules = [
    'questionId' => 'array|required',
    'scoreRule' => 'required|string|max:30|regex:/^[a-zA-ZÀ-ÿ\s]+$/u',
    'score' => 'required|numeric',
    'description' => 'required|string|max:255|regex:/^[a-zA-ZÀ-ÿ0-9\s]+$/u',
  ];

  /**
   * Mensagens de erro personalizadas para as regras de validação.
   *
   * @return array Mensagens de erro
   */
  protected function messages()
  {
    return [
      'questionId.required' => __('common.required'),
      'questionId.array' => __('common.required'),
      'scoreRule.required' => __('common.required'),
      'scoreRule.regex' => __('project/planning.quality-assessment.question-score.messages.score_rule_only_letters'),
      'score.required' => __('common.required'),
      'description.required' => __('common.required'),
      'description.regex' => __('project/planning.quality-assessment.question-score.messages.description_only_letters_numbers'),
  ];
  }

  /**
   * Inicializa o componente, carregando o projeto e suas questões.
   */
  public function mount()
  {
    $this->projectId = request()->segment(2);
    $this->currentProject = ProjectModel::findOrFail($this->projectId);
    $this->currentQuestionScore = null;
    $this->questions = Question::where('id_project', $this->projectId)->get();
    $this->score = 50;
    $this->questionId = null;
  }

  /**
   * Atualiza a lista de questões.
   * Disparado quando as questões são modificadas.
   */
  #[On('update-score-questions')]
  public function updateQuestions()
  {

    if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
      return;
    }

    $projectId = $this->currentProject->id_project;
    $this->questions = Question::where('id_project', $projectId)->get();
  }

  /**
   * Inicia o processo de edição de uma pontuação de questão.
   *
   * @param int $questionScoreId ID da pontuação a ser editada
   */
  #[On('edit-question-score')]
  public function editQuestionScore($questionScoreId)
  {

    if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
      return;
    }

    $this->currentQuestionScore = QualityScore::findOrFail($questionScoreId);
    $this->questionId["value"] = $this->currentQuestionScore->id_qa;
    $this->scoreRule = $this->currentQuestionScore->score_rule;
    $this->score = $this->currentQuestionScore->score;
    $this->description = $this->currentQuestionScore->description;
    $this->form['isEditing'] = true;
  }

  /**
   * Reseta os campos do formulário para seus valores padrão.
   */
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
   * Dispara uma notificação toast para o usuário.
   *
   * @param string $message Mensagem a ser exibida
   * @param string $type Tipo de toast (success, error, etc)
   */
  public function toast(string $message, string $type)
  {
    $this->dispatch('question-score', ToastHelper::dispatch($type, $message));
  }

  /**
   * Retorna as mensagens de tradução do componente.
   *
   * @return array Mensagens traduzidas
   */
  public function translate()
  {
    return [
      'unique-score-rule' => 'The score rule already exists in this question.'
    ];
  }

  /**
   * Valida e submete os dados do formulário.
   * Cria ou atualiza uma pontuação de questão.
   */
  public function submit()
  {

    if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
      return;
    }

    $this->validate();

    try {
        $value = $this->form['isEditing'] ? 'Updated the quality score ' : 'Added a quality score';
        $toastMessage = __($this->toastMessages . ($this->form['isEditing']
            ? '.updated' : '.added'));

        if (!$this->form['isEditing']) {
            $alreadyExists = QualityScoreModel::where([
                'id_qa' => $this->questionId["value"],
                'score' => $this->score,
            ])->exists();

            if ($alreadyExists) {
                $this->toast(
                    message: __('project/planning.quality-assessment.question-score.messages.unique_score_rule'),
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
            module: 1,
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


  /**
   * Atualiza o valor da pontuação quando a regra é modificada.
   *
   * @param string $value Nova regra de pontuação
   */
  public function updatedScoreRule($value)
  {
      if (in_array($value, ['yes', 'partial','insufficient', 'no'])) {
          switch ($value) {
              case 'yes':
                  $this->score = 100;
                  break;
              case 'partial':
                  $this->score = 50;
                  break;
              case 'insufficient':
                  $this->score = 25;
                  break;
              case 'no':
                  $this->score = 0;
                  break;
          }
      } else {
          $this->score = 50;
      }
  }

  /**
   * Atualiza o valor da pontuação.
   *
   * @param float $value Novo valor da pontuação
   */
  public function updatedScore($value)
  {
      $this->score = $value;
  }

  /**
   * Renderiza o componente.
   *
   * @return \Illuminate\View\View
   */
  public function render()
  {
    return view('livewire.planning.quality-assessment.question-score');
  }
}
