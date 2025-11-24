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


    public $description;



    public $form = [
        'isEditing' => false,
    ];

	// Regra de validação para os campos do formulário.
    protected $rules = [
        'questionId' => ['required', 'max:255', 'regex:/^(?!\s*$)[a-zA-Z0-9\s]+$/'],
        'description' => 'required|string|regex:/^[\pL\pN\s\.,;:\?"\'\(\)\[\]\{\}\/\\\\_\-+=#@!%&*]+$/u|max:255',
        'type' => 'required|array',
    ];

	// Regras de validação para os campos do formulário.
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

	// Mensagens de erro personalizadas para as regras de validação.
    protected $messages = [
        'questionId.regex' => 'O ID deve conter apenas letras e números.',
    ];

	// Inicialização do componente Livewire
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

	// Função para resetar os campos do formulário para o estado inicial
    private function resetFields()
    {
        $this->questionId = null;
        $this->description = '';
        $this->type['value'] = '';
        $this->form['isEditing'] = false;
        $this->currentQuestion = null;
    }

	// Função para atualizar a lista de perguntas
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

	// Exibe a mensagem de toast com o tipo e a mensagem fornecidos
    public function toast(string $message, string $type)
    {
        $this->dispatch('questions', ToastHelper::dispatch($type, $message));
    }

	// Função para verificar validade dados e aplicar a edição das perguntas
    public function submit()
    {

        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        $this->validate();

		// Verifica se o ID da questão já existe no projeto, exceto quando está editando uma questão existente.
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
		// Tenta criar ou atualizar a questão, registrando a atividade e mostrando mensagens de sucesso ou erro conforme necessário.
        try {
            $value = $this->form['isEditing'] ? 'Updated the question' : 'Added a question';
            $toastMessage = $this->form['isEditing']
                ? 'Questão atualizada com sucesso!' : 'Questão adicionada com sucesso!';

            if ($this->form['isEditing']) {

                $this->currentQuestion->update([
                    'id_project' => $this->currentProject->id_project,
                    'type' => $this->type['value'],
                    'id' => $this->questionId,
                    'description' => $this->description,
                ]);
            } else {

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

	// Função para extrair os dados de uma pergunta específica para edição
    #[On('data-extraction-table-edit-question')]
    public function edit(string $questionId)
    {

        $this->resetFields();

        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

		// Busca a questão pelo ID e tenta carregá-la, mostrando mensagens de erro se não for encontrada.
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

		// Verifica se já existe uma questão com o mesmo ID no projeto, exceto a questão atual
        $existingQuestion = QuestionModel::where('id', $this->questionId)
            ->where('id_project', $this->currentProject->id_project)
            ->where('id', '!=', $this->currentQuestion->id)
            ->first();

        if ($existingQuestion) {
            $this->toast(
                message: 'Já existe uma questão com este ID neste projeto.',
                type: 'error'
            );
            return;
        }

        // Preenche os campos do formulário com os dados da questão selecionada
        $this->questionId = $this->currentQuestion->id;
        $this->description = $this->currentQuestion->description;
        $this->type['value'] = $this->currentQuestion->type;
        $this->form['isEditing'] = true;
    }

    // Função para deletar uma pergunta
    #[On('data-extraction-table-delete-question')]
    public function delete(string $questionId)
    {

        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }
		// Busca a questão pelo ID e tenta deletá-la, mostrando mensagens de sucesso ou erro conforme necessário.
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

    // Renderiza a view do componente
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
