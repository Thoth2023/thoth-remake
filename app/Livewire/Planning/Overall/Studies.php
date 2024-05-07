<?php

namespace App\Livewire\Planning\Overall;

use App\Utils\ToastHelper;
use Livewire\Component;
use App\Models\StudyType as StudyTypeModel;
use App\Models\Project as ProjectModel;
use App\Models\ProjectStudyType as ProjectStudyTypeModel;
use App\Utils\ActivityLogHelper as Log;

class Studies extends Component
{
    private $translationPath = 'project/planning.overall.study_type.livewire';
    private $toastMessages = 'project/planning.overall.study_type.livewire.toasts';

    public $currentProject;
    public $studies = [];

    /**
     * Fields to be filled by the form.
     */
    public $studyType;

    /**
     * Validation rules.
     */
    protected $rules = [
        'currentProject' => 'required',
        'studyType' => 'required|array',
        'studyType.*.value' => 'number',
    ];

    /**
     * Custom error messages for the validation rules.
     */
    protected function messages()
    {
        return [
            'studyType.required' => __($this->translationPath . '.study_type.required'),
        ];
    }

    /**
     * Dispatch a toast message to the view.
     */
    public function toast(string $message, string $type)
    {
        $this->dispatch('studies', ToastHelper::dispatch($type, $message));
    }


    /**
     * Executed when the component is mounted. It sets the
     * project id and retrieves the items.
     */
    public function mount()
    {
        $projectId = request()->segment(2);
        $this->currentProject = ProjectModel::findOrFail($projectId);
        $this->studies = StudyTypeModel::all();
    }

    /**
     * Submit the form. It also validates the input fields.
     */
    public function submit()
    {
        $this->validate();

        try {
            $projectStudyType = ProjectStudyTypeModel::firstOrNew([
                'id_project' => $this->currentProject->id_project,
                'id_study_type' => $this->studyType["value"],
            ]);

            if ($projectStudyType->exists) {
                $this->toast(
                    message: __($this->translationPath . '.study_type.already_exists'),
                    type: 'info'
                );
                return;
            }

            $studyType = StudyTypeModel::findOrFail($this->studyType["value"]);

            Log::logActivity(
                action: 'Added the study',
                description: $studyType->description,
                projectId: $this->currentProject->id_project,
            );

            $projectStudyType->save();
            $this->toast(
                message: __($this->toastMessages . '.added'),
                type: 'success'
            );
        } catch (\Exception $e) {
            $this->addError('studyType', $e->getMessage());
        }
    }

    /**
     * Delete an item.
     */
    public function delete(string $studyTypeId)
    {
        $studyType = ProjectStudyTypeModel::where('id_project', $this->currentProject->id_project)
            ->where('id_study_type', $studyTypeId)
            ->first();

        $deleted = StudyTypeModel::findOrFail($studyTypeId);
        $studyType?->delete();

        Log::logActivity(
            action: 'Deleted the study',
            description: $deleted->description,
            projectId: $this->currentProject->id_project,
        );

        $this->toast(
            message: __($this->toastMessages . '.deleted'),
            type: 'success'
        );
    }

    /**
     * Render the component.
     */
    public function render()
    {
        $project = $this->currentProject;

        return view(
            'livewire.planning.overall.studies',
            compact(
                'project',
            )
        )->extends('layouts.app');
    }
}
