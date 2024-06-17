<?php

namespace App\Livewire\Planning\Criteria;

use Illuminate\Validation\Rule;
use Livewire\Component;
use App\Models\Project as ProjectModel;
use App\Models\Criteria as CriteriaModel;
use App\Utils\ActivityLogHelper as Log;
use App\Utils\ToastHelper;

class Criteria extends Component
{
    private $toastMessages = 'project/planning.criteria.livewire.toasts';

    public $currentProject;
    public $currentCriteria;
    public $criterias = [];

    /**
     * Fields to be filled by the form.
     */
    public $pre_selected_inclusion;
    public $pre_selected_exclusion;

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
    protected function rules()
    {
        return [
            'currentProject' => 'required',
            'criteriaId' => 'required|string|max:20|regex:/^[a-zA-Z0-9]+$/',
            'description' => 'required|string|max:255',
            'type' => 'required|array',
            'type.*.value' => 'string'
        ];
    }

    /**
     * Custom translation messages for the validation rules.
     */
    public function translate()
    {
        $toasts = 'project/planning.criteria.livewire.toasts';

        return [
            'type.required' => __($toasts . '.type.required'),
            'updated' => __($toasts . '.updated'),
            'added' => __($toasts . '.added'),
            'deleted' => __($toasts . '.deleted'),
            'updated-inclusion' => __($toasts . '.updated-inclusion'),
            'updated-exclusion' => __($toasts . '.updated-exclusion'),
            'unique-id' => __($toasts . '.unique-id')
        ];
    }

    /**
     * Custom error messages for the validation rules.
     */
    protected function messages()
    {
        $tpath = 'project/planning.criteria.livewire';

        return [
            'description.required' => __($tpath . '.description.required'),
            'criteriaId.required' => __($tpath . '.criteriaId.required'),
            'criteriaId.regex' => __($tpath . '.criteriaId.regex'),
            'type.required' => __($tpath . '.type.required'),
        ];
    }

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
        $this->pre_selected_inclusion['value'] = CriteriaModel::where(
            'id_project',
            $this->currentProject->id_project
        )->where('type', 'Inclusion')->first()->pre_selected ?? 0;
        $this->pre_selected_exclusion['value'] = CriteriaModel::where(
            'id_project',
            $this->currentProject->id_project
        )->where('type', 'Exclusion')->first()->pre_selected ?? 0;
        $this->type['value'] = '-1';
    }

    /**
     * Reset the fields to the default values.
     */
    public function resetFields()
    {
        $this->criteriaId = '';
        $this->description = '';
        $this->type['value'] = '-1';
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

        $this->pre_selected_inclusion['value'] = CriteriaModel::where(
            'id_project',
            $this->currentProject->id_project
        )->where('type', 'Inclusion')->first()->pre_selected ?? 0;

        $this->pre_selected_exclusion['value'] = CriteriaModel::where(
            'id_project',
            $this->currentProject->id_project,
        )->where('type', 'Exclusion')->first()->pre_selected ?? 0;
    }

    /**
     * Dispatch a toast message to the view.
     */
    public function toast(string $message, string $type)
    {
        $this->dispatch('criteria', ToastHelper::dispatch($type, $message));
    }

    /**
     * Submit the form. It validates the input fields
     * and creates or updates an item.
     */
    public function submit()
    {
        $this->validate();

        if ($this->type['value'] == '-1') {
            $this->toast(
                message: $this->translate()['type.required'],
                type: 'info'
            );
            return;
        }

        $updateIf = [
            'id_criteria' => $this->currentCriteria?->id_criteria,
        ];

        try {
            $value = $this->form['isEditing'] ? 'Updated the criteria' : 'Added a criteria';

            $toastMessage = $this->translate()[$this->form['isEditing'] ? 'updated' : 'added'];

            if (!$this->form['isEditing'] && $this->currentProject->criterias->contains('id', $this->criteriaId)) {
                $this->toast(
                    message: $this->translate()['unique-id'],
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
                    message: $this->translate()['unique-id'],
                    type: 'error'
                );
                return;
            }

            $updatedOrCreated = CriteriaModel::updateOrCreate($updateIf, [
                'id_project' => $this->currentProject->id_project,
                'id' => $this->criteriaId,
                'description' => $this->description,
                'type' => $this->type['value'],
                'pre_selected' => 0
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
                message: $this->translate()['deleted'],
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
    public function updateCriteriaRule($type)
    {
        $this->pre_selected_exclusion['value'] = CriteriaModel::where([
            'id_project' => $this->currentProject->id_project,
            'type' => 'Exclusion'
        ])->update(['pre_selected' => $this->pre_selected_exclusion['value']]);

        $this->pre_selected_inclusion['value'] = CriteriaModel::where([
            'id_project' => $this->currentProject->id_project,
            'type' => 'Inclusion'
        ])->update(['pre_selected' => $this->pre_selected_inclusion['value']]);

        if ($type == 'Inclusion') {
            $this->toast(
                message: $this->translate()['updated-inclusion'],
                type: 'success'
            );
        }

        if ($type == 'Exclusion') {
            $this->toast(
                message: $this->translate()['updated-exclusion'],
                type: 'success'
            );
        }

        $this->updateCriterias();
    }

    /**
     * Render the component.
     */
    public function render()
    {
        return view('livewire.planning.criteria.criteria')->extends('layouts.app');
    }
}


