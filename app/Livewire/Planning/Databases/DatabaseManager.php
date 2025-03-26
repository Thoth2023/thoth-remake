<?php

namespace App\Livewire\Planning\Databases;

use App\Utils\ToastHelper;
use Livewire\Component;
use App\Models\Database as DatabaseModel;
use Illuminate\Support\Facades\Gate;

class DatabaseManager extends Component
{
    public $currentDatabase;
    public $databases = [];

    /**
     * Fields to be filled by the form.
     */
    public $database;
    public $suggest;
    public $link;

    /**
     * Form state.
     */
    public $form = [
        'isEditing' => false,
    ];

    /**
     * Executed when the component is mounted. It checks authorization and sets the data.
     */
    public function mount()
    {
        // Verifica a autorização
        if (Gate::denies('manage-databases')) {
            $this->toast(
                message: $this->translate('unauthorized'),
                type: 'error'
            );

            $this->skipRender(); // Evita a renderização do componente
            return redirect()->route('dashboard');
        }

        $this->currentDatabase = null;
        $this->databases = $this->fetchDatabases();
    }

    /**
     * Translation of the messages.
     */
    private function translate(string $message, string $key = 'toasts')
    {
        return __('project/planning.databases.livewire.' . $key . '.' . $message);
    }

    /**
     * Dispatch a toast message to the view.
     */
    public function toast(string $message, string $type)
    {
        $this->dispatch('databases', ToastHelper::dispatch($type, $message));
    }

    public function fetchDatabases()
    {
        return Gate::allows('manage-databases')
            ? DatabaseModel::all()
            : collect();
    }

    /**
     *  Approve a database to be used in all projects.
     */
    public function approveDatabase($databaseId)
    {
        try {
            if (Gate::denies('manage-databases')) {
                throw new \Exception($this->translate('unauthorized'));
            }

            $database = DatabaseModel::findOrFail($databaseId);
            $database->state = 'approved';
            $database->save();

            $this->dispatch('databaseStateUpdated', $databaseId, 'approved');

            $this->toast(
                message: $this->translate('database_approved'),
                type: 'success',
            );

        } catch (\Exception $e) {
            $this->addError('database', $e->getMessage());
            $this->toast(
                message: $e->getMessage(),
                type: 'error'
            );
        }
    }

    public function rejectDatabase($databaseId)
    {
        try {
            if (Gate::denies('manage-databases')) {
                throw new \Exception($this->translate('unauthorized'));
            }

            $database = DatabaseModel::findOrFail($databaseId);
            $database->state = 'rejected';
            $database->save();

            $this->dispatch('databaseStateUpdated', $databaseId, 'rejected');

            $this->toast(
                message: $this->translate('database_rejected'),
                type: 'success',
            );

        } catch (\Exception $e) {
            $this->addError('database', $e->getMessage());
            $this->toast(
                message: $e->getMessage(),
                type: 'error'
            );
        }
    }

    public function deleteSuggestion($databaseId)
    {
        try {
            if (Gate::denies('manage-databases')) {
                throw new \Exception($this->translate('unauthorized'));
            }

            $database = DatabaseModel::findOrFail($databaseId);
            $database->delete();

            $this->databases = $this->fetchDatabases();

            $this->toast(
                message: $this->translate('database_deleted'),
                type: 'success',
            );

        } catch (\Exception $e) {
            $this->addError('database', $e->getMessage());
            $this->toast(
                message: $e->getMessage(),
                type: 'error'
            );
        }
    }

    public $listeners = ['databaseStateUpdated' => 'updateDatabaseState'];

    public function updateDatabaseState($databaseId, $state)
    {
        $database = collect($this->databases)->firstWhere('id_database', $databaseId);

        if ($database) {
            $database['state'] = $state;
        }
    }

    /**
     * Render the component.
     */
    public function render()
    {
        return view('livewire.planning.databases.database-manager');
    }
}
