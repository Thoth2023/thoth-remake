<?php

namespace App\Livewire\Planning\QualityAssessment;

use Livewire\Component;
use App\Models\Project as ProjectModel;
use App\Models\Project\Planning\QualityAssessment\Question as QuestionsModel;
use App\Models\Project\Planning\QualityAssessment\QualityScore as QualityScoreModel;
use App\Utils\ActivityLogHelper as Log;
use App\Utils\ToastHelper;

class QualityScore extends Component
{

    private $translationPath = 'project/planning.quality-assessment.quality-score.livewire';
    private $toastMessages = 'project/planning.quality-assessment.quality-score.livewire.toasts';
    public $currentProject;
    public $currentQualityScore;
    public $currentQuestion;
    public $qualityscore = [];

    /**
     * Fields to be filled by the form.
     */
    public $score_rule;
    public $description;
    public $score;
    public $id_qa;

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
        'currentQuestion' => 'required',
        'score_rule' => 'required|string|max:50',
        'description' => 'required|string|max:255',
        'score' => 'required|numeric',
        'id_qa' => 'required|string|max:10|regex:/^[a-zA-Z0-9]+$/',
    ];

    /**
     * Custom error messages for the validation rules.
     */
    protected function messages()
    {
        return [
            'score_rule.required' => __($this->translationPath . '.rule.required'),
            'description.required' => __($this->translationPath . '.description.required'),
            'score.required' => __($this->translationPath . '.score.required'),
            'id_qa.required' => __($this->translationPath . '.id.required'),
        ];
    }

    /**
     * Executed when the component is mounted. It sets the
     * project id and retrieves the items.
     */
    public function mount()
    {
        //$projectId = request()->segment(2);
        //$this->currentQuestion = QuestionsModel::findOrFail($projectId);
        //$this->currentQualityScore = null;
        //$this->qualityscore = QualityScoreModel::where(
        //    'id_qa',
        //    $this->currentQuestion->id_qa
        //)->get();
        $this->projectId = request()->segment(2);
        // Obtém todas as perguntas relacionadas ao projectId
        $this->currentQuestion = QuestionsModel::where('id_project', $this->projectId)->get()->toArray();
        $this->currentQualityScore = null;

        if (!empty($this->currentQuestion)) {
            $firstQuestion = $this->currentQuestion[0];
            $this->qualityscore = QualityScoreModel::where(
                'id_qa',
                $firstQuestion['id_qa']
            )->get();
        } else {
            $this->qualityscore = collect(); // Garante que $qualityscore seja uma coleção vazia
        }

    }

    /**
     * Reset the fields to the default values.
     */
    public function resetFields()
    {
        $this->score_rule = '';
        $this->description = '';
        $this->score = '';
        $this->id_qa = '';
        $this->currentQualityScore = null;
        $this->form['isEditing'] = false;
    }

    /**
     * Update the items.
     */
    public function updateQualityScore()
    {
        $this->qualityscore = QualityScoreModel::where(
            'id_qa',
            $this->currentQuestion->id_qa
        )->get();
    }
    /**
     * Dispatch a toast message to the view.
     */
    public function toast(string $message, string $type)
    {
        $this->dispatch('quality-score', ToastHelper::dispatch($type, $message));
    }

    /**
     * Submit the form. It validates the input fields
     * and creates or updates an item.
     */
    public function submit()
    {
        $this->validate();

        $projectId = request()->segment(2);
        $this->currentQuestion = QuestionsModel::findOrFail($projectId);

        $updateIf = [
            'id_score' => $this->currentQualityScore?->id_score,
        ];

        try {
            $value = $this->form['isEditing'] ? 'Updated the quality score ' : 'Added a quality score';
            $toastMessage = __($this->toastMessages . ($this->form['isEditing']
                    ? '.updated' : '.added'));

            $updatedOrCreated = QualityScoreModel::updateOrCreate($updateIf, [
                'score_rule' => $this->score_rule,
                'description' => $this->description,
                'score' => $this->score,
                'id_qa' => $this->currentQuestion->id_qa,
            ]);

            Log::logActivity(
                action: $value,
                description: $updatedOrCreated->description,
                projectId: $this->currentProject->id_project
            );

            $this->updateQualityScore();
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
        $project = $this->currentProject;

        return view(
            'livewire.planning.quality-assessment.quality-score',
            compact(
                'project',
            )
        )->extends('layouts.app');
    }
}
