<?php

namespace App\Livewire\Planning\Questions;

use Livewire\Component;
use App\Models\Project as ProjectModel;
use App\Models\ResearchQuestion as ResearchQuestionModel;
use App\Utils\ActivityLogHelper as Log;
use App\Utils\ToastHelper;


class ResearchQuestions extends Component
{
    public $currentProject;
    public $currentQuestion;
    public $questions = [];

    /**
     * Fields to be filled by the form.
     */
    public $description;
    public $questionId;

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
        'questionId' => 'required|string|max:20|regex:/^[a-zA-Z0-9]+$/',
        'description' => 'required|string|max:255',
    ];

    /**
     * Custom error messages for the validation rules.
     */
    protected $messages = [
        'description.required' => 'The description field is required.',
        'questionId.required' => 'The ID field is required.',
        'questionId.regex' => 'The ID field must contain only letters and numbers.',
    ];

    /**
     * Executed when the component is mounted. It sets the
     * project id and retrieves the items.
     */
    public function mount()
    {
        $projectId = request()->segment(2);
        $this->currentProject = ProjectModel::findOrFail($projectId);
        $this->currentQuestion = null;
        $this->questions = ResearchQuestionModel::where(
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
        $this->currentQuestion = null;
        $this->form['isEditing'] = false;
    }

    /**
     * Update the items.
     */
    public function updateQuestions()
    {
        $this->questions = ResearchQuestionModel::where(
            'id_project',
            $this->currentProject->id_project
        )->get();
    }

    /**
     * Dispatch a toast message to the view.
     */
    public function toast(string $message, string $type)
    {
        $this->dispatch('research-questions', ToastHelper::dispatch($type, $message));
    }

    private function message(string $message)
    {
        return __('project/planning.research-questions.livewire.toasts' . $message);
    }

    /**
     * Submit the form. It validates the input fields
     * and creates or updates an item.
     */
    public function submit()
    {
        $this->validate();

        $updateIf = [
            'id_research_question' => $this->currentQuestion?->id_research_question,
        ];

        try {
            $value = $this->form['isEditing'] ? 'Updated the research question' : 'Added a research question';
            $toastMessage = $this->message($this->form['isEditing'] ? '.updated' : '.added');

            // CREATE verifications
            if (!$this->form['isEditing'] && $this->currentProject->researchQuestions->contains('id', $this->questionId)) {
                $this->toast(
                    message: 'This ID is already in use. Please choose a unique ID for the question.',
                    type: 'error'
                );
                return;
            }

            if(!$this->form['isEditing'] && $this->currentProject->researchQuestions->contains('description', $this->description)) {
                $this->toast(
                    message: 'There cannot be duplicate research questions. Please consider changing the description of this research question.',
                    type: 'error'
                );
                return;
            }


            // UPDATE verifications
            if (
                $this->form['isEditing']
                && $this->currentQuestion->id != $this->questionId
                && $this->currentProject->researchQuestions->contains('id', $this->questionId)
            ) {
                $this->toast(
                    message: 'This ID is already in use. Please choose a unique ID for the question.',
                    type: 'error'
                );
                return;
            }

            if (
                $this->form['isEditing']
                && $this->currentQuestion->description != $this->description
                && $this->currentProject->researchQuestions->contains('description', $this->description)
            ) {
                $this->toast(
                    message: 'There cannot be duplicate research questions. Please consider changing the description of this research question.',
                    type: 'error'
                );
                return;
            }

            $updatedOrCreated = ResearchQuestionModel::updateOrCreate($updateIf, [
                'id_project' => $this->currentProject->id_project,
                'id' => $this->questionId,
                'description' => $this->description,
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
     * Fill the form fields with the given data.
     */
    public function edit(string $questionId)
    {
        $this->currentQuestion = ResearchQuestionModel::findOrFail($questionId);
        $this->questionId = $this->currentQuestion->id;
        $this->description = $this->currentQuestion->description;
        $this->form['isEditing'] = true;
    }

    /**
     * Delete an item.
     */
    public function delete(string $questionId)
    {
        try {
            $currentQuestion = ResearchQuestionModel::findOrFail($questionId);
            $currentQuestion->delete();
            Log::logActivity(
                action: 'Deleted the question',
                description: $currentQuestion->description,
                projectId: $this->currentProject->id_project
            );

            $this->toast(
                message: $this->message('.deleted'),
                type: 'success'
            );
            $this->updateQuestions();
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
        return view('livewire.planning.questions.research-questions')->extends('layouts.app');
    }
}
