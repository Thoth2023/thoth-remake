<?php

namespace App\Livewire\Conducting;

use App\Utils\ToastHelper;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Project as ProjectModel;
use App\Models\ImportStudy as ImportStudyModel;
use App\Models\ProjectDatabase as ProjectDatabaseModel;
use App\Utils\ActivityLogHelper as Log;


class ImportStudies extends Component
{

    use WithFileUploads;

    public $currentProject;
    public $databases = [];
    public $selectedDatabase;
    public $file;
    public $studies = [];

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
        $this->studies = ImportStudyModel::where('id_project', $this->currentProject->id_project )->get();
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
        $this->studies = ImportStudyModel::where('project_id', $this->currentProject->id_project)->get();
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
        //$this->validate();

        try {
            $filePath = $this->file->store('uploads');

            // Chama a função de processamento de arquivo.
            list($importedStudiesCount, $failedImportsCount) = $this->processFile($filePath);

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
     * Para o processamento de arquivos.
     */
    protected function processFile($filePath)
    {
        $importedStudiesCount = 0;
        $failedImportsCount = 0;

        $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);

        if ($fileExtension === 'csv') {
            $file = fopen(storage_path('app/' . $filePath), 'r');
            while (($data = fgetcsv($file, 1000, ',')) !== FALSE) {
                // Supondo que o CSV tem colunas: title, authors, journal, year
                $importStudy = new ImportStudyModel();
                $importStudy->title = $data[0];
                $importStudy->authors = $data[1];
                $importStudy->journal = $data[2];
                $importStudy->year = $data[3];
                $importStudy->project_id = $this->currentProject->id_project;

                if ($importStudy->save()) {
                    $importedStudiesCount++;
                } else {
                    $failedImportsCount++;
                }
            }
            fclose($file);
        } elseif ($fileExtension === 'bib') {
            // Processar arquivo BIB
            $bibFileContents = file_get_contents(storage_path('app/' . $filePath));
            $bibParser = new \RenanBr\BibTexParser\Parser();
            $listener = new \RenanBr\BibTexParser\Listener();
            $bibParser->addListener($listener);
            $bibParser->parseString($bibFileContents);
            $bibEntries = $listener->export();

            foreach ($bibEntries as $entry) {
                $importStudy = new ImportStudyModel();
                $importStudy->authors = $entry['author'] ?? '';
                $importStudy->title = $entry['title'] ?? '';
                $importStudy->year = $entry['year'] ?? '';
                $importStudy->isbn = $entry['year'] ?? '';
                $importStudy->publisher = $entry['publisher'] ?? '';
                $importStudy->address = $entry['address'] ?? '';
                $importStudy->url = $entry['url'] ?? '';
                $importStudy->doi = $entry['doi'] ?? '';
                $importStudy->abstract = $entry['abstract'] ?? '';
                $importStudy->book_title = $entry['book_title'] ?? '';
                $importStudy->pages = $entry['pages'] ?? '';
                $importStudy->num_pages = $entry['num_pages'] ?? '';
                $importStudy->keywords = $entry['keywords'] ?? '';
                $importStudy->location = $entry['location'] ?? '';
                $importStudy->series = $entry['series'] ?? '';
                $importStudy->project_id = $this->currentProject->id_project;

                if ($importStudy->save()) {
                    $importedStudiesCount++;
                } else {
                    $failedImportsCount++;
                }
            }
        }

        return [$importedStudiesCount, $failedImportsCount];
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
    public function render()
    {
        $project = $this->currentProject;

        return view(
            'livewire.conducting.import-studies',
            compact(
                'project',
            )
            );
    }
}
