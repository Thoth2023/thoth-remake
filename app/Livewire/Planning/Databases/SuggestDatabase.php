<?php

namespace App\Livewire\Planning\Databases;

use App\Models\ProjectNotification;
use App\Models\User;
use App\Utils\ToastHelper;
use Livewire\Component;
use App\Models\Project as ProjectModel;
use App\Models\Database as DatabaseModel;
use App\Models\ProjectDatabase as ProjectDatabaseModel;
use App\Utils\ActivityLogHelper as Log;
use App\Traits\ProjectPermissions;

class SuggestDatabase extends Component
{

    use ProjectPermissions;

    // Projeto atual ao qual a sugestão será associada
    public $currentProject;
    private $toastMessages = 'project/planning.databases.livewire.toasts';

    /**
     * Campos do formulário de sugestão.
     */
    public $suggest;
    public $link;

    /**
     * Regras de validação para os campos do formulário.
     */
    protected $rules = [
        'currentProject' => 'required',
        'suggest' => 'required|max:100',
        'link' => 'required|max:255|regex:/^(?:https?:\/\/)?(?:[^@\s\/]+@)?(?:[^\s\/]+\.)+[^\s\/]+\/?(?:[^\s\/]+(?:\/[^\s\/]+)*)?$/
        '
    ];

    /**
     * Mensagens de erro personalizadas para a validação.
     */
    protected function messages()
    {
        return [
            'suggest.required' => $this->translate(key: 'database', message: 'required'),
            'link.required' => $this->translate(key: 'database', message: 'required_link'),
            'link.regex' => $this->translate(key: 'database', message: 'invalid_link'),
        ];
    }

    private function translate(string $message, string $key = 'toasts')
    {
        return __('project/planning.databases.livewire.' . $key . '.' . $message);
    }

    /**
     * Método executado quando o componente é montado.
     * Recupera o projeto com base no ID da URL.
     */
    public function mount()
    {
        $projectId = request()->segment(2);
        $this->currentProject = ProjectModel::findOrFail($projectId);
    }

    /**
     * Envia uma mensagem tipo toast para o front
     */
    public function toast(string $message, string $type)
    {
        $this->dispatch('suggest-database', ToastHelper::dispatch($type, $message));
    }

    /**
     * Reseta os campos do formulário para os valores iniciais.
     * Usado após submissão bem-sucedida.
     */
    public function resetFields()
    {
        $this->suggest = '';
        $this->link = '';
    }

    /**
     * Submete a sugestão de uma nova base de dados.
     * Valida os campos, cria o registro e registra log.
     */
    public function submit()
    {
        // Verifica se o usuário tem permissão para editar o projeto
        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        $this->validate();

        try {
            // Cria a nova base de dados sugerida
            $suggestion = DatabaseModel::create([
                'name' => $this->suggest,
                'link' => $this->link,
            ]);

            // Registra a atividade de sugestão no log do projeto
            Log::logActivity(
                action: 'Database suggested',
                description: $suggestion->name,
                projectId: $this->currentProject->id_project,
            );

            // Exibe mensagem de sucesso para o usuário
            $this->toast(
                message: $this->translate('suggested'),
                type: 'success',
            );
            // Notificar super users
            $superUsers = User::where('role', 'SUPER_USER')->get();

            foreach ($superUsers as $su) {
                ProjectNotification::create([
                    'user_id'    => $su->id,
                    'project_id' => $this->currentProject->id_project,
                    'type'       => 'database_suggestion',
                    'message'    => __('notification.database_suggestion.message', [
                        'project' => $this->currentProject->title
                    ]),
                ]);
            }

            // Limpa os campos do formulário
            $this->resetFields();
        } catch (\Exception $e) {
            $this->addError('suggest', $e->getMessage());
        }
    }

    /**
     * Renderiza a view do componente
     */
    public function render()
    {
        $project = $this->currentProject;

        return view(
            'livewire.planning.databases.suggest-database',
            compact(
                'project',
            )
        )->extends('layouts.app');
    }
}
