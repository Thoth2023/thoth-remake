<?php

namespace App\Livewire\Planning\Questions;

use Livewire\Component;
use App\Models\Project as ProjectModel;
use App\Models\ResearchQuestion as ResearchQuestionModel;
use App\Utils\ActivityLogHelper as Log;
use App\Utils\ToastHelper;
use App\Traits\ProjectPermissions;


/**
 * Componente Livewire responsável por gerenciar as perguntas de pesquisa
 * associadas a um projeto na etapa de planejamento.
 *
 * Livewire component responsible for managing research questions
 * associated with a project during the planning stage.
 */
class ResearchQuestions extends Component
{

    /**
     * Projeto atualmente selecionado.
     * Currently selected project.
     *
     * @var ProjectModel
     */

    use ProjectPermissions;

    public $currentProject;

    /**
     * Pergunta de pesquisa que está sendo editada (se houver).
     * Research question currently being edited (if any).
     *
     * @var ResearchQuestionModel|null
     */
    public $currentQuestion;

        /**
     * Lista de perguntas de pesquisa do projeto.
     * List of all research questions for the project.
     */
    public $questions = [];
    private $toastMessages = 'project/planning.research-questions.livewire.toasts';

    /**
     * Campos do formulário: descrição e ID da pergunta.
     * Form fields: question description and ID.
     *
     * @var string
     */
    public $description;
    public $questionId;

    /**
     * Estado do formulário (ex: se está em modo de edição).
     * Form state (e.g., if editing mode is active).
     *
     * @var array
     */
    public $form = [
        'isEditing' => false,
    ];

    /**
     * Regras de validação para os campos do formulário.
     * Validation rules for form fields.
     *
     * @var array
     */
    protected $rules = [
        'currentProject' => 'required',
        'questionId' => 'required|string|max:20|regex:/^[a-zA-Z0-9]+$/',
        'description' => 'required|string|regex:/^[\pL\pN\s\?\/:#\\\\-]+$/u|max:255',
    ];

    /**
     * Mensagens de erro personalizadas para a validação.
     * Custom error messages for validation.
     *
     * @var array
     */
    protected $messages = [
        'description.required' => 'O campo descrição é obrigatório.',
        'description.regex' => 'A descrição não deve conter caracteres especiais.',
        'description.max' => 'A descrição não pode ter mais de 255 caracteres.',
        'questionId.required' => 'O campo ID é obrigatório.',
        'questionId.regex' => 'O campo ID deve conter apenas letras e números.',
        'questionId.max' => 'O campo ID não pode ter mais de 20 caracteres.',
    ];

    /**
     * Executado ao montar o componente.
     * Carrega o projeto e suas perguntas de pesquisa.
     *
     * Called when the component is mounted.
     * Loads the project and its research questions.
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
     * Reseta os campos do formulário e o estado de edição.
     * Resets form fields and editing state.
     */
    public function resetFields()
    {
        $this->questionId = '';
        $this->description = '';
        $this->currentQuestion = null;
        $this->form['isEditing'] = false;
    }

    /**
     * Atualiza a lista de perguntas de pesquisa do projeto.
     * Updates the list of research questions for the project.
     */
    public function updateQuestions()
    {
        $this->questions = ResearchQuestionModel::where(
            'id_project',
            $this->currentProject->id_project
        )->get();
    }

    /**
     * Dispara uma notificação (toast) para a interface.
     * Sends a toast notification to the frontend.
     *
     * @param string $message Mensagem da notificação / Toast message
     * @param string $type Tipo da notificação (success, error, etc.) / Notification type
     */
    public function toast(string $message, string $type)
    {
        $this->dispatch('research-questions', ToastHelper::dispatch($type, $message));
    }

    /**
     * Retorna uma mensagem traduzida do arquivo de tradução.
     * Returns a translated message from the language file.
     *
     * @param string $message
     * @return string
     */
    private function message(string $message)
    {
        return __('project/planning.research-questions.livewire.toasts' . $message);
    }

    /**
     * Submete o formulário para criar ou atualizar uma pergunta.
     * Validates and submits the form to create or update a question.
     */
    public function submit()
    {

        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        $this->validate();

        // Define a condição de atualização se estiver editando
        // Sets the update condition if in editing mode
        $updateIf = [
            'id_research_question' => $this->currentQuestion?->id_research_question,
        ];

        try {
            $value = $this->form['isEditing'] ? 'Updated the research question' : 'Added a research question';
            $toastMessage = $this->message($this->form['isEditing'] ? '.updated' : '.added');


            // Verifica duplicidade de ID ao criar nova pergunta
            // Checks for duplicate ID when creating new question
            if (!$this->form['isEditing'] && $this->currentProject->researchQuestions->contains('id', $this->questionId)) {
                $this->toast(
                    message: 'This ID is already in use. Please choose a unique ID for the question.',
                    type: 'error'
                );
                return;
            }


            // Verifica duplicidade ao editar e trocar o ID
            // Checks for duplicate ID when editing and changing the ID
            if(!$this->form['isEditing'] && $this->currentProject->researchQuestions->contains('description', $this->description)) {
                $this->toast(
                    message: 'There cannot be duplicate research questions. Please consider changing the description of this research question.',
                    type: 'error'
                );
                return;
            }

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


            // Cria ou atualiza a pergunta de pesquisa
            // Creates or updates the research question
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

            // Registra a ação no log de atividades
            // Logs the activity
            Log::logActivity(
                action: $value,
                description: $updatedOrCreated->description,
                projectId: $this->currentProject->id_project
            );

            // Atualiza a lista e mostra toast de sucesso
            // Updates list and shows success toast
            $this->updateQuestions();
            $this->toast(
                message: $toastMessage,
                type: 'success'
            );
        } catch (\Exception $e) {
            // Em caso de erro, mostra toast de erro
            // Shows error toast in case of exception
            $this->toast(
                message: $e->getMessage(),
                type: 'error'
            );
        } finally {
            // Reseta os campos do formulário
            // Resets form fields
            $this->resetFields();
        }
    }

    /**
     * Preenche os campos do formulário para edição de uma pergunta.
     * Fills form fields for editing a specific question.
     *
     * @param string $questionId
     */
    public function edit(string $questionId)
    {

        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        $this->currentQuestion = ResearchQuestionModel::findOrFail($questionId);
        $this->questionId = $this->currentQuestion->id;
        $this->description = $this->currentQuestion->description;
        $this->form['isEditing'] = true;
    }

    /**
     * Exclui uma pergunta do projeto e registra a ação.
     * Deletes a research question and logs the action.
     *
     * @param string $questionId
     */
    public function delete(string $questionId)
    {

        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        try {
            $currentQuestion = ResearchQuestionModel::findOrFail($questionId);
            $currentQuestion->delete();

            // Registra a exclusão
            // Logs deletion
            Log::logActivity(
                action: 'Deleted the question',
                description: $currentQuestion->description,
                projectId: $this->currentProject->id_project
            );

            // Mostra toast e atualiza a lista
            // Shows toast and refreshes list
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
        }
    }

    /**
     * Renderiza a view do componente.
     * Renders the component view.
     */
    public function render()
    {
        return view('livewire.planning.questions.research-questions')->extends('layouts.app');
    }
}
