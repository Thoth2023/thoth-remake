<?php

namespace App\Livewire\Planning\QualityAssessment;

use Livewire\Attributes\On;
use Livewire\Component;

use App\Utils\ToastHelper;
use App\Utils\ActivityLogHelper as Log;
use App\Models\Project;
use App\Models\Project\Planning\QualityAssessment\Question;
use App\Traits\ProjectPermissions;

/**
 * Componente Livewire para gerenciar questões de qualidade.
 *
 * Este componente permite criar, editar e excluir questões de qualidade
 * associadas ao projeto, incluindo seus pesos e descrições.
 */
class QuestionQuality extends Component
{

    use ProjectPermissions;

    /** @var string Caminho base para traduções do componente */
    private $translationPath = 'project/planning.quality-assessment.question-quality.livewire';

    /** @var string Caminho para as mensagens de toast */
    private $toastMessages = 'project/planning.quality-assessment.question-quality.livewire.toasts';

    /** @var Project Projeto atual sendo avaliado */
    public $currentProject;

    /** @var Question|null Questão atual sendo editada */
    public $currentQuestion;

    /** @var array Lista de questões do projeto */
    public $questions = [];

    /**
     * Campos a serem preenchidos pelo formulário.
     */
    /** @var string ID da questão */
    public $questionId;

    /** @var string Descrição da questão */
    public $description;

    /** @var float Peso da questão */
    public $weight;

    /**
     * Estado do formulário.
     */
    /** @var array Estado do formulário */
    public $form = [
        'isEditing' => false,
    ];

    /**
     * Regras de validação.
     */
    protected $rules = [
        'currentProject' => 'required',
        'questionId' => 'required|string|max:10|regex:/^[a-zA-Z0-9]+$/',
        'description' => 'required|string|regex:/^[\pL\pN\s\.,;:\?"\'\(\)\[\]\{\}\/\\\\_\-+=#@!%&*]+$/u|max:255',
        'weight' => 'required|regex:/^\d+(\.\d{1,2})?$/',
    ];

    /**
     * Mensagens de erro personalizadas para as regras de validação.
     *
     * @return array Mensagens de erro
     */
    protected function messages()
    {
        return [
            'questionId.required' => __('common.required'),
            'weight.required' => __('common.required'),
            'description.required' => __('common.required'),
        ];
    }

    /**
     * Inicializa o componente, carregando o projeto e suas questões.
     */
    public function mount()
    {
        $projectId = request()->segment(2);
        $this->currentProject = Project::findOrFail($projectId);
        $this->currentQuestion = null;
        $this->questions = Question::where('id_project', $projectId)->get();
        $this->cutoffMaxValue = false;
    }

    /**
     * Reseta os campos do formulário para seus valores padrão.
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
     * Dispara uma notificação toast para o usuário.
     *
     * @param string $message Mensagem a ser exibida
     * @param string $type Tipo de toast (success, error, etc)
     */
    public function toast(string $message, string $type)
    {
        $this->dispatch('question-quality', ToastHelper::dispatch($type, $message));
    }

    /**
     * Atualiza a lista de questões e dispara eventos relacionados.
     */
    public function updateQuestions()
    {

        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        $projectId = $this->currentProject->id_project;
        $this->questions = Question::where('id_project', $projectId)->get();
        $this->dispatch('update-qa-table');
        $this->dispatch('update-weight-sum');
        $this->dispatch('update-score-questions');
    }
    /**
     * Preenche os campos do formulário com dados da questão selecionada para edição.
     *
     * @param int $questionId ID da questão a ser editada
     */
    #[On('edit-question-quality')]
    public function edit($questionId)
    {

        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        $this->currentQuestion = Question::findOrFail($questionId);
        $this->form['isEditing'] = true;
        $this->questionId = $this->currentQuestion->id;
        $this->weight = $this->currentQuestion->weight;
        $this->description = $this->currentQuestion->description;
    }
    /**
     * Exclui a questão de qualidade selecionada.
     *
     * @param int $questionId ID da questão a ser excluída
     */
    #[On('delete-question-quality')]
    public function delete($questionId)
    {

        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        try {
            $currentQuestion = Question::findOrFail($questionId);
            $currentQuestion->delete();

            Log::logActivity(
                action: 'Deleted the quality score',
                description: $currentQuestion->description,
                projectId: $this->currentProject->id_project
            );

            $this->updateQuestions();
            $this->toast(
                message: 'Quality score deleted successfully.',
                type: 'success'
            );
            $this->dispatch('update-cutoff');
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
     * Valida e submete os dados do formulário.
     * Cria ou atualiza uma questão de qualidade baseado no estado do formulário.
     */
    public function submit()
    {

        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        $this->validate();

        $existingQuestion = Question::where('id', $this->questionId)
            ->where('id_project', $this->currentProject->id_project)
            ->when($this->form['isEditing'], function ($query) {
                $query->where('id_qa', '!=', $this->currentQuestion?->id_qa);
            })
            ->first();

        if ($existingQuestion) {
            $this->toast(
                message: __('project/planning.quality-assessment.question-quality.livewire.toasts.duplicate_id'),
                type: 'error'
            );
            return;
        }

        if ($this->weight <= 0) {
            $this->toast(
                message: __('project/planning.quality-assessment.question-quality.livewire.toasts.min_weight'),
                type: 'error'
            );
            return;
        }

        $updateIf = [
            'id_qa' => $this->currentQuestion?->id_qa,
        ];

        try {
            $value = $this->form['isEditing']
                ? 'Updated the question quality' : 'Added a question quality';
            $toastMessage = __($this->toastMessages . ($this->form['isEditing']
                ? '.updated' : '.added'));

            $updatedOrCreated = Question::updateOrCreate($updateIf, [
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
     * Renderiza o componente.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.planning.quality-assessment.question-quality');
    }
}
