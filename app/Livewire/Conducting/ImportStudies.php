<?php

namespace App\Livewire\Conducting\ImportStudies;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Project as ProjectModel;
use App\Models\ImportStudy as ImportStudyModel;
use App\Utils\ActivityLogHelper as Log;
use App\Utils\ToastHelper;

class ImportStudies extends Component
{
    use WithFileUploads;

    public $currentProject;
    public $databases = [];
    public $selectedDatabase;
    public $file;
    public $conducting = [];

    /**
     * Validation rules.
     */
    protected $rules = [
        'selectedDatabase' => 'required|exists:databases,id',
        'file' => 'required|file|mimes:bib,csv|max:10240', // 10MB max
    ];

    /**
     * Custom error messages for the validation rules.
     */
    protected $messages = [
        'selectedDatabase.required' => 'The database field is required.',
        'file.required' => 'The file field is required.',
        'file.mimes' => 'The file must be a type of: bib, csv.',
        'file.max' => 'The file size must not exceed 10MB.',
    ];

    /**
     * Executed when the component is mounted.
     */
    public function mount()
    {
        $projectId = request()->segment(2);
        $this->currentProject = ProjectModel::findOrFail($projectId);
        $this->databases = $this->currentProject->databases;
        $this->conducting = ImportStudyModel::where('project_id', $this->currentProject->id_project)->get();
    }

    /**
     * Reset the fields to the default values.
     */
    public function resetFields()
    {
        $this->selectedDatabase = '';
        $this->file = null;
    }

    /**
     * Update the studies list.
     */
    public function updateImportStudies()
    {
        $this->conducting = ImportStudyModel::where('project_id', $this->currentProject->id_project)->get();
    }

    /**
     * Dispatch a toast message to the view.
     */
    public function toast(string $message, string $type)
    {
        $this->dispatch('import-studies', ToastHelper::dispatch($type, $message));
    }

    /**
     * Handle file upload and import studies.
     */
    public function import()
    {
        $this->validate();

        try {
            $filePath = $this->file->store('uploads');

            // Process the file and import studies
            // This is a placeholder, replace with actual import logic
            $importedStudiesCount = 0;
            $failedImportsCount = 0;

            // Log the import activity
            Log::logActivity(
                action: 'Imported studies',
                description: "Imported {$importedStudiesCount} studies, failed to import {$failedImportsCount} studies.",
                projectId: $this->currentProject->id_project
            );

            $this->updateStudies();
            $this->toast(
                message: "Successfully imported {$importedStudiesCount} studies. Failed to import {$failedImportsCount} studies.",
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
     * Delete a study.
     */
    public function delete(int $studyId)
    {
        try {
            $conducting = ImportStudyModel::findOrFail($studyId);
            $conducting->delete();

            Log::logActivity(
                action: 'Deleted a study',
                description: "Deleted study with ID: {$studyId}",
                projectId: $this->currentProject->id_project
            );

            $this->toast(
                message: 'Study deleted successfully.',
                type: 'success'
            );
            $this->updateStudies();
        } catch (\Exception $e) {
            $this->toast(
                message: $e->getMessage(),
                type: 'error'
            );
        }
    }

    /**
     * Render the component.
     */
    public function render()
    {
        return view('livewire.conducting.import-studies')
            ->extends('layouts.app')
            ->with([ //o método está passando dados adicionais para a view.
                'databases' => $this->databases,
                'importstudies' => $this->importstudies,
            ]);
    }
}
