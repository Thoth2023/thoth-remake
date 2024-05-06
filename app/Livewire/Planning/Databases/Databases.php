<?php

namespace App\Livewire\Planning\Databases;

use Livewire\Component;
use App\Models\Project as ProjectModel;
use App\Models\Database as DatabaseModel;
use App\Models\ProjectDatabase as ProjectDatabaseModel;

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
    protected $messages = [
        'database.required' => 'The description field is required.',
    ];

    /**
     * Executed when the component is mounted. It sets the
     * project id and retrieves the items.
     */
    public function mount()
    {
        $projectId = request()->segment(2);
        $this->currentProject = ProjectModel::findOrFail($projectId);
        $this->currentDatabase = null;
        $this->databases = DatabaseModel::all();
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
                $this->addError('database', 'The provided database already exists in this project.');
                return;
            }

            $projectDatabase->save();
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

        if (!$projectDatabase->exists) {
            return;
        }

        $projectDatabase->delete();
    }

    /**
     * Render the component.
     */
    public function render()
    {
        $project = $this->currentProject;

        return view('livewire.planning.databases.databases', compact(
            'project',
        ))->extends('layouts.app');
    }
}
