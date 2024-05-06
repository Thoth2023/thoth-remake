<?php

namespace App\Livewire\Planning\Overall;

use Livewire\Component;
use App\Models\Language as LanguageModel;
use App\Models\Project as ProjectModel;
use App\Models\ProjectLanguage as ProjectLanguageModel;
use App\Utils\ActivityLogHelper as Log;

class Languages extends Component
{
    private $translationPath = 'project/planning.overall.language.livewire';

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
    protected function messages()
    {
        return [
            'language.required' => __($this->translationPath . '.language.required'),
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
        $this->languages = LanguageModel::all();
    }

    /**
     * Submit the form. It also validates the input fields.
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

            $language = LanguageModel::findOrFail($this->language["value"]);

            Log::logActivity(
                action: 'Added the language',
                description: $language->description,
                projectId: $this->currentProject->id_project,
            );

            $projectLanguage->save();
        } catch (\Exception $e) {
            $this->addError('language', $e->getMessage());
        }
    }

    /**
     * Delete an item.
     */
    public function delete(string $languageId)
    {
        $language = ProjectLanguageModel::where('id_project', $this->currentProject->id_project)
            ->where('id_language', $languageId)
            ->first();

        $deleted = LanguageModel::findOrFail($languageId);
        $language->delete();

        Log::logActivity(
            action: 'Deleted the language',
            description: $deleted->description,
            projectId: $this->currentProject->id_project,
        );
    }

    /**
     * Render the component.
     */
    public function render()
    {
        $project = $this->currentProject;

        return view(
            'livewire.planning.overall.languages',
            compact(
                'project',
            )
        )->extends('layouts.app');
    }
}
