<?php

namespace App\Livewire\Planning\QualityAssessment;

use App\Models\Member as MemberModel;
use App\Models\Project;
use App\Models\Project\Planning\QualityAssessment\QualityScore;
use App\Models\Project\Planning\QualityAssessment\Question;
use App\Models\Project\Conducting\QualityAssessment\PapersQA;
use App\Models\Project\Conducting\QualityAssessment\PapersQaAnswer;
use App\Utils\ToastHelper;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Traits\ProjectPermissions;

/**
 * Componente Livewire para gerenciar a tabela de questões e avaliações de qualidade.
 */
class QuestionQaTable extends Component
{
    use ProjectPermissions;

    public $currentProject;
    public $questions = [];

    private $toastMessages = 'project/planning.quality-assessment.general-score.livewire.toasts';

    // Estado dos modais
    public $confirmingDeleteQuestionId   = null;
    public $confirmingDeleteScoreId      = null;
    public $confirmingMinScore           = null; // ['questionId' => x, 'minToApp' => y]
    public $deletionHasEvaluations       = false;

    public function mount()
    {
        $projectId            = request()->segment(2);
        $this->currentProject = Project::findOrFail($projectId);
        $this->populateQuestions();
    }

    public function toast(string $message, string $type)
    {
        $this->dispatch('qa-table', ToastHelper::dispatch($type, $message));
    }

    #[On('update-qa-table')]
    public function populateQuestions()
    {
        $this->questions = Question::where('id_project', $this->currentProject->id_project)
            ->with('qualityScores')
            ->get();
    }

    // -----------------------------------------------------------------------
    // Helpers de avaliações QA
    // -----------------------------------------------------------------------

    private function projectHasQaEvaluations(): bool
    {
        $memberIds = MemberModel::where('id_project', $this->currentProject->id_project)
            ->pluck('id_members');

        return PapersQA::whereIn('id_member', $memberIds)
            ->where('id_status', '!=', 3)
            ->exists();
    }

    private function questionHasEvaluations(int $questionId): bool
    {
        $memberIds = MemberModel::where('id_project', $this->currentProject->id_project)
            ->pluck('id_members');

        return PapersQaAnswer::where('id_question', $questionId)
            ->whereIn(
                'id_paper',
                PapersQA::whereIn('id_member', $memberIds)
                    ->where('id_status', '!=', 3)
                    ->pluck('id_paper')
            )->exists();
    }

    private function resetQaEvaluations(): void
    {
        $memberIds = MemberModel::where('id_project', $this->currentProject->id_project)
            ->pluck('id_members');

        $papersQa = PapersQA::whereIn('id_member', $memberIds)
            ->where('id_status', '!=', 3)
            ->get();

        if ($papersQa->isEmpty()) {
            return;
        }

        $questionIds = Question::where('id_project', $this->currentProject->id_project)
            ->pluck('id_qa');

        PapersQaAnswer::whereIn('id_paper', $papersQa->pluck('id_paper'))
            ->whereIn('id_question', $questionIds)
            ->delete();

        foreach ($papersQa as $pqa) {
            $pqa->update(['id_status' => 3]);
        }

        $this->toast(
            message: __('project/planning.quality-assessment.question-quality.livewire.toasts.reset_qa_evaluations'),
            type: 'warning'
        );
    }

    // -----------------------------------------------------------------------
    // Edit (sem impacto em avaliações — só redireciona)
    // -----------------------------------------------------------------------

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

    // -----------------------------------------------------------------------
    // Pontuação mínima para aprovação
    // -----------------------------------------------------------------------

    /**
     * Verifica se há avaliações antes de alterar min_to_app.
     * Se houver, abre modal de confirmação.
     */
    public function confirmUpdateMinimalScore($questionId, $minToApp)
    {
        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        if ($this->projectHasQaEvaluations()) {
            $this->confirmingMinScore = ['questionId' => $questionId, 'minToApp' => $minToApp];
            $this->dispatch('openQaMinScoreConfirm');
            return;
        }

        $this->applyMinimalScore($questionId, $minToApp);
    }

    /**
     * Chamado após confirmação do modal de min_to_app.
     */
    public function confirmMinScore()
    {
        if (!$this->confirmingMinScore) {
            return;
        }

        $this->applyMinimalScore(
            $this->confirmingMinScore['questionId'],
            $this->confirmingMinScore['minToApp'],
            resetEvaluations: true
        );

        $this->confirmingMinScore = null;
    }

    private function applyMinimalScore($questionId, $minToApp, bool $resetEvaluations = false): void
    {
        Question::updateOrCreate(
            ['id_qa' => $questionId],
            ['min_to_app' => $minToApp]
        );

        $this->populateQuestions();

        $this->toast(
            message: __('project/planning.quality-assessment.min-general-score.form.minimal-score'),
            type: 'success'
        );

        if ($resetEvaluations) {
            $this->resetQaEvaluations();
        }
    }

    // -----------------------------------------------------------------------
    // Delete questão
    // -----------------------------------------------------------------------

    /**
     * Verifica avaliações e abre modal antes de excluir a questão.
     */
    public function confirmDeleteQuestionQuality($questionId)
    {
        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        $this->confirmingDeleteQuestionId = $questionId;
        $this->deletionHasEvaluations     = $this->questionHasEvaluations($questionId);

        $this->dispatch('openQaDeleteQuestionConfirm');
    }

    /**
     * Executa exclusão da questão após confirmação.
     */
    public function deleteQuestionQuality($questionId)
    {
        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        // Usar o ID recebido como parâmetro OU o que está armazenado no estado
        $id = $questionId ?? $this->confirmingDeleteQuestionId;

        if (!$id) {
            $this->toast(message: 'Question not found.', type: 'error');
            return;
        }

        $this->dispatch('delete-question-quality', $id);

        // Reset DEPOIS do dispatch
        $this->confirmingDeleteQuestionId = null;
        $this->deletionHasEvaluations     = false;
    }

    // -----------------------------------------------------------------------
    // Delete score
    // -----------------------------------------------------------------------

    /**
     * Verifica avaliações e abre modal antes de excluir o score.
     */
    public function confirmDeleteQuestionScore($questionScoreId)
    {
        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        $score = QualityScore::findOrFail($questionScoreId);

        $this->confirmingDeleteScoreId = $questionScoreId;
        $this->deletionHasEvaluations  = $this->questionHasEvaluations($score->id_qa);

        $this->dispatch('openQaDeleteScoreConfirm');
    }

    /**
     * Executa exclusão do score após confirmação.
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
                message: __('project/planning.quality-assessment.question-quality.livewire.toasts.score_deleted'),
                type: 'success'
            );
            $this->dispatch('update-weight-sum');
            $this->resetQaEvaluations();

        } catch (\Exception $e) {
            $this->toast(message: $e->getMessage(), type: 'error');
        } finally {
            $this->confirmingDeleteScoreId = null;
            $this->deletionHasEvaluations  = false;
        }
    }

    public function render()
    {
        return view('livewire.planning.quality-assessment.question-qa-table');
    }
}
