<?php

namespace App\Livewire\Planning\Overall;

use App\Utils\ToastHelper;
use Livewire\Component;
use App\Models\Language as LanguageModel;
use App\Models\Project as ProjectModel;
use App\Models\ProjectLanguage as ProjectLanguageModel;
use App\Utils\ActivityLogHelper as Log;

class Languages extends Component
{
    private $translationPath = 'project/planning.overall.language.livewire';
    private $toastMessages = 'project/planning.overall.language.livewire.toasts';

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
     * Dispatch a toast message to the view.
     */
    public function toast(string $message, string $type)
    {
        $this->dispatch('languages', ToastHelper::dispatch($type, $message));
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
                $this->toast(
                    __($this->translationPath . '.language.already_exists'),
                    'info',
                );
                return;
            }

            $language = LanguageModel::findOrFail($this->language["value"]);

            Log::logActivity(
                action: 'Added the language',
                description: $language->description,
                projectId: $this->currentProject->id_project,
            );

            $projectLanguage->save();

            $this->toast(
                __($this->toastMessages . '.added'),
                'success',
            );
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

        $this->toast(
            __($this->toastMessages . '.deleted'),
            'success',
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
