<?php

namespace App\Livewire\Planning\Databases;

use App\Utils\ToastHelper;
use Livewire\Component;
use App\Models\Database as DatabaseModel;
use Illuminate\Support\Facades\Gate;

class DatabaseManager extends Component
{
    // base de dados atualmente selecionada
    public $currentDatabase;
    public $databases = [];

    /**
     * Campos do formulário
     */
    public $database;
    public $suggest;
    public $link;

    /**
     * Estado do formulário, indica se está em edição
     */
    public $form = [
        'isEditing' => false,
    ];

    /**
     * Executado quando o componente é montado. Verifica a autorização e define os dados.
     */
    public function mount()
    {
        // Verifica se o usuário tem permissão para gerenciar bases de dados
        if (Gate::denies('manage-databases')) {
            $this->toast(
                message: $this->translate('unauthorized'),
                type: 'error'
            );

            // Evita renderização e redireciona para o dashboard
            $this->skipRender();
            return redirect()->route('dashboard');
        }

        $this->currentDatabase = null;
        $this->databases = $this->fetchDatabases(); // Carrega as bases de dados
    }

    /**
     * Traduz mensagens da interface
     */
    private function translate(string $message, string $key = 'toasts')
    {
        return __('project/planning.databases.livewire.' . $key . '.' . $message);
    }

    /**
     * Dispara um toast para a interface com tipo e mensagem
     */
    public function toast(string $message, string $type)
    {
        $this->dispatch('databases', ToastHelper::dispatch($type, $message));
    }

    /**
     * Retorna todas as bases de dados
     */
    public function fetchDatabases()
    {
        return Gate::allows('manage-databases')
            ? DatabaseModel::all()
            : collect();
    }

     /**
     * Aprova uma base de dados
     */
    public function approveDatabase($databaseId)
    {
        try {
            if (Gate::denies('manage-databases')) {
                throw new \Exception($this->translate('unauthorized'));
            }

            // Busca a base e altera seu estado para 'approved'
            $database = DatabaseModel::findOrFail($databaseId);
            $database->state = 'approved';
            $database->save();

            $this->dispatch('databaseStateUpdated', $databaseId, 'approved');

            $this->toast(
                message: $this->translate('database_approved'),
                type: 'success',
            );

        } catch (\Exception $e) {
            // Mostra erro na interface e envia toast de erro
            $this->addError('database', $e->getMessage());
            $this->toast(
                message: $e->getMessage(),
                type: 'error'
            );
        }
    }

    /**
     * Rejeita uma base de dados sugerida
     */
    public function rejectDatabase($databaseId)
    {
        try {
            if (Gate::denies('manage-databases')) {
                throw new \Exception($this->translate('unauthorized'));
            }

            // Altera o estado da base para 'rejected'
            $database = DatabaseModel::findOrFail($databaseId);
            $database->state = 'rejected';
            $database->save();

            $this->dispatch('databaseStateUpdated', $databaseId, 'rejected');

            $this->toast(
                message: $this->translate('database_rejected'),
                type: 'success',
            );

        } catch (\Exception $e) {
            // Mostra erro na interface e envia toast de erro
            $this->addError('database', $e->getMessage());
            $this->toast(
                message: $e->getMessage(),
                type: 'error'
            );
        }
    }

    /**
     * Exclui uma base de dados sugerida
     */
    public function deleteSuggestion($databaseId)
    {
        try {
            if (Gate::denies('manage-databases')) {
                throw new \Exception($this->translate('unauthorized'));
            }

            // Exclui a base e atualiza a lista
            $database = DatabaseModel::findOrFail($databaseId);
            $database->delete();

            $this->databases = $this->fetchDatabases();

            $this->toast(
                message: $this->translate('database_deleted'),
                type: 'success',
            );

        } catch (\Exception $e) {
            // Mostra erro na interface e envia toast de erro
            $this->addError('database', $e->getMessage());
            $this->toast(
                message: $e->getMessage(),
                type: 'error'
            );
        }
    }

    // Eventos Livewire que acionam métodos deste componente
    public $listeners = ['databaseStateUpdated' => 'updateDatabaseState'];

    /**
     * Atualiza o estado de uma base de dados
     */
    public function updateDatabaseState($databaseId, $state)
    {
        $database = collect($this->databases)->firstWhere('id_database', $databaseId);

        if ($database) {
            $database['state'] = $state;
        }
    }

    /**
     * Renderiza a view do componente
     */
    public function render()
    {
        return view('livewire.planning.databases.database-manager');
    }
}
