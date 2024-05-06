<?php

namespace App\Livewire\Planning\Overall;

use Livewire\Component;
use App\Models\Project as ProjectModel;
use App\Models\Keyword as KeywordModel;
use App\Utils\ActivityLogHelper as Log;

class Keywords extends Component
{
    private $translationPath = 'project/planning.overall.keyword.livewire';

    public $currentProject;
    public $currentKeyword;
    public $keywords = [];

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
    protected function messages()
    {
        return [
            'description.required' => __($this->translationPath . '.description.required'),
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
        $this->currentKeyword = null;
        $this->keywords = KeywordModel::where(
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
        $this->currentKeyword = null;
        $this->form['isEditing'] = false;
    }

    /**
     * Update the items.
     */
    public function updateKeywords()
    {
        $this->keywords = KeywordModel::where(
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
            'id_keyword' => $this->currentKeyword?->id_keyword,
        ];

        try {
            $updatedOrCreated = KeywordModel::updateOrCreate($updateIf, [
                'id_project' => $this->currentProject->id_project,
                'description' => $this->description,
            ]);

            Log::logActivity(
                action: $this->form['isEditing'] ? 'Updated the keyword' : 'Added a keyword',
                description: $updatedOrCreated->description,
                projectId: $this->currentProject->id_project
            );

            $this->updateKeywords();
        } catch (\Exception $e) {
            $this->addError('description', $e->getMessage());
        } finally {
            $this->resetFields();
        }
    }

    /**
     * Fill the form fields with the given data.
     */
    public function edit(string $keywordId)
    {
        $this->currentKeyword = KeywordModel::findOrFail($keywordId);
        $this->description = $this->currentKeyword->description;
        $this->form['isEditing'] = true;
    }

    /**
     * Delete an item.
     */
    public function delete(string $keywordId)
    {
        $currentKeyword = KeywordModel::findOrFail($keywordId);
        $currentKeyword->delete();

        Log::logActivity(
            action: 'Deleted the keyword',
            description: $currentKeyword->description,
            projectId: $this->currentProject->id_project
        );

        $this->updateKeywords();
        $this->resetFields();
    }

    /**
     * Render the component.
     */
    public function render()
    {
        $project = $this->currentProject;

        return view(
            'livewire.planning.overall.keywords',
            compact(
                'project',
            )
        )->extends('layouts.app');
    }
}
