<?php

namespace App\Livewire\Planning\QualityAssessment;

use App\Models\Project;
use App\Models\Project\Planning\QualityAssessment\QualityScore;
use App\Models\Project\Planning\QualityAssessment\Question;
use App\Utils\ToastHelper;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Traits\ProjectPermissions;

/**
 * Componente Livewire para gerenciar a tabela de questões e avaliações de qualidade.
 * 
 * Este componente permite visualizar, editar e gerenciar questões e suas pontuações
 * de qualidade associadas ao projeto.
 */
class QuestionQaTable extends Component
{

  use ProjectPermissions;

  /** @var Project Projeto atual sendo avaliado */
  public $currentProject;

  /** @var array Lista de questões com suas pontuações de qualidade */
  public $questions = [];

  /** @var string Caminho para as mensagens de toast */
  private $toastMessages = 'project/planning.quality-assessment.general-score.livewire.toasts';

  /**
   * Inicializa o componente, carregando o projeto atual e suas questões.
   */
  public function mount()
  {
    $projectId = request()->segment(2);
    $this->currentProject = Project::findOrFail($projectId);
    $this->populateQuestions();
  }

  /**
   * Dispara uma notificação toast para o usuário.
   *
   * @param string $message Mensagem a ser exibida
   * @param string $type Tipo de toast (success, error, etc)
   */
  public function toast(string $message, string $type)
  {
    $this->dispatch('qa-table', ToastHelper::dispatch($type, $message));
  }

  /**
   * Busca todas as questões com suas pontuações de qualidade para o projeto atual.
   * Disparado quando a tabela precisa ser atualizada.
   */
  #[On('update-qa-table')]
  public function populateQuestions()
  {
    $projectId = $this->currentProject->id_project;
    $questions = Question::where('id_project', $projectId)->with('qualityScores')->get();
    $this->questions = $questions;
  }

  /**
   * Inicia o processo de edição de uma questão de qualidade.
   *
   * @param int $questionId ID da questão a ser editada
   */
  public function editQuestionQuality($questionId)
  {

    if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
      return;
    }

    $this->dispatch('edit-question-quality', $questionId);
  }

  /**
   * Inicia o processo de edição de uma pontuação de questão.
   *
   * @param int $questionScoreId ID da pontuação a ser editada
   */
  public function editQuestionScore($questionScoreId)
  {

    if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
      return;
    }

    $this->dispatch('edit-question-score', $questionScoreId);
  }
  
  /**
   * Atualiza ou cria a pontuação mínima necessária para uma questão ser aplicável.
   *
   * @param int $questionId ID da questão
   * @param float $minToApp Pontuação mínima para aprovação
   */
  public function updateMinimalScore($questionId, $minToApp)
  {

    if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
      return;
    }

    Question::updateOrCreate([
      'id_qa' => $questionId
    ], [
      'min_to_app' => $minToApp
    ]);

    $this->populateQuestions();

    $this->toast(
      message: __('project/planning.quality-assessment.min-general-score.form.minimal-score'),
      type: 'success'
    );
  }

   /**
     * Exclui uma pontuação de qualidade específica para uma questão.
     */
  public function deleteQuestionScore($questionScoreId)
  {

    if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
      return;
    }

    try {
      $currentQuestionScore = QualityScore::findOrFail($questionScoreId);
      $currentQuestionScore->delete();

      $this->populateQuestions();
      $this->toast(
        message: 'Pontuação excluída com sucesso.',
        type: 'success'
      );
      $this->dispatch('update-weight-sum');
    } catch (\Exception $e) {
      $this->toast(
        message: $e->getMessage(),
        type: 'error'
      );
    }
  }

  /**
   * Dispara um evento para excluir uma entrada de qualidade de questão.
   */
  public function deleteQuestionQuality($questionId)
  {

    if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
      return;
    }

    $this->dispatch('delete-question-quality', $questionId);
  }

  /**
   * Renderiza o componente.
   */
  public function render()
  {
    return view('livewire.planning.quality-assessment.question-qa-table');
  }
}
