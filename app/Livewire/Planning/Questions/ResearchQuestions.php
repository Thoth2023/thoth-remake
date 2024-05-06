<?php

namespace App\Livewire\Planning\Questions;

use Livewire\Component;
use App\Models\Project as ProjectModel;
use App\Models\ResearchQuestion as ResearchQuestionModel;

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
        'questionId' => 'required|string|max:20',
        'description' => 'required|string|max:255',
    ];

    /**
     * Custom error messages for the validation rules.
     */
    protected $messages = [
        'description.required' => 'The description field is required.',
        'questionId.required' => 'The ID field is required.'
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
            ResearchQuestionModel::updateOrCreate($updateIf, [
                'id_project' => $this->currentProject->id_project,
                'id' => $this->questionId,
                'description' => $this->description,
            ]);

            $this->updateQuestions();
        } catch (\Exception $e) {
            $this->addError('description', $e->getMessage());
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
        $currentQuestion = ResearchQuestionModel::findOrFail($questionId);
        $currentQuestion->delete();
        $this->updateQuestions();
        $this->resetFields();
    }

    /**
     * Render the component.
     */
    public function render()
    {
        return view('livewire.planning.questions.research-questions')->extends('layouts.app');
    }
}
