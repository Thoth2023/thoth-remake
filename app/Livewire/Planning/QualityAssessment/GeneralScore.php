<?php

namespace App\Livewire\Planning\QualityAssessment;

use App\Models\Project as ProjectModel;
use App\Models\Project\Planning\QualityAssessment\GeneralScore as GeneralScoreModel;
use App\Utils\ActivityLogHelper as Log;
use App\Utils\ToastHelper;
use Livewire\Component;

class GeneralScore extends Component
{
    private $translationPath = 'project/planning.quality-assessment.general-score.livewire';
    private $toastMessages = 'project/planning.quality-assessment.general-score.livewire.toasts';
    public $currentProject;
    public $currentGeneralScore;
    public $generalscore = [];

    /**
     * Fields to be filled by the form.
     */
    public $start;
    public $end;
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
        'currentProject' => 'required',
        'start'=>'required|numeric',
        'end'=>'required|numeric',
        'description' => 'required|string|max:255',
    ];

    /**
     * Custom error messages for the validation rules.
     */
    protected function messages()
    {
        return [
            'start.required' => __($this->translationPath . '.start.required'),
            'end.required' => __($this->translationPath . '.end.required'),
            'description.required' => __($this->translationPath . '.description.required'),
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
        $this->currentGeneralScore = null;
        $this->generalscore = GeneralScoreModel::where(
            'id_project',
            $this->currentProject->id_project
        )->get();
    }

    /**
     * Reset the fields to the default values.
     */
    public function resetFields()
    {
        $this->start = '';
        $this->end = '';
        $this->description = '';
        $this->currentGeneralScore = null;
        $this->form['isEditing'] = false;
    }

    /**
     * Update the items.
     */
    public function updateGeneralScore()
    {
        $this->generalscore = GeneralScoreModel::where(
            'id_project',
            $this->currentProject->id_project
        )->get();
    }

    /**
     * Dispatch a toast message to the view.
     */
    public function toast(string $message, string $type)
    {
        $this->dispatch('general-score', ToastHelper::dispatch($type, $message));
    }

    /**
     * Submit the form. It validates the input fields
     * and creates or updates an item.
     */
    public function submit()
    {
        $this->validate();

        $updateIf = [
            'id_general_score' => $this->currentGeneralScore?->id_general_score,
        ];

        try {
            $value = $this->form['isEditing'] ? 'Updated the General Score' : 'Added a General Score';
            $toastMessage = __($this->toastMessages . ($this->form['isEditing']
                    ? '.updated' : '.added'));

            $updatedOrCreated = GeneralScoreModel::updateOrCreate($updateIf, [
                'id_project' => $this->currentProject->id_project,
                'start' => $this->start,
                'end' => $this->end,
                'description' => $this->description,
            ]);

            Log::logActivity(
                action: $value,
                description: $updatedOrCreated->description,
                projectId: $this->currentProject->id_project
            );

            $this->updateGeneralScore();
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

    /**
     * Fill the form fields with the given data.
     */
    public function edit(string $generalscoreId)
    {
        $this->currentGeneralScore = GeneralScoreModel::findOrFail($generalscoreId);
        $this->start = $this->currentGeneralScore->start;
        $this->end = $this->currentGeneralScore->end;
        $this->description = $this->currentGeneralScore->description;
        $this->form['isEditing'] = true;
    }

    /**
     * Delete an item.
     */
    public function delete(string $generalscoreId)
    {
        try {
            $currentGeneralScore = GeneralScoreModel::findOrFail($generalscoreId);
            $currentGeneralScore->delete();

            Log::logActivity(
                action: 'Deleted the General Score',
                description: $currentGeneralScore->description,
                projectId: $this->currentProject->id_project
            );

            $this->toast(
                message: __($this->toastMessages . '.deleted'),
                type: 'success'
            );
            $this->updateGeneralScore();
        } catch (\Exception $e) {
            $this->toast(
                message: $e->getMessage(),
                type: 'error'
            );
        } finally {
            $this->resetFields();
        }
    }

    /**
     * Render the component.
     */
    public function render()
    {
        $project = $this->currentProject;

        return view(
            'livewire.planning.quality-assessment.general-score',
            compact(
                'project',
            )
        )->extends('layouts.app');
    }
}
