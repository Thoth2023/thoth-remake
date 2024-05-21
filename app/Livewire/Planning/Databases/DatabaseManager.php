<?php

namespace App\Livewire\Planning\Databases;

use App\Utils\ToastHelper;
use Livewire\Component;
use App\Models\Database as DatabaseModel;

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

    /**
     * Executed when the component is mounted. It sets the
     * project id and retrieves the items.
     */
    public function mount()
    {
        $this->currentDatabase = null;
        $this->databases = DatabaseModel::all();
    }

    /**
     *  Approve a database to be used in all projects.
     */
    public function approveDatabase($databaseId)
    {
        try {
            $database = DatabaseModel::findOrFail($databaseId);

            $database->state = 'approved';
            $database->save();

            $this->toast(
                message: $this->translate('database_approved'),
                type: 'success',
            );
        } catch (\Exception $e) {
            $this->addError('database', $e->getMessage());
        }
    }

    public function rejectDatabase($databaseId)
    {
        try {
            $database = DatabaseModel::findOrFail($databaseId);

            $database->state = 'rejected';
            $database->save();

            $this->toast(
                message: $this->translate('database_rejected'),
                type: 'success',
            );
        } catch (\Exception $e) {
            $this->addError('database', $e->getMessage());
        }
    }

    /**
     * Render the component.
     */
    public function render()
    {
        $databases = $this->databases;

        return view(
            'livewire.planning.databases.approve-database',
            compact('databases')
        )->extends('layouts.app');
    }
}

