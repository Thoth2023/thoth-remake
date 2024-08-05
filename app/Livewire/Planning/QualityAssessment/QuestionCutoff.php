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


    public function mount()
    {
        $projectId = request()->segment(2);
        $this->currentProject = Project::findOrFail($projectId);
        $this->questions = Question::where('id_project', $projectId)->get();
        $this->sum = $this->questions->sum('weight');

        // Atualize para pegar apenas os GeneralScores vinculados ao projeto
        $this->generalScores = GeneralScore::where('id_project', $projectId)->get();

        // Mensagem quando não há pontuações gerais
        if ($this->generalScores->isEmpty()) {
            $this->generalScoresMessage = 'No general scores available. Please register general scores.';
        } else {
            $this->generalScoresMessage = null;
        }

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

    #[On('update-weight-sum')]
    public function updateSum()
    {
        $projectId = $this->currentProject->id_project;
        $this->questions = Question::where('id_project', $projectId)->get();
        $this->sum = $this->questions->sum('weight');
    }

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


    public function updateCutoff()
    {
        $projectId = $this->currentProject->id_project;

        $selectedGeneralScore = is_array($this->selectedGeneralScore) ? $this->selectedGeneralScore['value'] : $this->selectedGeneralScore;


        // Validação
        if ($selectedGeneralScore === null) {
            $this->toast(
                message: 'Please select a valid general score.',
                type: 'info',
            );
            return;
        }

        Log::logActivity(
            action: 'Updating Min to Aprove with values',
            description:  $selectedGeneralScore,
            projectId : $projectId
        );

        // Atualize ou crie o cutoff
        Cutoff::updateOrCreate(['id_project' => $projectId], [
            'id_project' => $projectId,
            'id_general_score' => $selectedGeneralScore,
        ]);

        $this->toast(
            message: 'Minimal score to approve updated successfully',
            type: 'success',
        );
        //$this->dispatch('update-minimal-approve');

    }


    public function render()
    {
        return view('livewire.planning.quality-assessment.question-cutoff');
    }

    private function toast(string $message, string $type)
    {
        $this->dispatch('question-cutoff', ToastHelper::dispatch($type, $message));
    }

}
