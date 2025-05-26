<?php

namespace App\Livewire\Planning\DataExtraction;

use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\Project as ProjectModel;
use App\Models\Project\Planning\DataExtraction\Question as QuestionModel;
use App\Models\Project\Planning\DataExtraction\QuestionTypes as QuestionTypesModel;
use App\Utils\ActivityLogHelper as Log;
use App\Utils\ToastHelper;
use App\Traits\ProjectPermissions;

class Question extends Component
{

    use ProjectPermissions;

    public $currentProject;
    public $currentQuestion;
    public $questions = [];
    public $questionId;
    public $type;
    public $questionTypes = [];
    private $toastMessages = 'project/planning.data-extraction.toasts';

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
        'questionId' => ['required', 'max:255', 'regex:/^(?!\s*$)[a-zA-Z0-9\s]+$/'],
        'description' => 'required|string',
        'type' => 'required|array',
    ];

    /**
     * Custom error messages for the validation rules.
     */
    protected function messages()
    {
        return [
            'questionId.required' => 'Este campo é obrigatório',
            'questionId.regex' => 'O ID da questão não pode conter caracteres especiais',
            'description.required' => 'Este campo é obrigatório',
            'description.regex' => 'A descrição só pode conter letras, números e espaços.',
            'type.required' => 'Este campo é obrigatório',
        ];
    }

    protected $messages = [
        'questionId.regex' => 'O ID deve conter apenas letras e números.',
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

        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

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

        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        $this->validate();

        // Verifica se o 'id' da questão já existe no projeto atual (em modo de criação)
        if (!$this->form['isEditing']) {
            $existingQuestion = QuestionModel::where('id', $this->questionId)
                ->where('id_project', $this->currentProject->id_project)
                ->first();

            if ($existingQuestion) {
                $this->toast(
                    message: 'Já existe uma questão com este ID neste projeto.',
                    type: 'error'
                );
                return;
            }
        }

        try {
            $value = $this->form['isEditing'] ? 'Updated the question' : 'Added a question';
            $toastMessage = $this->form['isEditing']
                ? 'Questão atualizada com sucesso!' : 'Questão adicionada com sucesso!';

            if ($this->form['isEditing']) {
                // Atualiza a questão existente
                $this->currentQuestion->update([
                    'id_project' => $this->currentProject->id_project,
                    'type' => $this->type['value'],
                    'id' => $this->questionId,
                    'description' => $this->description,
                ]);
            } else {
                // Cria uma nova questão
                QuestionModel::create([
                    'id_project' => $this->currentProject->id_project,
                    'type' => $this->type['value'],
                    'id' => $this->questionId,
                    'description' => $this->description,
                ]);
            }

            Log::logActivity(
                action: $value,
                description: $this->description,
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
        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        $this->currentQuestion = QuestionModel::where('id_project', $this->currentProject->id_project)
            ->where('id_de', $questionId)
            ->first();

        if (!$this->currentQuestion) {
            $this->toast(
                message: 'Questão não encontrada.',
                type: 'error'
            );
            return;
        }

        // Verifica se o 'questionId' já existe em outra questão do mesmo projeto
        $existingQuestion = QuestionModel::where('id', $this->questionId)
            ->where('id_project', $this->currentProject->id_project)
            ->where('id', '!=', $this->currentQuestion->id) // Garante que não é a mesma questão
            ->first();

        if ($existingQuestion) {
            $this->toast(
                message: 'Já existe uma questão com este ID neste projeto.',
                type: 'error'
            );
            return;
        }

        // Preenche os campos do formulário com os dados da questão atual
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

        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        try {
            $currentQuestion = QuestionModel::where('id_project', $this->currentProject->id_project)->where('id_de', $questionId)->first();
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
