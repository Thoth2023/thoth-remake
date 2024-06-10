<?php

namespace App\Livewire\Planning\Criteria;

use Livewire\Component;
use App\Models\Project as ProjectModel;
use App\Models\Criteria as CriteriaModel;
use App\Utils\ActivityLogHelper as Log;
use App\Utils\ToastHelper;

class Criteria extends Component
{
    public $currentProject;
    public $currentCriteria;
    public $criterias = [];

    /**
     * Fields to be filled by the form.
     */
    public $pre_selected;
    public $type;
    public $description;
    public $criteriaId;

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
        'criteriaId' => 'required|string|max:20|regex:/^[a-zA-Z0-9]+$/',
        'description' => 'required|string|max:255',
        'type' => 'required'
    ];

    /**
     * Custom error messages for the validation rules.
     */
    protected $messages = [
        'description.required' => 'The description field is required.',
        'criteriaId.required' => 'The ID field is required.',
        'criteriaId.regex' => 'The ID field must contain only letters and numbers.',
        'type.required' => 'The type field is required'
    ];

    /**
     * Executed when the component is mounted. It sets the
     * project id and retrieves the items.
     */
    public function mount()
    {
        $projectId = request()->segment(2);
        $this->currentProject = ProjectModel::findOrFail($projectId);
        $this->currentCriteria = null;
        $this->criterias = CriteriaModel::where(
            'id_project',
            $this->currentProject->id_project
        )->get();
        $this->pre_selected = session('pre_selected');
    }

    /**
     * Reset the fields to the default values.
     */
    public function resetFields()
    {
        $this->criteriaId = '';
        $this->description = '';
        $this->type = [];
        $this->currentCriteria = null;
        $this->form['isEditing'] = false;
    }

    /**
     * Update the items.
     */
    public function updateCriterias()
    {
        $this->criterias = CriteriaModel::where(
            'id_project',
            $this->currentProject->id_project
        )->get();
    }

    /**
     * Dispatch a toast message to the view.
     */
    public function toast(string $message, string $type)
    {
        $this->dispatch('criteria', ToastHelper::dispatch($type, $message));
    }

    private function message(string $message)
    {
        return __('project/planning.criteria.livewire.toasts' . $message);
    }

    /**
     * Submit the form. It validates the input fields
     * and creates or updates an item.
     */
    public function submit()
    {
        $this->validate();

        $updateIf = [
            'id_criteria' => $this->currentCriteria?->id_criteria,
        ];

        try {
            $value = $this->form['isEditing'] ? 'Updated the criteria' : 'Added a criteria';
            $toastMessage = $this->message($this->form['isEditing'] ? '.updated' : '.added');

            if (!$this->form['isEditing'] && $this->currentProject->criterias->contains('id', $this->criteriaId)) {
                $this->toast(
                    message: 'This ID is already in use. Please choose a unique ID for the criteria.',
                    type: 'error'
                );
                return;
            }

            if (
                $this->form['isEditing']
                && $this->currentCriteria->id != $this->criteriaId
                && $this->currentProject->criterias->contains('id', $this->criteriaId)
            ) {
                $this->toast(
                    message: 'This ID is already in use. Please choose a unique ID for the criteria.',
                    type: 'error'
                );
                return;
            }

            $updatedOrCreated = CriteriaModel::updateOrCreate($updateIf, [
                'id_project' => $this->currentProject->id_project,
                'id' => $this->criteriaId,
                'description' => $this->description,
                'type' => $this->type['value']
            ]);

            Log::logActivity(
                action: $value,
                description: $updatedOrCreated->description,
                projectId: $this->currentProject->id_project
            );

            $this->updateCriterias();
            $this->toast(
                message: $toastMessage,
                type: 'success'
            );
        } catch (\Exception $e) {
            $this->toast(
                message: $e->getMessage(),
                type: 'error'
            );
        } finally {
            $this->resetFields();
        }
    }

    /**
     * Fill the form fields with the given data.
     */
    public function edit(string $criteriaId)
    {
        $this->currentCriteria = CriteriaModel::findOrFail($criteriaId);
        $this->criteriaId = $this->currentCriteria->id;
        $this->description = $this->currentCriteria->description;
        $this->type['value'] = $this->currentCriteria->type;
        $this->form['isEditing'] = true;
    }

    /**
     * Delete an item.
     */
    public function delete(string $criteriaId)
    {
        try {
            $currentCriteria = CriteriaModel::findOrFail($criteriaId);
            $currentCriteria->delete();
            Log::logActivity(
                action: 'Deleted the criteria',
                description: $currentCriteria->description,
                projectId: $this->currentProject->id_project
            );

            $this->toast(
                message: $this->message('.deleted'),
                type: 'success'
            );
            $this->updateCriterias();
        } catch (\Exception $e) {
            $this->toast(
                message: $e->getMessage(),
                type: 'error'
            );
        } finally {
            $this->resetFields();
        }
    }

    /**
     * Update the value of the inclusion criteria rule.
     */
    public function updateInclusionCriteriaRule()
    {
        foreach ($this->criteria as $criterion) {
            if ($criterion['type'] === 'Inclusion') {
                $this->pre_selected['value'] = $this->currentCriteria->pre_selected;
            }
            $this->updateCriterias();
        }
    }

    /**
     * Update the value of the exclusion criteria rule.
     */
    public function updateExclusionCriteriaRule()
    {
        foreach ($this->criteria as $criterion) {
            if ($criterion['type'] === 'Exclusion') {
                session(['pre_selected' => $this->pre_selected]);
                $this->pre_selected['value'] = $this->currentCriteria->pre_selected;
            }
            $this->updateCriterias();
        }
    }

    /**
     * Render the component.
     */
    public function render()
    {
        return view('livewire.planning.criteria.criteria')->extends('layouts.app');
    }
}


