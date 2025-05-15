<?php

namespace App\Livewire\Planning\QualityAssessment;

use App\Models\Project;
use App\Models\Project\Planning\QualityAssessment\Cutoff;
use App\Models\Project\Planning\QualityAssessment\GeneralScore;
use App\Models\Project\Planning\QualityAssessment\Question;
use App\Utils\ToastHelper;
use App\Utils\ActivityLogHelper as Log;
use Livewire\Attributes\On;
use Livewire\Component;
class QuestionCutoff extends Component
{
    public $currentProject;
    public $questions = [];
    public $isCutoffMaxValue;

    public $sum = 0;
    public $selectedGeneralScore;
    public $generalScores = [];

    private function translate(string $message, string $key = 'toasts')
    {
        return __('project/planning.quality-assessment.min-general-score.livewire.' . $key . '.' . $message);
    }

    public function mount()
    {
        $projectId = request()->segment(2);
        $this->currentProject = Project::findOrFail($projectId);
        $this->questions = Question::where('id_project', $projectId)->get();
        $this->sum = $this->questions->sum('weight');

        // Atualize para pegar apenas os GeneralScores vinculados ao projeto
        $this->generalScores = GeneralScore::where('id_project', $projectId)->get();

        // Handle empty state message
        if ($this->generalScores->isEmpty()) {
            $this->generalScoresMessage = __('project/planning.quality-assessment.min-general-score.form.empty');
        } else {
            $this->generalScoresMessage = null;
        }

        // Load or create cutoff data
        if (Cutoff::where('id_project', $projectId)->exists()) {
            $cutoff = Cutoff::where('id_project', $projectId)->first();
            $this->cutoff = $cutoff->score;
            $this->oldCutoff = $cutoff->score;
            $this->selectedGeneralScore = $cutoff->id_general_score;
        } else {
            Cutoff::create(['id_project' => $projectId, 'score' => 0]);
            $this->cutoff = 0;
            $this->oldCutoff = 0;
            $this->selectedGeneralScore = null;
        }
    }

    /**
     * Updates the total weight sum of all questions.
     */
    #[On('update-weight-sum')]
    public function updateSum()
    {
        $projectId = $this->currentProject->id_project;
        $this->questions = Question::where('id_project', $projectId)->get();
        $this->sum = $this->questions->sum('weight');
    }

    /**
     * Refreshes the total weight sum of questions and re-evaluates the cutoff,
     * without enforcing max value constraints.
     */
    #[On('update-cutoff')]
    public function updateSumCutoff()
    {
        $projectId = $this->currentProject->id_project;
        $this->questions = Question::where('id_project', $projectId)->get();
        $this->sum = $this->questions->sum('weight');

        /*if ($this->cutoff > $this->sum) {
            $this->cutoff = $this->sum;
            Cutoff::updateOrCreate(['id_project' => $projectId], [
                'id_project' => $projectId,
                'score' => $this->cutoff,
            ]);
            $this->isCutoffMaxValue = true;
        }*/
    }

    /**
     * Updates the selected general score in the cutoff record.
     * Validates input and logs the update.
     */
    public function updateCutoff()
    {
        $projectId = $this->currentProject->id_project;

        $selectedGeneralScore = is_array($this->selectedGeneralScore) ? $this->selectedGeneralScore['value'] : $this->selectedGeneralScore;

        // Validate if a general score is selected
        if (is_null($this->selectedGeneralScore) || $this->selectedGeneralScore === 0) {
            $this->toast(
                message: $this->translate('required'),
                type: 'error',
            );
            return;
        }

        Log::logActivity(
            action: $this->translate('updated'),
            description:  $selectedGeneralScore,
            projectId: $projectId
        );

        // Update or create cutoff value
        Cutoff::updateOrCreate(
            ['id_project' => $projectId],
            ['id_general_score' => $selectedGeneralScore]
        );

        // Reload updated value and notify
        $this->reloadCutoff();

        $this->toast(
            message: $this->translate('updated'),
            type: 'success',
        );


        $this->dispatch('update-select-minimal-approve');
    }

    /**
     * Reloads the list of general scores.
     */
    #[On('general-scores-generated')]
    public function reloadGeneralScores()
    {
        $projectId = $this->currentProject->id_project;
        $this->generalScores = GeneralScore::where('id_project', $projectId)->get();
    }

     /**
     * Reloads the selected general score cutoff value.
     */
    #[On('update-select-minimal-approve')]
    public function reloadCutoff()
    {
        $projectId = $this->currentProject->id_project;
        $cutoff = Cutoff::where('id_project', $projectId)->first();

        if ($cutoff) {
            $this->selectedGeneralScore = $cutoff->id_general_score;
        }

    }

    /**
     * Render the component.
     */
    public function render()
    {
        return view('livewire.planning.quality-assessment.question-cutoff');
    }

    private function toast(string $message, string $type)
    {
        $this->dispatch('question-cutoff', ToastHelper::dispatch($type, $message));
    }

}
