<?php

namespace App\Livewire\Planning\SearchString;

use Livewire\Component;
use Illuminate\Validation\Rule;
use App\Models\Project as ProjectModel;
use App\Models\SearchString as SearchStringModel;
use App\Utils\ActivityLogHelper as Log;
use App\Utils\ToastHelper;

class SearchString extends Component
{
    private $toastMessages = 'project/planning.search-string.livewire.toasts';
    public $currentProject;
    public $currentSearchString;
    public $strings = [];
    public $description;
    public $searchStringId;

    public $databases = [];

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
            'description' => 'required|string|max:255',
        ];
    }

    /**
     * Custom translation messages for the validation rules.
     */
    public function translate()
    {
        $toasts = 'project/planning.search-string.livewire.toasts';

        return [
            'updated' => __($toasts . '.updated'),
            'added' => __($toasts . '.added'),
            'deleted' => __($toasts . '.deleted'),
        ];
    }

    /**
     * Custom error messages for the validation rules.
     */
    protected function messages()
    {
        $tpath = 'project/planning.search-string.livewire';

        return [
            'description.required' => __($tpath . '.description.required'),
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
        $this->currentSearchString = null;
        foreach ($this->currentProject->databases as $database) {
            $this->databases[$database->id] = ''; // Initialize with empty string or fetch existing value
        }
    }

    /**
     * Reset the fields to the default values.
     */
    public function resetFields()
    {
        $this->description = '';
        $this->currentSearchString = null;
        $this->form['isEditing'] = false;
    }

    /**
     * Update the items.
     */
    public function updateSearchStrings()
    {
        $this->strings = SearchStringModel::where(
            'id_project',
            $this->currentProject->id_project
        )->get();
    }

    public function teste()
    {
        dd("oi");
    }

    /**
     * Dispatch a toast message to the view.
     */
    public function toast(string $message, string $type)
    {
        $this->dispatch('search-string', ToastHelper::dispatch($type, $message));
    }

    /**
     * Submit the form. It validates the input fields
     * and creates or updates an item.
     */
    public function saveSearchString($description)
    {

    }

    /**
     * Fill the form fields with the given data.
     */
    public function edit(string $searchStringId)
    {
        $this->currentSearchString = SearchStringModel::findOrFail($searchStringId);
        $this->description = $this->currentSearchString->description;
    }

    /**
     * Delete an item.
     */
    public function delete(string $searchStringId)
    {
        try {
            $currentSearchString = SearchStringModel::findOrFail($searchStringId);
            $currentSearchString->delete();
            Log::logActivity(
                action: 'Deleted the search string',
                description: $currentSearchString->description,
                projectId: $this->currentProject->id_project
            );

            $this->toast(
                message: $this->translate()['deleted'],
                type: 'success'
            );
            $this->updateSearchStrings();
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

        return view('livewire.planning.search-string.search-string')
            ->with(compact('project'));
    }
}
