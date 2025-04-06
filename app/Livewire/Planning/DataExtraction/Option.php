<?php

namespace App\Livewire\Planning\DataExtraction;

use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\Project as ProjectModel;
use App\Models\Project\Planning\DataExtraction\Option as OptionModel;
use App\Utils\ActivityLogHelper as Log;
use App\Utils\ToastHelper;
use Illuminate\Support\Facades\Auth;

class Option extends Component
{
    public $currentProject;
    public $currentOption;
    public $options = [];
    public $optionId;
    public $questionId = [];

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
        'description' => [
          'required',
          'string',
          'regex:/^[a-zA-ZÀ-ÿ0-9\s]+$/u',  
        ],
        'questionId' => 'required|array',
        'questionId.*.value' => 'exists:question_extraction,id',
    ];

    /**
     * Custom error messages for the validation rules.
     */
    protected function messages()
    {
        return [
            'description.required' => 'Este campo é obrigatório',
            'questionId.required' => 'Este campo é obrigatório',

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
        $this->currentOption = null;
        $this->options = OptionModel::whereHas('question', function ($query) {
            $query->where('id_project', $this->currentProject->id_project);
        })->get();
    }

    /**
     * Reset the fields to the default values.
     */
    private function resetFields()
    {
        $this->optionId = null;
        $this->description = null;
        $this->questionId['value'] = $this->currentProject
            ->dataExtractionQuestions->first()->id_de ?? null;
        $this->form['isEditing'] = false;
    }

    /**
     * Update the items.
     */
    #[On('update-question-select')]
    public function updateOptions()
    {
        $this->options = OptionModel::whereHas('question', function ($query) {
            $query->where('id_project', $this->currentProject->id_project);
        })->get();
        $this->dispatch('update-table');
    }

    /**
     * Dispatch a toast message to the view.
     */
    public function toast(string $message, string $type)
    {
        $this->dispatch('options', ToastHelper::dispatch($type, $message));
    }

    /**
     * Submit the form. It validates the input fields
     * and creates or updates an item.
     */
    public function submit()
    {
        $this->validate();

        $updateIf = [
            'id_option' => $this->currentOption?->id_option,
        ];

        try {
            $value = $this->form['isEditing'] ? 'Updated the option' : 'Added a option';
            $toastMessage = $this->form['isEditing']
                ? 'Opção atualizada com sucesso!' : 'Opção adicionada com sucesso!';

            $updatedOrCreated = OptionModel::updateOrCreate($updateIf, [
                'id_de' => $this->questionId["value"],
                'description' => $this->description,
            ]);

            Log::logActivity(
                action: $value,
                description: $updatedOrCreated->description,
                projectId: $this->currentProject->id_project
            );

            $this->updateOptions();
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
    #[On('data-extraction-table-edit-option')]
    public function edit(string $optionId)
    {
        $this->currentOption = OptionModel::findOrFail($optionId);
        $this->optionId = $this->currentOption->id;
        $this->description = $this->currentOption->description;
        $this->questionId['value'] = $this->currentOption->id_de;
        $this->form['isEditing'] = true;

    }

    /**
     * Delete an item.
     */
    #[On('data-extraction-table-delete-option')]
    public function delete(string $optionId)
    {
        try {
            $currentOption = OptionModel::findOrFail($optionId);
            $currentOption->delete();

            Log::logActivity(
                action: 'Deleted the option',
                description: $currentOption->description,
                projectId: $this->currentProject->id_project
            );

            $this->toast(
                message: 'Opção deletada com sucesso',
                type: 'success'
            );
            $this->updateOptions();
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
     * Render the component.
     */
    public function render()
    {
        $project = $this->currentProject;

        return view(
            'livewire.planning.data-extraction.option',
            compact(
                'project',
            )
        )->extends('layouts.app');
    }
}


