<?php

namespace App\Livewire\Conducting;

use App\Utils\ToastHelper;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Project as ProjectModel;
use App\Models\ImportStudy as ImportStudyModel;
use App\Models\ProjectDatabase as ProjectDatabaseModel;
use App\Utils\ActivityLogHelper as Log;
use RenanBr\BibTexParser\Listener;
use RenanBr\BibTexParser\Parser;

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
        'selectedDatabase' => 'required|exists:project_databases,id',
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
        $this->studies = ImportStudyModel::where('id_project', $this->currentProject->id_project)->get();
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

        if (!$this->file) {
            $this->toast(
                message: 'No file uploaded.',
                type: 'error'
            );
            return;
        }

        try {
            $filePath = $this->file->store('uploads');

            // Lógica real de processamento de arquivos (talvez precise atualizar) -> chama a função de processamento de arquivo.
            $importedStudiesCount = $this->processFile($filePath);
            $failedImportsCount = 0;

            // Log the import activity
            Log::logActivity(
                action: 'Imported studies',
                description: "Imported {$importedStudiesCount} studies, failed to import {$failedImportsCount} studies.",
                projectId: $this->currentProject->id_project
            );

            $this->updateImportStudies();
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

        // Determine o tipo de arquivo pelo seu formato
        $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);

        if ($fileExtension === 'csv') {
            // Processamento de arquivos CSV
            if (($handle = fopen(storage_path('app/' . $filePath), 'r')) !== false) {
                $headers = fgetcsv($handle, 1000, ',');

                while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                    $studyData = array_combine($headers, $data);

                    ImportStudyModel::create([ // cria um novo registro no banco de dados usando o modelo
                        'project_id' => $this->currentProject->id_project,
                        'database_id' => $this->selectedDatabase,
                        'title' => $studyData['title'] ?? null,
                        'author' => $studyData['author'] ?? null,
                        'year' => $studyData['year'] ?? null,
                    ]);

                    $importedStudiesCount++;
                }

                fclose($handle);
            }
        } elseif ($fileExtension === 'bib') {
            // Processamento de arquivos BIB
            $parser = new Parser();
            $listener = new Listener();

            $parser->addListener($listener);
            $parser->parseFile(storage_path('app/' . $filePath));

            foreach ($listener->export() as $entry) {
                ImportStudyModel::create([
                    'project_id' => $this->currentProject->id_project,
                    'database_id' => $this->selectedDatabase,
                    'title' => $entry['title'] ?? null,
                    'author' => $entry['author'] ?? null,
                    'year' => $entry['year'] ?? null,
                ]);

                $importedStudiesCount++;
            }
        }

        return $importedStudiesCount;
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
            $this->updateImportStudies();
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
        $project = $this->currentProject;

        return view(
            'livewire.conducting.import-studies',
            compact(
                'project',
            )
        );
    }
}
