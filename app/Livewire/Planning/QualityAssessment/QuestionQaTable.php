<?php

namespace App\Livewire\Planning\QualityAssessment;

use App\Models\Project;
use App\Models\Project\Planning\QualityAssessment\QualityScore;
use App\Models\Project\Planning\QualityAssessment\Question;
use App\Utils\ToastHelper;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Traits\ProjectPermissions;

class QuestionQaTable extends Component
{

  use ProjectPermissions;

  public $currentProject;
  public $questions = [];
  private $toastMessages = 'project/planning.quality-assessment.general-score.livewire.toasts';

  public function mount()
  {
    $projectId = request()->segment(2);
    $this->currentProject = Project::findOrFail($projectId);
    $this->populateQuestions();
  }

  /**
   * Dispatch a toast message to the view.
   */
  public function toast(string $message, string $type)
  {
    $this->dispatch('qa-table', ToastHelper::dispatch($type, $message));
  }

  /**
   * Fetches all questions with their quality scores for the current project.
   */
  #[On('update-qa-table')]
  public function populateQuestions()
  {
    $projectId = $this->currentProject->id_project;
    $questions = Question::where('id_project', $projectId)->with('qualityScores')->get();
    $this->questions = $questions;
  }

  public function editQuestionQuality($questionId)
  {

    if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
      return;
    }

    $this->dispatch('edit-question-quality', $questionId);
  }

  public function editQuestionScore($questionScoreId)
  {

    if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
      return;
    }

    $this->dispatch('edit-question-score', $questionScoreId);
  }
  
  /**
   * Updates or creates the minimum score required for a question to be applicable.
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
     * Deletes a specific quality score for a question.
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
        message: 'Minimal score deleted successfully.',
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
   * Dispatches an event to delete a question quality entry.
   */
  public function deleteQuestionQuality($questionId)
  {

    if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
      return;
    }

    $this->dispatch('delete-question-quality', $questionId);
  }

  /**
   * Render the component.
   */
  public function render()
  {
    return view('livewire.planning.quality-assessment.question-qa-table');
  }
}
