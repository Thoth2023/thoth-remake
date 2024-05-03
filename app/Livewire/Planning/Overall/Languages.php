<?php

namespace App\Livewire\Planning\Overall;

use Livewire\Component;
use App\Models\Language as LanguageModel;
use App\Models\Project as ProjectModel;
use App\Models\ProjectLanguage as ProjectLanguageModel;

class Languages extends Component
{
    public $currentProject;
    public $languages = [];

    /**
     * Fields to be filled by the form.
     */
    public $language;

    /**
     * Validation rules.
     */
    protected $rules = [
        'currentProject' => 'required',
        'language' => 'required|array',
        'language.*.value' => 'number|exists:languages,id_language',
    ];

    /**
     * Custom error messages for the validation rules.
     */
    protected $messages = [
        'language.required' => 'The language field is required.',
    ];

    /**
     * Executed when the component is mounted. It sets the
     * project id and retrieves the domains.
     */
    public function mount()
    {
        $projectId = request()->segment(2);
        $this->currentProject = ProjectModel::findOrFail($projectId);
        $this->languages = LanguageModel::all();
    }

    /**
     * Submit the form. It validates the input fields
     * and creates or updates a domain.
     */
    public function submit()
    {
        $this->validate();

        try {
            $projectLanguage = ProjectLanguageModel::firstOrNew([
                'id_project' => $this->currentProject->id_project,
                'id_language' => $this->language["value"],
            ]);

            if ($projectLanguage->exists) {
                $this->addError('language', 'The provided language already exists in this project.');
                return;
            }

            $projectLanguage->save();
        } catch (\Exception $e) {
            $this->addError('language', $e->getMessage());
        }
    }

    /**
     * Delete a domain.
     */
    public function delete(string $languageId)
    {
        $language = ProjectLanguageModel::where('id_project', $this->currentProject->id_project)
            ->where('id_language', $languageId)
            ->first();

        $language?->delete();
    }

    /**
     * Render the component.
     */
    public function render()
    {
        $project = $this->currentProject;

        return view('livewire.planning.overall.languages', compact(
            'project',
        ))->extends('layouts.app');
    }
}
