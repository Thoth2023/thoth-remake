<?php

namespace App\Livewire\Planning\QualityAssessment;

use App\Models\Member as MemberModel;
use App\Models\Project;
use App\Models\Project\Planning\QualityAssessment\Cutoff;
use App\Models\Project\Planning\QualityAssessment\GeneralScore;
use App\Models\Project\Planning\QualityAssessment\Question;
use App\Models\Project\Conducting\QualityAssessment\PapersQa;
use App\Models\Project\Conducting\QualityAssessment\PapersQaAnswer;
use App\Utils\ToastHelper;
use App\Utils\ActivityLogHelper as Log;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Traits\ProjectPermissions;

/**
 * Componente Livewire para gerenciar os valores de corte (cutoff) para avaliação de qualidade.
 */
class QuestionCutoff extends Component
{
    use ProjectPermissions;

    public $currentProject;
    public $questions       = [];
    public $isCutoffMaxValue;
    public $sum             = 0;
    public $selectedGeneralScore;
    public $generalScores   = [];
    public $generalScoresMessage;

    // Estado do modal
    public $confirmingCutoff = false;

    private $toastMessages = 'project/planning.quality-assessment.general-score.livewire.toasts';

    private function translate(string $message, string $key = 'toasts')
    {
        return __('project/planning.quality-assessment.min-general-score.livewire.' . $key . '.' . $message);
    }

    public function mount()
    {
        $projectId            = request()->segment(2);
        $this->currentProject = Project::findOrFail($projectId);
        $this->questions      = Question::where('id_project', $projectId)->get();
        $this->sum            = $this->questions->sum('weight');
        $this->generalScores  = GeneralScore::where('id_project', $projectId)->get();

        $this->generalScoresMessage = $this->generalScores->isEmpty()
            ? __('project/planning.quality-assessment.min-general-score.form.empty')
            : null;

        if (Cutoff::where('id_project', $projectId)->exists()) {
            $cutoff                      = Cutoff::where('id_project', $projectId)->first();
            $this->cutoff                = $cutoff->score ?? 0;
            $this->oldCutoff             = $cutoff->score ?? 0;
            $this->selectedGeneralScore  = $cutoff->id_general_score;
        } else {
            Cutoff::create(['id_project' => $projectId, 'score' => 0]);
            $this->cutoff               = 0;
            $this->oldCutoff            = 0;
            $this->selectedGeneralScore = null;
        }
    }

    // -----------------------------------------------------------------------
    // Helpers de avaliações QA
    // -----------------------------------------------------------------------

    private function projectHasQaEvaluations(): bool
    {
        $memberIds = MemberModel::where('id_project', $this->currentProject->id_project)
            ->pluck('id_members');

        return PapersQa::whereIn('id_member', $memberIds)
            ->where('id_status', '!=', 3)
            ->exists();
    }

    private function resetQaEvaluations(): void
    {
        $memberIds = MemberModel::where('id_project', $this->currentProject->id_project)
            ->pluck('id_members');

        $papersQa = PapersQa::whereIn('id_member', $memberIds)
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
    // Cutoff
    // -----------------------------------------------------------------------

    /**
     * Verifica se há avaliações antes de salvar o cutoff.
     * Se houver, abre modal de confirmação.
     */
    public function updateCutoff()
    {
        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            $this->reloadCutoff();
            return;
        }

        if (is_null($this->selectedGeneralScore) || $this->selectedGeneralScore === 0) {
            $this->toast(message: $this->translate('required'), type: 'error');
            return;
        }

        if ($this->projectHasQaEvaluations()) {
            $this->confirmingCutoff = true;
            $this->dispatch('openQaCutoffConfirm');
            return;
        }

        $this->persistCutoff();
    }

    /**
     * Chamado após confirmação do modal de cutoff.
     */
    public function confirmCutoff()
    {
        $this->persistCutoff(resetEvaluations: true);
        $this->confirmingCutoff = false;
    }

    private function persistCutoff(bool $resetEvaluations = false): void
    {
        $projectId = $this->currentProject->id_project;

        $selectedGeneralScore = is_array($this->selectedGeneralScore)
            ? $this->selectedGeneralScore['value']
            : $this->selectedGeneralScore;

        Log::logActivity(
            action: $this->translate('updated'),
            description: $selectedGeneralScore,
            module: 1,
            projectId: $projectId
        );

        Cutoff::updateOrCreate(
            ['id_project' => $projectId],
            ['id_general_score' => $selectedGeneralScore]
        );

        $this->reloadCutoff();
        $this->toast(message: $this->translate('updated'), type: 'success');
        $this->dispatch('update-select-minimal-approve');

        if ($resetEvaluations) {
            $this->resetQaEvaluations();
        }
    }

    // -----------------------------------------------------------------------
    // Listeners
    // -----------------------------------------------------------------------

    #[On('update-weight-sum')]
    public function updateSum()
    {
        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        $this->questions = Question::where('id_project', $this->currentProject->id_project)->get();
        $this->sum       = $this->questions->sum('weight');
    }

    #[On('update-cutoff')]
    public function updateSumCutoff()
    {
        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        $this->questions = Question::where('id_project', $this->currentProject->id_project)->get();
        $this->sum       = $this->questions->sum('weight');
    }

    #[On('general-scores-generated')]
    public function reloadGeneralScores()
    {
        $this->generalScores = GeneralScore::where('id_project', $this->currentProject->id_project)->get();
    }

    #[On('update-select-minimal-approve')]
    public function reloadCutoff()
    {
        $cutoff = Cutoff::where('id_project', $this->currentProject->id_project)->first();

        if ($cutoff) {
            $this->selectedGeneralScore = $cutoff->id_general_score;
        }
    }

    private function toast(string $message, string $type)
    {
        $this->dispatch('question-cutoff', ToastHelper::dispatch($type, $message));
    }

    public function render()
    {
        return view('livewire.planning.quality-assessment.question-cutoff');
    }
}
