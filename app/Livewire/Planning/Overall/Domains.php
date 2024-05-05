<?php

namespace App\Livewire\Planning\Overall;

use Livewire\Component;
use App\Models\Project as ProjectModel;
use App\Models\Domain as DomainModel;
use App\Utils\ActivityLogHelper as Log;

class Domains extends Component
{
    public $currentProject;
    public $currentDomain;
    public $domains = [];

    /**
     * Fields to be filled by the form.
     */
    public $description;

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
        'description' => 'required|string|max:255',
    ];

    /**
     * Custom error messages for the validation rules.
     */
    protected $messages = [
        'description.required' => 'The description field is required.',
    ];

    /**
     * Executed when the component is mounted. It sets the
     * project id and retrieves the items.
     */
    public function mount()
    {
        $projectId = request()->segment(2);
        $this->currentProject = ProjectModel::findOrFail($projectId);
        $this->currentDomain = null;
        $this->domains = DomainModel::where(
            'id_project',
            $this->currentProject->id_project
        )->get();
    }

    /**
     * Reset the fields to the default values.
     */
    public function resetFields()
    {
        $this->description = '';
        $this->currentDomain = null;
        $this->form['isEditing'] = false;
    }

    /**
     * Update the items.
     */
    public function updateDomains()
    {
        $this->domains = DomainModel::where(
            'id_project',
            $this->currentProject->id_project
        )->get();
    }

    /**
     * Submit the form. It validates the input fields
     * and creates or updates an item.
     */
    public function submit()
    {
        $this->validate();

        $updateIf = [
            'id_domain' => $this->currentDomain?->id_domain,
        ];

        try {
            $updatedOrCreated = DomainModel::updateOrCreate($updateIf, [
                'id_project' => $this->currentProject->id_project,
                'description' => $this->description,
            ]);

            Log::logActivity(
                action: $this->form['isEditing'] ? 'Updated the domain' : 'Added a domain',
                description: $updatedOrCreated->description,
                projectId: $this->currentProject->id_project
            );

            $this->updateDomains();
        } catch (\Exception $e) {
            $this->addError('description', $e->getMessage());
        } finally {
            $this->resetFields();
        }
    }

    /**
     * Fill the form fields with the given data.
     */
    public function edit(string $domainId)
    {
        $this->currentDomain = DomainModel::findOrFail($domainId);
        $this->description = $this->currentDomain->description;
        $this->form['isEditing'] = true;
    }

    /**
     * Delete an item.
     */
    public function delete(string $domainId)
    {
        $currentDomain = DomainModel::findOrFail($domainId);
        $currentDomain->delete();

        Log::logActivity(
            action: 'Deleted the domain',
            description: $currentDomain->description,
            projectId: $this->currentProject->id_project
        );

        $this->updateDomains();
    }

    /**
     * Render the component.
     */
    public function render()
    {
        $project = $this->currentProject;

        return view(
            'livewire.planning.overall.domains',
            compact(
                'project',
            )
        )->extends('layouts.app');
    }
}
