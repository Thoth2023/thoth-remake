<?php

namespace App\Livewire\Planning\SearchString;

use Livewire\Component;
use Illuminate\Validation\Rule;
use App\Utils\AlgoliaSynonyms;
use App\Models\Project as ProjectModel;
use App\Models\Term as SearchTermModel;
use App\Models\Synonym as SynonymModel;
use App\Utils\ActivityLogHelper as Log;
use App\Utils\ToastHelper;
use Illuminate\Support\Facades\Http;
use App\Traits\ProjectPermissions;

class SearchTerm extends Component
{

    use ProjectPermissions;

    private $translationPath = 'project/planning.search-string.term.livewire';
    private $toastMessages = 'project/planning.search-string.term.livewire.toasts';

    public $currentProject;
    public $currentTerm;
    public $currentSynonym;
    public $terms = [];
    public $synonymSuggestions = [];

    /**
     * Fields to be filled by the form.
     */
    public $description;
    public $termId;
    public $synonym;

    public $api;
    public $synonyms = [];
    public $loading = false;
    public $languageSynonyms;

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
        'description' => 'required|string|regex:/^[\pL\pN\s\.,;:\?"\'\(\)\[\]\{\}\/\\\\_\-+=#@!%&*]+$/u|max:255',
        'synonym' => 'nullable|string|regex:/^[\pL\pN\s\.,;:\?"\'\(\)\[\]\{\}\/\\\\_\-+=#@!%&*]+$/u|max:255',
    ];

    /**
     * Custom error messages for the validation rules.
     */
    protected function messages()
    {
        return [
            'description.required' => __('O campo descrição é obrigatório.'),
            'description.regex' => __('A descrição deve conter apenas letras e espaços.'),
            'description.max' => __('A descrição não pode ter mais de 255 caracteres.'),
            'synonym.regex' => __('O sinônimo deve conter apenas letras e espaços.'),
            'synonym.max' => __('O sinônimo não pode ter mais de 255 caracteres.'),
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

        $this->currentTerm = null;
        $this->terms = SearchTermModel::where(
            'id_project',
            $this->currentProject->id_project
        )->get();
        $this->languageSynonyms['value'] = 'en';
    }

    /**
     * Reset the fields to the default values.
     */
    public function resetFields()
    {
        $this->currentSynonym = null;
        $this->currentTerm = null;
        $this->synonym = '';
        $this->description = '';
        $this->form['isEditing'] = false;
    }

    /**
     * Update the items.
     */
    public function updateTerms()
    {
        $this->terms = SearchTermModel::where(
            'id_project',
            $this->currentProject->id_project
        )->get();
    }

    /**
     * Dispatch a toast message to the view.
     */
    public function toast(string $message, string $type)
    {
        $this->dispatch('terms', ToastHelper::dispatch($type, $message));
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

        $updateIf = [
            'id_term' => $this->currentTerm?->id_term,
        ];

        try {
            $value = $this->form['isEditing'] ? 'Updated the term' : 'Added a term';
            $toastMessage = __($this->toastMessages . ($this->form['isEditing']
                ? '.updated' : '.added'));

            $updatedOrCreated = SearchTermModel::updateOrCreate($updateIf, [
                'id_project' => $this->currentProject->id_project,
                'description' => $this->description,
            ]);

            Log::logActivity(
                action: $value,
                description: $updatedOrCreated->description,
                projectId: $this->currentProject->id_project
            );

            $this->updateTerms();
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
    public function edit(string $termId)
    {

        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        $this->currentTerm = SearchTermModel::findOrFail($termId);
        $this->description = $this->currentTerm->description;
        $this->form['isEditing'] = true;
    }

    public function populateSuggestionsSynonyms($value)
    {
        $this->synonym = $value;
    }

    /**
     * Delete an item.
     */
    public function delete(string $termId)
    {

        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        try {
            $currentTerm = SearchTermModel::findOrFail($termId);
            $currentTerm->delete();

            Log::logActivity(
                action: 'Deleted the term',
                description: $currentTerm->description,
                projectId: $this->currentProject->id_project
            );

            $this->toast(
                message: __($this->toastMessages . '.deleted'),
                type: 'success'
            );
            $this->updateTerms();
        } catch (\Exception $e) {
            $this->toast(
                message: $e->getMessage(),
                type: 'error'
            );
        } finally {
            $this->resetFields();
        }
    }

    public function addSynonyms()
    {
        $this->validateOnly('synonym');

        if (empty($this->termId['value'])) {
            $this->toast(
                message: __('project/planning.search-string.term.livewire.toasts.validation'),
                type: 'error'
            );
            return;
        }

        if (empty($this->synonym)) {
            $this->toast(
                message: __('project/planning.search-string.term.livewire.toasts.synonym'),
                type: 'error'
            );
            return;
        }

        $updateIf = [
            'id_synonym' => $this->currentSynonym?->id_synonym,
        ];

        try {
            $value = $this->form['isEditing'] ? 'Updated the synonym' : 'Added a synonym';
            $toastMessage = __($this->toastMessages . ($this->form['isEditing']
                ? '.updated' : '.added'));

            $created = SynonymModel::updateOrCreate($updateIf, [
                'id_term' => $this->termId['value'],
                'description' => $this->synonym,
            ]);

            Log::logActivity(
                action: $value,
                description: $created->description,
                projectId: $this->currentProject->id_project
            );

            $this->updateTerms();
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
    public function editSynonym($termId)
    {

        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        $this->currentSynonym = SynonymModel::findOrFail($termId);
        $this->currentTerm = SearchTermModel::findOrFail($this->currentSynonym->id_term)->first();
        $this->synonym = $this->currentSynonym->description;
        $this->termId['value'] = $this->currentSynonym->id_term;
        $this->form['isEditing'] = true;
    }

    /**
     * Delete a synonym.
     */
    public function deleteSynonym(string $termId)
    {

        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        try {
            $currentSynonym = SynonymModel::findOrFail($termId);
            $currentSynonym->delete();

            Log::logActivity(
                action: 'Deleted the synonym',
                description: $currentSynonym->description,
                projectId: $this->currentProject->id_project
            );

            $this->toast(
                message: __($this->toastMessages . '.deleted'),
                type: 'success'
            );
            $this->updateTerms();
        } catch (\Exception $e) {
            $this->toast(
                message: $e->getMessage(),
                type: 'error'
            );
        } finally {
            $this->resetFields();
        }
    }

    public function getSynonymSuggestions($termId)
    {
        $indexFolder = $this->languageSynonyms['value'] == 'en' ? 'synonyms' : 'sinonimos';

        $this->synonymSuggestions = [];
        $term = SearchTermModel::where('id_term', $termId)->first();
        $algolia = new AlgoliaSynonyms();
        $results = $algolia->searchSynonyms($term->description, $indexFolder);

        $this->synonymSuggestions = $results ?? [];
    }

    public function generateSynonyms()
    {
        if (($this->termId['value'] ?? null)) {
            $this->getSynonymSuggestions($this->termId['value']);
        }
    }

    public function addSuggestionSynonym($value)
    {
        $this->currentSynonym = null;
        $this->currentTerm = null;
        $this->synonym = $value;
        $this->addSynonyms();
    }

    /**
     * Render the component.
     */
    public function render()
    {
        $project = $this->currentProject;
        $synonymSuggestions = $this->synonymSuggestions;

        return view(
            'livewire.planning.search-string.search-term',
            compact(
                'project',
                'synonymSuggestions'
            )
        )->extends('layouts.app');
    }
}
