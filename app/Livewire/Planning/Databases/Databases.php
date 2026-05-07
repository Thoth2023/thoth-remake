<?php

namespace App\Livewire\Planning\Databases;


use Livewire\Component;
use App\Models\Project as ProjectModel;
use App\Models\Database as DatabaseModel;
use App\Models\ProjectDatabase as ProjectDatabaseModel;
use App\Utils\ActivityLogHelper as Log;
use App\Utils\ToastHelper;
use App\Traits\ProjectPermissions;

class Databases extends Component
{

    use ProjectPermissions;

    // Caminho base das mensagens de toast
    private $toastMessages = 'project/planning.databases.livewire.toasts';

    // Projeto atual e base de dados selecionada
    public $currentProject;
    public $currentDatabase;

    public $databases = [];

    /**
     * Campos do formulário.
     */
    public $database;
    public $suggest;
    public $link;

    /**
     * Estado do formulário.
     */
    public $form = [
        'isEditing' => false,
    ];

    /**
     * Regras de validação.
     */
    protected $rules = [
        'currentProject' => 'required',
        'database' => 'required|array|max:255',
        'database.*.value' => 'string',
    ];

    /**
     * Mensagens personalizadas de erro para a validação.
     */
    protected function messages()
    {
        return [
            'description.required' => $this->translate(key: 'database', message: 'required'),
        ];
    }

    /**
     * Traduz mensagens da interface
     */
    private function translate(string $message, string $key = 'toasts')
    {
        return __('project/planning.databases.livewire.' . $key . '.' . $message);
    }


    /**
     * Executado quando o componente é montado.
     * Define o projeto atual e carrega as bases de dados aprovadas.
     */
    public function mount()
    {
        $projectId = request()->segment(2);
        $this->currentProject = ProjectModel::findOrFail($projectId);
        $this->currentDatabase = null;
        $this->databases = DatabaseModel::getOnlyApproved();
    }

    /**
     * Envia uma mensagem tipo toast para a interface.
     */
    public function toast(string $message, string $type)
    {
        $this->dispatch('databases', ToastHelper::dispatch($type, $message));
    }

    /**
     * Limpa os campos do formulário, retornando ao estado inicial.
     */
    public function resetFields()
    {
        $this->database = '';
        $this->currentDatabase = null;
        $this->form['isEditing'] = false;
    }

    /**
     * Submete o formulário após validar os campos.
     */
    public function submit()
    {
        // Verifica se o usuário tem permissão para editar o projeto
        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        $this->validate();

        try {
            // Verifica se já existe uma associação entre o projeto e a base selecionada
            $projectDatabase = ProjectDatabaseModel::firstOrNew([
                'id_project' => $this->currentProject->id_project,
                'id_database' => $this->database["value"],
            ]);

            // Se já existir, informa o usuário e não cria duplicata
            if ($projectDatabase->exists) {
                $this->toast(
                    message: $this->translate(key: 'database', message: 'already_exists'),
                    type: 'info',
                );
                return;
            }

            // Recupera os dados completos da base
            $database = DatabaseModel::findOrFail($this->database["value"]);

            // Registra a atividade no log do sistema
            Log::logActivity(
                action: 'Added database',
                description: $database->name,
                module: 1,
                projectId: $this->currentProject->id_project,
            );

            $projectDatabase->save();

            $this->toast(
                message: $this->translate('added'),
                type: 'success',
            );

            // Dispara evento para atualizar o estado do front
            $this->dispatch('databaseAdded', $this->currentProject->id_project);

        } catch (\Exception $e) {
            $this->addError('database', $e->getMessage());
        }
    }

    /**
     * Exclui uma base de dados associada ao projeto.
     */
    public function delete(string $databaseId)
    {

        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        $projectDatabase = ProjectDatabaseModel::where('id_project', $this->currentProject->id_project)
            ->where('id_database', $databaseId)
            ->first();

        // Busca os dados da base que será deletada
        $deleted = DatabaseModel::findOrFail($databaseId);

        // Remove o relacionamento
        $projectDatabase->delete();

        // Registra a exclusão no log de atividades
        Log::logActivity(
            action: 'Deleted database',
            description: $deleted->name,
            module: 1,
            projectId: $this->currentProject->id_project,
        );

        $this->toast(
            message: $this->translate('deleted'),
            type: 'success',
        );

        $this->dispatch('databaseDeleted', $this->currentProject->id_project);
    }

    /**
     * Renderiza a view do componente
     */
    public function render()
    {
        $project = $this->currentProject;

        return view(
            'livewire.planning.databases.databases',
            compact(
                'project',
            )
        )->extends('layouts.app');
    }


}
