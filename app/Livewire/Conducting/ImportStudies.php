<?php

namespace App\Livewire\Conducting;

use App\Utils\ToastHelper;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Project as ProjectModel;
use App\Models\ImportStudy as ImportStudyModel;
use App\Models\Paper;
use App\Models\ProjectDatabase as ProjectDatabaseModel;
use App\Utils\ActivityLogHelper as Log;
use RenanBr\BibTexParser\Listener;
use RenanBr\BibTexParser\Parser;

class ImportStudies extends Component
{
    use WithFileUploads;

    public $currentProject;
    public $databases = [];
    public $selectedDatabase = '';
    public $file;
    public $studies = [];
    public $failedImportsCount = 0;



    /**
     * Validation rules.
     */
    protected $rules = [
        'selectedDatabase' => 'required|exists:project_databases,id_database',
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
        $this->studies = $this->byProjectId($projectId);
        // $this->studies = ImportStudyModel::where('id_project', $this->currentProject->id_project)->get();
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
        $this->studies = $this->byProjectId($this->currentProject->id_project);
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

        try {
            if (!$this->file) {
                $this->toast('No file uploaded.', 'error');
                return;
            }

            $filePath = $this->file->store('public/files');
            $this->toast('File uploaded successfully.', 'success');

            $importedStudiesCount = $this->processFile($filePath);
            $failedImportsCount = $this->failedImportsCount;

            Log::logActivity(
                'Imported studies',
                "Imported {$importedStudiesCount} studies, failed to import {$failedImportsCount} studies.",
                $this->currentProject->id_project
            );

            $this->updateImportStudies();
            $this->toast("Successfully imported {$importedStudiesCount} studies. Failed to import {$failedImportsCount} studies.", 'success');
        } catch (\Exception $e) {
            $this->toast($e->getMessage(), 'error');
        } finally {
            $this->resetFields();
        }
    }



    protected function findImportedStudies(){

     return ImportStudyModel::where('id_database', $this->selectedDatabase)->orderBy('created_at', 'desec')->first();

    }

    protected function byProjectId($idProject){

        return ImportStudyModel::where('id_project', $idProject)->orderBy('created_at', 'desc')->first();

       }

    protected function findFailedImports(){

        return ImportStudyModel::where('id_database', $this->selectedDatabase)->orderBy('created_at', 'desc')->first()->failed_imports;

       }

    protected function findDescription($idProject){

        return ImportStudyModel::where('id_project', $idProject)->orderBy('created_at', 'desc')->first()->description;

       }

    /**
     * Para o processamento de arquivos.
     */
    protected function processFile($filePath)
    {
        $importedStudiesCount = 0;
        $failedImportsCount = 0;
        $abstract = '';
        $importedStudiesFind = $this->findImportedStudies();
        $failedImportsFind = $this->findFailedImports();
        $descriptionFind = $this->findDescription($this->currentProject->id_project);

        // Determine o tipo de arquivo pelo seu formato
        $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);

        if ($fileExtension === 'csv') {
            // Processamento de arquivos CSV
            if (($handle = fopen(storage_path('app/' . $filePath), 'r')) !== false) {
                $headers = fgetcsv($handle, 1000, ',');

                while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                    $studyData = array_combine($headers, $data);

                    $paper = Paper::create([
                        'book_title' => $studyData['book_title'] ?? '',
                        'author' => $studyData['author'] ?? '',
                        'year' => $studyData['year'] ?? '',
                        'abstract' => $studyData['abstract'] ?? $abstract,
                        'volume' => $studyData['volume'] ?? 0,
                        'pages' => $studyData['pages'] ?? 0,
                        'num_pages' => $studyData['num_pages'] ?? 0,
                        'keywords' => $studyData['keywords'] ?? '',
                        'doi' => $studyData['doi'] ?? '',
                        'journal' => $studyData['journal'] ?? '',
                        'issn' => $studyData['issn']?? '',
                        'location' => $studyData['location'] ?? '',
                        'isbn' => $studyData['isbn'] ?? '',
                        'address' => $studyData['address'] ?? '',
                        'type' => $studyData['type'] ?? '',
                        'bib_key' => $studyData['bib_key'] ?? '',
                        'url' => $studyData['url'] ?? '',
                        'publisher' => $studyData['publisher'] ?? '',
                        'added_at' => $studyData['added_at'] ?? '',
                        'update_at' => $studyData['update_at'] ?? '',
                        'data_base' => $studyData['data_base'] ?? 0,
                        'id' => $studyData['id'] ?? 0,
                        'status_selection' => $studyData['status_selection'] ?? 0,
                        'check_status_selection' => $studyData['check_status_selection'] ?? 0,
                        'status_qa' => $studyData['status_qa'] ?? 0,
                        'id_gen_score' => $studyData['id_gen_score'] ?? 0,
                        'check_qa' => $studyData['check_qa'] ?? 0,
                        'score' => $studyData['score'] ?? '',
                        'status_extraction' => $studyData['status_extraction'] ?? 0,
                        'note' => $studyData['note'] ?? '',

                    ]);

                    if ($paper) {
                        $importedStudiesCount++;
                    } else {
                        $failedImportsCount++;
                    }
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
                try {
                    // Cria e salva um novo estudo no banco de dados
                    $paper = Paper::create([
                        'book_title' => $studyData['book_title'] ?? '',
                        'author' => $studyData['author'] ?? '',
                        'year' => $studyData['year'] ?? '',
                        'abstract' => $studyData['abstract'] ?? $abstract,
                        'volume' => $studyData['volume'] ?? 0,
                        'pages' => $studyData['pages'] ?? 0,
                        'num_pages' => $studyData['num_pages'] ?? 0,
                        'keywords' => $studyData['keywords'] ?? '',
                        'doi' => $studyData['doi'] ?? '',
                        'journal' => $studyData['journal'] ?? '',
                        'issn' => $studyData['issn']?? '',
                        'location' => $studyData['location'] ?? '',
                        'isbn' => $studyData['isbn'] ?? '',
                        'address' => $studyData['address'] ?? '',
                        'type' => $studyData['type'] ?? '',
                        'bib_key' => $studyData['bib_key'] ?? '',
                        'url' => $studyData['url'] ?? '',
                        'publisher' => $studyData['publisher'] ?? '',
                        'added_at' => $studyData['added_at'] ?? '',
                        'update_at' => $studyData['update_at'] ?? '',
                        'data_base' => $studyData['data_base'] ?? 0,
                        'id' => $studyData['id'] ?? 0,
                        'status_selection' => $studyData['status_selection'] ?? 0,
                        'check_status_selection' => $studyData['check_status_selection'] ?? 0,
                        'status_qa' => $studyData['status_qa'] ?? 0,
                        'id_gen_score' => $studyData['id_gen_score'] ?? 0,
                        'check_qa' => $studyData['check_qa'] ?? 0,
                        'score' => $studyData['score'] ?? '',
                        'status_extraction' => $studyData['status_extraction'] ?? 0,
                        'note' => $studyData['note'] ?? '',

                    ]);

                    if ($paper) {
                        $importedStudiesCount++;
                    } else {
                        $failedImportsCount++;
                    }
                } catch (\Exception $e) {
                    $failedImportsCount++;
                }
            }

            ImportStudyModel::create([
                'id_project' => $this->currentProject->id_project,
                'id_database' => $this->selectedDatabase,
                'description' => $descriptionFind,
                'failed_imports' => $failedImportsCount,
                'file_path' => $filePath,
            ]);
        }

        // Retorna o número de estudos importados com sucesso
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
