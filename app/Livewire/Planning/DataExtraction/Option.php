<?php

namespace App\Livewire\Planning\DataExtraction;

use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\Project as ProjectModel;
use App\Models\Project\Planning\DataExtraction\Option as OptionModel;
use App\Utils\ActivityLogHelper as Log;
use App\Utils\ToastHelper;
use Illuminate\Support\Facades\Auth;
use App\Traits\ProjectPermissions;

class Option extends Component
{

    use ProjectPermissions;
    public $toastMessages = 'project/planning.data-extraction.toasts';
    public $currentProject;
    public $currentOption;
    public $options = [];
    public $optionId;
    public $questionId = [];
    public $description;


    // Estado do formulário, indicando se está em modo de edição ou não.
    public $form = [
        'isEditing' => false,
    ];

    // Regras de validação para os campos do formulário.
    protected $rules = [
        'description' => 'required|string|regex:/^[\pL\pN\s\.,;:\?"\'\(\)\[\]\{\}\/\\\\_\-+=#@!%&*]+$/u|max:255',
        'questionId' => 'required|array',
        'questionId.*.value' => 'exists:question_extraction,id',
    ];

    // Mensagens de erro personalizadas para as regras de validação.
    protected function messages()
    {
        return [
            'description.required' => 'Este campo é obrigatório',
            'questionId.required' => 'Este campo é obrigatório',

        ];
    }

    // Inicialização do componente Livewire.
    public function mount()
    {
        $projectId = request()->segment(2);
        $this->currentProject = ProjectModel::findOrFail($projectId);
        $this->currentOption = null;
        $this->options = OptionModel::whereHas('question', function ($query) {
            $query->where('id_project', $this->currentProject->id_project);
        })->get();
    }

    // Exibe a mensagem de toast com o tipo e a mensagem fornecidos.
    public function toast(string $message, string $type)
    {
        $this->dispatch('options', ToastHelper::dispatch($type, $message));
    }

    // Reseta os campos do formulário para o estado inicial.
    private function resetFields()
    {
        $this->optionId = null;
        $this->description = null;
        $this->questionId = [];
        $this->form['isEditing'] = false;
    }

    // Atualiza a lista de opções de perguntas. ouve o evento 'update-question-select' para atualizar as opções de perguntas.
    #[On('update-question-select')]
    public function updateOptions()
    {

        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }
		// Recarrega as opções do projeto
        $this->options = OptionModel::whereHas('question', function ($query) {
            $query->where('id_project', $this->currentProject->id_project);
        })->get();
        $this->dispatch('update-table');
    }

    // FSubmete o formulário para criar ou atualizar uma opção de pergunta.
    public function submit()
    {

        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        $this->validate();

        $updateIf = [
            'id_option' => $this->currentOption?->id_option,
        ];
		// Criar ou atualizar a questão, tentar alterar o registro ou criar uma nova no banco de dados, registra a atividade.
        try {
            $value = $this->form['isEditing'] ? 'Updated the option' : 'Added a option';
            $toastMessage = $this->form['isEditing']
                ? 'Opção atualizada com sucesso!' : 'Opção adicionada com sucesso!';

            $updatedOrCreated = OptionModel::updateOrCreate($updateIf, [
                'id_de' => $this->questionId["value"],
                'description' => $this->description,
            ]);

            Log::logActivity(
                action: $value,
                description: $updatedOrCreated->description,
                projectId: $this->currentProject->id_project
            );

            $this->updateOptions();
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

    // Funçao para preencher os campos do formulário com os dados da opção selecionada
    #[On('data-extraction-table-edit-option')]
    public function edit(string $optionId)
    {

        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        $this->currentOption = OptionModel::findOrFail($optionId);
        $this->optionId = $this->currentOption->id;
        $this->description = $this->currentOption->description;
        $this->questionId['value'] = $this->currentOption->id_de;
        $this->form['isEditing'] = true;
    }

    // Função para deletar uma opção de pergunta
    #[On('data-extraction-table-delete-option')]
    public function delete(string $optionId)
    {

        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }
			// Busca a opção pelo ID e tenta deletá-la, mostrando mensagens de sucesso ou erro conforme necessário.
        try {
            $currentOption = OptionModel::findOrFail($optionId);
            $currentOption->delete();

            Log::logActivity(
                action: 'Deleted the option',
                description: $currentOption->description,
                projectId: $this->currentProject->id_project
            );

            $this->toast(
                message: 'Opção deletada com sucesso',
                type: 'success'
            );
            $this->updateOptions();
        } catch (\Exception $e) {
            $this->toast(
                message: $e->getMessage(),
                type: 'error'
            );
        } finally {
            $this->resetFields();
        }
    }

    // Renderiza a view do componente.
    public function render()
    {
        $project = $this->currentProject;

        return view(
            'livewire.planning.data-extraction.option',
            compact(
                'project',
            )
        )->extends('layouts.app');
    }
}
