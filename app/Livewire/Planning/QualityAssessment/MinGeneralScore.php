<?php

namespace App\Livewire\Planning\QualityAssessment;

use App\Models\Project as ProjectModel;
use App\Models\Project\Planning\QualityAssessment\GeneralScore as GeneralScoreModel;
use App\Models\Project\Planning\QualityAssessment\MinToApp as MinToAppModel;
use Livewire\Component;
use App\Utils\ActivityLogHelper as Log;
use App\Utils\ToastHelper;

class MinGeneralScore extends Component
{
    private $translationPath = 'project/planning.quality-assessment.min-general-score.livewire';
    private $toastMessages = 'project/planning.quality-assessment.min-general-score.livewire.toasts';
    public $currentProject;
    public $generalScores = [];
    public $minGeneralScore = [];
    public $selectedGeneralScore;

    /**
     * Fields to be filled by the form.
     */
    public $id_project;
    public $id_general_score;

    /**
     * Form state.
     */
    public $form = [
        'isEditing' => true,
    ];

    /**
     * Validation rules.
     */
    protected $rules = [
        'id_project' => 'required',
        'selectedGeneralScore' => 'required',
    ];

    /**
     * Custom error messages for the validation rules.
     */
    protected function messages()
    {
        return [
            'selectedGeneralScore.required' => __($this->translationPath . '.min-general-score.required'),
        ];
    }

    /**
     * Executed when the component is mounted. It sets the
     * project id and retrieves the items.
     */
    public function mount()
    {
        $projectId = request()->segment(2);
        $this->currentProject = ProjectModel::findOrFail($projectId);
        $this->generalScores = GeneralScoreModel::where('id_project', $projectId)->get();
        $this->minGeneralScore = MinToAppModel::where('id_project', $this->currentProject->id_project)->get();
    }


    /**
     * Update the items.
     */
    public function updateMinGeneralScore()
    {
        $this->minGeneralScore = MinToAppModel::where(
            ['id_project', $this->currentProject->id_project],
        )->get();
    }

    /**
     * Dispatch a toast message to the view.
     */
    public function toast(string $message, string $type)
    {
        $this->dispatch('min-general-score', ToastHelper::dispatch($type, $message));
    }

    /**
     * Submit the form. It validates the input fields
     * and creates or updates an item.
     */
    public function submit()
    {
        $this->validate();

        try {
            $value = $this->form['isEditing'] ? 'Updated the Min General Score' : 'Added a Min General Score';
            $toastMessage = __($this->toastMessages . ($this->form['isEditing'] ? '.updated' : '.added'));

            $updatedOrCreated = MinToAppModel::updateOrCreate([
                'id_project' => $this->currentProject->id_project,
                'id_general_score' => $this->selectedGeneralScore,
            ]);

            Log::logActivity(
                action: $value,
                description: $updatedOrCreated->description,
                projectId: $this->currentProject->id_project
            );

            $this->updateMinGeneralScore();
            $this->toast(
                message: $toastMessage,
                type: 'success'
            );
        } catch (\Exception $e) {
            $this->toast(
                message: $e->getMessage(),
                type: 'error'
            );
         }
    }

    public function render()
    {
        $project = $this->currentProject;

        return view(
            'livewire.planning.quality-assessment.min-general-score',
            compact(
                'project',
            )
        )->extends('layouts.app');
    }
}
