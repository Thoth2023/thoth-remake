<?php

namespace App\Livewire\Planning\QualityAssessment;

use Livewire\Component;
use App\Models\Project as ProjectModel;
use App\Models\Project\Planning\QualityAssessment\Question as QuestionsModel;
use App\Utils\ActivityLogHelper as Log;
use App\Utils\ToastHelper;


class Question extends Component
{
    private $translationPath = 'project/planning.quality-assessment.question-quality.livewire';
    private $toastMessages = 'project/planning.quality-assessment.question-quality.livewire.toasts';
    public $currentProject;
    public $currentQuestion;
    public $questions = [];

    /**
     * Fields to be filled by the form.
     */
    public $questionId;
    public $description;
    public $weight;

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
        'questionId' => 'required|string|max:10|regex:/^[a-zA-Z0-9]+$/',
        'description' => 'required|string|max:255',
        'weight' => 'required|numeric',
    ];

    /**
     * Custom error messages for the validation rules.
     */
    protected function messages()
    {
        return [
            'questionId.required' => __($this->translationPath . '.questionId.required'),
            'description.required' => __($this->translationPath . '.description.required'),
            'weight.required' => __($this->translationPath . '.weight.required'),
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
        $this->currentQuestion = null;
        $this->questions = QuestionsModel::where(
            'id_project',
            $this->currentProject->id_project
        )->get();
    }

    /**
     * Reset the fields to the default values.
     */
    public function resetFields()
    {
        $this->questionId = '';
        $this->description = '';
        $this->weight = '';
        $this->currentQuestion = null;
        $this->form['isEditing'] = false;
    }

    /**
     * Update the items.
     */
    public function updateQuestions()
    {
        $this->questions = QuestionsModel::where(
            'id_project',
            $this->currentProject->id_project
        )->get();
    }
    /**
     * Dispatch a toast message to the view.
     */
    public function toast(string $message, string $type)
    {
        $this->dispatch('question', ToastHelper::dispatch($type, $message));
    }

    /**
     * Submit the form. It validates the input fields
     * and creates or updates an item.
     */
    public function submit()
    {
        $this->validate();

        $updateIf = [
            'id_qa' => $this->currentQuestion?->id_qa,
        ];

        try {
            $value = $this->form['isEditing'] ? 'Updated the question quality' : 'Added a question quality';
            $toastMessage = __($this->toastMessages . ($this->form['isEditing']
                    ? '.updated' : '.added'));

            $updatedOrCreated = QuestionsModel::updateOrCreate($updateIf, [
                'id' => $this->questionId,
                'description' => $this->description,
                'weight' => $this->weight,
                'id_project' => $this->currentProject->id_project,
            ]);

            Log::logActivity(
                action: $value,
                description: $updatedOrCreated->description,
                projectId: $this->currentProject->id_project
            );

            $this->updateQuestions();
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
     * Render the component.
     */
    public function render()
    {
        $project = $this->currentProject;

        return view(
            'livewire.planning.quality-assessment.question',
            compact(
                'project',
            )
        )->extends('layouts.app');
    }
}
