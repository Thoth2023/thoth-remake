<?php

namespace App\Livewire\Planning\Databases;

use Livewire\Component;
use App\Models\Project as ProjectModel;
use App\Models\Database as DatabaseModel;
use App\Models\ProjectDatabase as ProjectDatabaseModel;

class SuggestDatabase extends Component
{
    public $currentProject;

    /**
     * Fields to be filled by the form.
     */
    public $suggest;
    public $link;

    /**
     * Validation rules.
     */
    protected $rules = [
        'currentProject' => 'required',
        'suggest' => 'required|max:100',
        'link' => 'required|max:255'
    ];

    /**
     * Custom error messages for the validation rules.
     */
    protected $messages = [
        'suggeset.required' => 'The database name is required.',
        'link.required' => 'The database link is required.'
    ];

    /**
     * Executed when the component is mounted. It sets the
     * project id and retrieves the items.
     */
    public function mount()
    {
        $projectId = request()->segment(2);
        $this->currentProject = ProjectModel::findOrFail($projectId);
    }

    /**
     * Reset the fields to the default values.
     */
    public function resetFields()
    {
        $this->suggest = '';
        $this->link = '';
    }

    /**
     * Submit the form. It also validates the input fields.
     */
    public function submit()
    {
        $this->validate();

        try {
            $database = DatabaseModel::create([
                'suggest' => $this->name,
                'link' => $this->link,
            ]);
            dd($database);
        } catch (\Exception $e) {
            $this->addError('database', $e->getMessage());
        }
    }

    /**
     * Render the component.
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