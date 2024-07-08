<?php

namespace App\Livewire\Planning\SearchString;

use App\Models\Term;
use Livewire\Component;
use Illuminate\Validation\Rule;
use App\Models\Project as ProjectModel;
use App\Models\Term as SearchTermModel;
use App\Models\Synonym as SynonymModel;
use App\Utils\ActivityLogHelper as Log;
use App\Utils\ToastHelper;
use Illuminate\Support\Facades\Http;

class SearchTerm extends Component
{
    private $translationPath = 'project/planning.search-string.term.livewire';
    private $toastMessages = 'project/planning.search-string.term.livewire.toasts';

    public $currentProject;
    public $currentTerm;
    public $currentSynonym;
    public $terms = [];

    /**
     * Fields to be filled by the form.
     */
    public $description;
    public $termId;
    public $synonym;

    public $api;
    public $synonyms = [];
    public $loading = false;

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
        $this->currentTerm = null;
        $this->terms = SearchTermModel::where(
            'id_project',
            $this->currentProject->id_project
        )->get();
        $this->terms = Term::all();
    }

    /**
     * Reset the fields to the default values.
     */
    public function resetFields()
    {
        $this->synonym = '';
        $this->description = '';
        $this->currentTerm = null;
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
        $this->currentTerm = SearchTermModel::findOrFail($termId);
        $this->description = $this->currentTerm->description;
        $this->form['isEditing'] = true;
    }

    /**
     * Delete an item.
     */
    public function delete(string $termId)
    {
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
        if (!$this->termId || !$this->synonym) {
            $this->addError('termId', 'The term id is required');
        }

        $this->currentTerm = SearchTermModel::findOrFail($this->termId)->first();

        $updateIf = [
            'id_term' => $this->currentTerm?->id_term,
        ];

        try {
            $value = $this->form['isEditing'] ? 'Updated the synonym' : 'Added a synonym';
            $toastMessage = __($this->toastMessages . ($this->form['isEditing']
                ? '.updated' : '.added'));

            $created = SynonymModel::updateOrCreate($updateIf, [
                'id_term' => $this->currentTerm->id_term,
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
        $this->currentSynonym = SynonymModel::findOrFail($termId);
        $this->synonym = $this->currentSynonym->description;
        $this->termId = $this->currentSynonym->id_term;
        $this->form['isEditing'] = true;
    }

    /**
     * Delete a synonym.
     */
    public function deleteSynonym(string $termId)
    {
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

    /**
     * Render the component.
     */
    public function render()
    {
        $project = $this->currentProject;

        return view(
            'livewire.planning.search-string.search-term',
            compact(
                'project',
            )
        )->extends('layouts.app');
    }
}