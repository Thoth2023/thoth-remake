<?php

namespace App\Livewire\Planning\Databases;


use Livewire\Component;
use App\Models\Project as ProjectModel;
use App\Models\Database as DatabaseModel;
use App\Models\ProjectDatabase as ProjectDatabaseModel;
use App\Utils\ActivityLogHelper as Log;
use App\Utils\ToastHelper;

class Databases extends Component
{
    public $currentProject;
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
     * Validation rules.
     */
    protected $rules = [
        'currentProject' => 'required',
        'database' => 'required|array|max:255',
        'database.*.value' => 'string',
    ];

    /**
     * Custom error messages for the validation rules.
     */
    protected function messages()
    {
        return [
            'description.required' => $this->translate(key: 'database', message: 'required'),
        ];
    }

    private function translate(string $message, string $key = 'toasts')
    {
        return __('project/planning.databases.livewire.' . $key . '.' . $message);
    }


    /**
     * Executed when the component is mounted. It sets the
     * project id and retrieves the items.
     */
    public function mount()
    {
        $projectId = request()->segment(2);
        $this->currentProject = ProjectModel::findOrFail($projectId);
        $this->currentDatabase = null;
        $this->databases = DatabaseModel::getOnlyApproved();
    }

    /**
     * Dispatch a toast message to the view.
     */
    public function toast(string $message, string $type)
    {
        $this->dispatch('databases', ToastHelper::dispatch($type, $message));


    }

    /**
     * Reset the fields to the default values.
     */
    public function resetFields()
    {
        $this->database = '';
        $this->currentDatabase = null;
        $this->form['isEditing'] = false;
    }

    /**
     * Submit the form. It also validates the input fields.
     */

    public function submit()
    {
        $this->validate();

        try {
            $projectDatabase = ProjectDatabaseModel::firstOrNew([
                'id_project' => $this->currentProject->id_project,
                'id_database' => $this->database["value"],
            ]);

            if ($projectDatabase->exists) {
                $this->toast(
                    message: $this->translate(key: 'database', message: 'already_exists'),
                    type: 'info',
                );
                return;
            }

            $database = DatabaseModel::findOrFail($this->database["value"]);

            Log::logActivity(
                action: 'Added database',
                description: $database->name,
                projectId: $this->currentProject->id_project,
            );

            $projectDatabase->save();

            $this->toast(
                message: $this->translate('added'),
                type: 'success',
            );

            // Emit the event after successfully adding the database
            $this->dispatch('databaseAdded', $this->currentProject->id_project);

        } catch (\Exception $e) {
            $this->addError('database', $e->getMessage());
        }
    }

    /**
     * Delete an item.
     */
    public function delete(string $databaseId)
    {
        $projectDatabase = ProjectDatabaseModel::where('id_project', $this->currentProject->id_project)
            ->where('id_database', $databaseId)
            ->first();

        $deleted = DatabaseModel::findOrFail($databaseId);
        $projectDatabase->delete();

        Log::logActivity(
            action: 'Deleted database',
            description: $deleted->name,
            projectId: $this->currentProject->id_project,
        );

        $this->toast(
            message: $this->translate('deleted'),
            type: 'success',
        );

        $this->dispatch('databaseDeleted', $this->currentProject->id_project);
    }

    /**
     * Render the component.
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
