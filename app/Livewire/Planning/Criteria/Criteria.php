<?php

namespace App\Livewire\Planning\Criteria;

use Illuminate\Validation\Rule;
use Livewire\Component;
use App\Models\Project as ProjectModel;
use App\Models\Criteria as CriteriaModel;
use App\Utils\ActivityLogHelper as Log;
use App\Utils\ToastHelper;
use App\Traits\ProjectPermissions;

class Criteria extends Component
{

    use ProjectPermissions;

    private $toastMessages = 'project/planning.criteria.livewire.toasts';

    public $currentProject;
    public $currentCriteria;
    public $criterias = [];

    /**
     * Fields to be filled by the form.
     */
    public $type;
    public $description;
    public $criteriaId;
    public $inclusion_rule;
    public $exclusion_rule;

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
        $this->inclusion_rule['value'] = CriteriaModel::where(
            'id_project',
            $this->currentProject->id_project
        )->where('type', 'Inclusion')->first()->rule ?? 'ALL';
        $this->exclusion_rule['value'] = CriteriaModel::where(
            'id_project',
            $this->currentProject->id_project
        )->where('type', 'Exclusion')->first()->rule ?? 'ANY';
        $this->type['value'] = 'NONE';
    }

    /**
     * Reset the fields to the default values.
     */
    public function resetFields()
    {
        $this->criteriaId = '';
        $this->description = '';
        $this->type['value'] = null;
        $this->currentCriteria = null;
        $this->form['isEditing'] = false;
    }

    public function changePreSelected($id, $type)
    {

        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        $preselected = CriteriaModel::where('id_criteria', $id)->first()->pre_selected == 1 ? 0 : 1;
        CriteriaModel::where('id_criteria', $id)->update(['pre_selected' => $preselected]);

        $allCriterias = CriteriaModel::where([
            'id_project' => $this->currentProject->id_project,
            'type' => $type,
        ])->get();

        $preselecteds = $allCriterias->where('pre_selected', 1)->count();
        $countCriterias = $allCriterias->count();

        $ruleValue = match (true) {
            $preselecteds > 0 && $preselecteds < $countCriterias => 'AT_LEAST',
            $preselecteds == 0 => 'ANY',
            $preselecteds == $countCriterias => 'ALL',
            default => 'ALL'
        };

        switch ($type) {
            case 'Inclusion':
                $this->inclusion_rule['value'] = $ruleValue;
                CriteriaModel::where([
                    'id_project' => $this->currentProject->id_project,
                    'type' => 'Inclusion'
                ])->update(['rule' => $this->inclusion_rule['value']]);
                break;
            case 'Exclusion':
                $this->exclusion_rule['value'] = $ruleValue;
                CriteriaModel::where([
                    'id_project' => $this->currentProject->id_project,
                    'type' => 'Exclusion'
                ])->update(['rule' => $this->exclusion_rule['value']]);
                break;
        }

        $this->updateCriterias();
    }

    public function selectRule($rule, $type)
    {

        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            $this->inclusion_rule['value'] = CriteriaModel::where(
                'id_project',
                $this->currentProject->id_project
            )->where('type', 'Inclusion')->first()->rule ?? 'ALL';
            $this->exclusion_rule['value'] = CriteriaModel::where(
                'id_project',
                $this->currentProject->id_project
            )->where('type', 'Exclusion')->first()->rule ?? 'ANY';
            return;
        }

        $where = [
            'id_project' => $this->currentProject->id_project,
            'rule' => $rule,
            'type' => $type,
        ];

        CriteriaModel::where([
            'id_project' => $this->currentProject->id_project,
            'type' => $type,
        ])->update(['rule' => $rule]);

        switch ($rule) {
            case 'ALL':
                CriteriaModel::where($where)->update(['pre_selected' => 1]);
                break;
            case 'ANY':
                CriteriaModel::where($where)->update(['pre_selected' => 0]);
                break;
            case 'AT_LEAST':
                $selectedCount = CriteriaModel::where([
                    'id_project' => $this->currentProject->id_project,
                    'pre_selected' => 1,
                    'type' => $type,
                    'rule' => $rule,
                ])->count();

                if ($selectedCount === 0) {
                    CriteriaModel::where($where)
                        ->first()->update(['pre_selected' => 1]);
                }
                break;
        }
        $this->updateCriterias();
    }

    /**
     * Update the items.
     */
    public function updateCriterias()
    {

        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        $this->criterias = CriteriaModel::where(
            'id_project',
            $this->currentProject->id_project
        )->get();

        $this->inclusion_rule['value'] = CriteriaModel::where(
            'id_project',
            $this->currentProject->id_project
        )->where('type', 'Inclusion')->first()->rule ?? 'ALL';

        $this->exclusion_rule['value'] = CriteriaModel::where(
            'id_project',
            $this->currentProject->id_project,
        )->where('type', 'Exclusion')->first()->rule ?? 'ANY';
    }

    /**
     * Dispatch a toast message to the view.
     */
    public function toast(string $message, string $type)
    {
        $this->dispatch('criteria', ToastHelper::dispatch($type, $message));
    }

    /**
     * Translate messages based on the given key.
     */
    public function translate($key)
    {
        return __($this->toastMessages . '.' . $key);
    }

    /**
     * Submit the form. It validates the input fields
     * and creates or updates an item.
     */
    public function submit()
    {

        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        $this->validate();

        if (strcmp($this->type['value'], 'NONE') === 0) {
            $this->toast(
                message: $this->translate('type.required'),
                type: 'info'
            );
            return;
        }

        $updateIf = [
            'id_criteria' => $this->currentCriteria?->id_criteria,
        ];

        try {
            $value = $this->form['isEditing'] ? 'Updated the criteria' : 'Added a criteria';

            $toastMessage = $this->translate($this->form['isEditing'] ? 'updated' : 'added');

            if (!$this->form['isEditing'] && $this->currentProject->criterias->contains('id', $this->criteriaId)) {
                $this->toast(
                    message: $this->translate('unique-id'),
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
                    message: $this->translate('unique-id'),
                    type: 'error'
                );
                return;
            }

            $updatedOrCreated = CriteriaModel::updateOrCreate($updateIf, [
                'id_project' => $this->currentProject->id_project,
                'id' => $this->criteriaId,
                'description' => $this->description,
                'type' => $this->type['value'],
                'rule' => $this->type['value'] == 'Inclusion' ?
                    $this->inclusion_rule['value'] : $this->exclusion_rule['value'],
            ]);

            Log::logActivity(
                action: $value,
                description: $updatedOrCreated->description,
                projectId: $this->currentProject->id_project
            );

            $this->selectRule($updatedOrCreated->rule, $this->type['value']);
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

        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

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

        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        try {
            $currentCriteria = CriteriaModel::findOrFail($criteriaId);
            $currentCriteria->delete();
            Log::logActivity(
                action: 'Deleted the criteria',
                description: $currentCriteria->description,
                projectId: $this->currentProject->id_project
            );

            $this->toast(
                message: $this->translate('deleted'),
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

        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        $this->exclusion_rule['value'] = CriteriaModel::where([
            'id_project' => $this->currentProject->id_project,
            'type' => 'Exclusion'
        ])->update(['rule' => $this->exclusion_rule['value']]);

        $this->inclusion_rule['value'] = CriteriaModel::where([
            'id_project' => $this->currentProject->id_project,
            'type' => 'Inclusion'
        ])->update(['rule' => $this->inclusion_rule['value']]);

        if ($type == 'Inclusion') {
            $this->toast(
                message: $this->translate('updated-inclusion'),
                type: 'success'
            );
        }

        if ($type == 'Exclusion') {
            $this->toast(
                message: $this->translate('updated-exclusion'),
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
