<?php

namespace App\Livewire\Planning\Databases;

use App\Utils\ToastHelper;
use Livewire\Component;
use App\Models\Project as ProjectModel;
use App\Models\Database as DatabaseModel;
use App\Models\ProjectDatabase as ProjectDatabaseModel;
use App\Utils\ActivityLogHelper as Log;

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
        'link' => 'required|max:255|regex:/^(?:https?:\/\/)?(?:[^@\s\/]+@)?(?:[^\s\/]+\.)+[^\s\/]+\/?(?:[^\s\/]+(?:\/[^\s\/]+)*)?$/
        '
    ];

    /**
     * Custom error messages for the validation rules.
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
     * Executed when the component is mounted. It sets the
     * project id and retrieves the items.
     */
    public function mount()
    {
        $projectId = request()->segment(2);
        $this->currentProject = ProjectModel::findOrFail($projectId);
    }

    /**
     * Dispatch a toast message to the view.
     */
    public function toast(string $message, string $type)
    {
        $this->dispatch('suggest-database', ToastHelper::dispatch($type, $message));
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
            $suggestion = DatabaseModel::create([
                'name' => $this->suggest,
                'link' => $this->link,
            ]);

            Log::logActivity(
                action: 'Database suggested',
                description: $suggestion->name,
                projectId: $this->currentProject->id_project,
            );

            $this->toast(
                message: $this->translate('suggested'),
                type: 'success',
            );

            $this->resetFields();
        } catch (\Exception $e) {
            $this->addError('suggest', $e->getMessage());
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