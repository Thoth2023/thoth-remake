<?php

namespace App\Livewire\Planning\DataExtraction;

use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\Project as ProjectModel;
use App\Models\Project\Planning\DataExtraction\Question as QuestionModel;
use App\Models\Project\Planning\DataExtraction\QuestionTypes as QuestionTypesModel;
use App\Utils\ActivityLogHelper as Log;
use App\Utils\ToastHelper;

class Question extends Component
{
    public $currentProject;
    public $currentQuestion;
    public $questions = [];
    public $questionId;
    public $type;
    public $questionTypes = [];

    /**
     * Fields to be filled by the form.
     */
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
        'description' => 'required|string',
        'type' => 'required|array',
    ];

    /**
     * Custom error messages for the validation rules.
     */
    protected function messages()
    {
        return [
            'description.required' => 'Este campo é obrigatório',
            'type.required' => 'Este campo é obrigatório',
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
        $this->questions = QuestionModel::where(
            'id_project',
            $this->currentProject->id_project
        )->get();
        $this->questionTypes = QuestionTypesModel::all();
    }

    /**
     * Reset the fields to the default values.
     */
    private function resetFields()
    {
        $this->questionId = null;
        $this->description = '';
        $this->type['value'] = '';
        $this->form['isEditing'] = false;
    }

    /**
     * Update the items.
     */
    public function updateQuestions()
    {
        $this->questions = QuestionModel::where(
            'id_project',
            $this->currentProject->id_project
        )->get();
        $this->dispatch('update-question-select');
    }

    /**
     * Dispatch a toast message to the view.
     */
    public function toast(string $message, string $type)
    {
        $this->dispatch('questions', ToastHelper::dispatch($type, $message));
    }

    /**
     * Submit the form. It validates the input fields
     * and creates or updates an item.
     */
    public function submit()
    {
        $this->validate();

        $updateIf = [
            'id' => $this->currentQuestion?->id,
        ];

        try {
            $value = $this->form['isEditing'] ? 'Updated the question' : 'Added a question';
            $toastMessage = $this->form['isEditing']
                ? 'Questão atualizada com sucesso!' : 'Questão adicionada com sucesso!';

            $updatedOrCreated = QuestionModel::updateOrCreate($updateIf, [
                'id_project' => $this->currentProject->id_project,
                'type' => $this->type['value'],
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
    #[On('data-extraction-table-edit-question')]
    public function edit(string $questionId)
    {
        $this->currentQuestion = QuestionModel::where('id_project', $this->currentProject->id_project)->where('id', $questionId)->first();
        $this->questionId = $this->currentQuestion->id;
        $this->description = $this->currentQuestion->description;
        $this->type['value'] = $this->currentQuestion->type;
        $this->form['isEditing'] = true;
    }

    /**
     * Delete an item.
     */
    #[On('data-extraction-table-delete-question')]
    public function delete(string $questionId)
    {
        try {
            $currentQuestion = QuestionModel::where('id_project', $this->currentProject->id_project)->where('id', $questionId)->first();
            $currentQuestion->delete();

            Log::logActivity(
                action: 'Deleted the question',
                description: $currentQuestion->description,
                projectId: $this->currentProject->id_project
            );

            $this->toast(
                message: 'Questão deletada com sucesso',
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
        $project = $this->currentProject;

        return view(
            'livewire.planning.data-extraction.question',
            compact(
                'project',
            )
        )->extends('layouts.app');
    }
}


//     public function render()
//     {
//         return view('livewire.planning.data-extraction.data-extraction');
//     }
// }
