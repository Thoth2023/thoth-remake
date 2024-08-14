<?php

namespace App\Livewire\Conducting;

use App\Rules\ValidBibFile;
use App\Utils\ToastHelper;
use App\Utils\ActivityLogHelper as Log;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\BibUpload;
use App\Models\Project as ProjectModel;
use App\Models\ProjectDatabases as ProjectDatabasesModel;
use Illuminate\Support\Facades\Storage;

use RenanBr\BibTexParser\Exception\ParserException;
use RenanBr\BibTexParser\Listener;
use RenanBr\BibTexParser\Parser;

class FileUpload extends Component
{
    use WithFileUploads;

    private $translationPath = 'project/conducting.import-studies.livewire';
    private $toastMessages = 'project/conducting.import-studies.livewire.toasts';

    public $currentProject;
    public $databases = [];
    public $selectedDatabase = ['value' => ''];
    public $file;


    protected function messages()
    {
        return [
            'selectedDatabase.value.required' => __($this->translationPath . '.selectedDatabase.value.required'),
            'selectedDatabase.value.exists' => __($this->translationPath . '.selectedDatabase.value.exists'),
            'file.required' => __($this->translationPath . '.file.required'),
            'file.mimes' => __($this->translationPath . '.file.mimes'),
            'file.max' => __($this->translationPath . '.file.max'),
        ];
    }

    protected function rules(): array
    {
        return [
            'selectedDatabase.value' => 'required|exists:project_databases,id_database',
            'file' => ['required', 'file', 'max:10240', new ValidBibFile()],
        ];
    }

    public function toast(string $message, string $type)
    {
        $this->dispatch('file-upload', ToastHelper::dispatch($type, $message));
    }

    public function mount()
    {
        $projectId = request()->segment(2);
        $this->currentProject = ProjectModel::findOrFail($projectId);
        $this->databases = $this->currentProject->databases;
    }

    public function resetFields()
    {
        $this->selectedDatabase['value'] = null;
        $this->file = null;
    }

    /**
     * @throws ParserException
     */
    public function save()
    {
        $this->validate();

        $originalName = pathinfo($this->file->getClientOriginalName(), PATHINFO_FILENAME);
        $cleanName = str_replace(' ', '_', $originalName);
        $extension = $this->file->getClientOriginalExtension();
        $name = $cleanName . '.' . $extension;

        $projectDatabase = ProjectDatabasesModel::where('id_project', $this->currentProject->id_project)
            ->where('id_database', $this->selectedDatabase['value'])
            ->first();

        if ($projectDatabase) {
            $id_project_database = $projectDatabase->id_project_database;

            try {
                $this->file->storeAs('files', $name);

                $bibUpload = BibUpload::create([
                    'name' => $name,
                    'id_project_database' => $id_project_database,
                ]);

                $id_project = $this->currentProject->id_project;
                $database = $this->selectedDatabase['value'];
                $filePath = storage_path('app/files/' . $name);

                $papers = in_array($extension, ['bib', 'txt']) ? $this->extractBibTexReferences($filePath) : $this->extractCsvReferences($filePath);

                $papersInserted = $bibUpload->importPapers($papers, $database, $id_project);

                Log::logActivity(
                    action: __('project/conducting.import-studies.livewire.logs.database_associated_papers_imported'),
                    description: "$name - $papersInserted papers inserted",
                    projectId: $this->currentProject->id_project,
                );

                $toastMessage = __($this->toastMessages . '.file_uploaded_success', ['count' => $papersInserted]);
                $this->toast(
                    message: $toastMessage,
                    type: 'success'
                );


                $this->resetFields();

                $this->dispatch('refreshPapers');
                $this->dispatch('refreshPapersCount');

            } catch (\Exception $e) {
                $errorMessage = method_exists($e, 'getMessage') ? $e->getMessage() : 'Unknown error';

                $toastMessage = __($this->toastMessages . '.file_upload_error', ['message' => $errorMessage]);
                $this->toast(
                    message: $toastMessage,
                    type: 'error'
                );
            }

        } else {
            $toastMessage = __($this->toastMessages . '.project_database_not_found');
            $this->toast(
                message: $toastMessage,
                type: 'error'
            );
        }
    }

    /**
     * @throws ParserException
     */
    private function extractBibTexReferences($filePath)
    {
        $contents = file_get_contents($filePath);
        $parser = new Parser();
        $listener = new Listener();
        $parser->addListener($listener);
        $parser->parseString($contents);

        return $listener->export();
    }

    private function extractCsvReferences($filePath)
    {
        $csv = array_map('str_getcsv', file($filePath));
        $header = array_shift($csv);
        $papers = [];

        foreach ($csv as $row) {
            if (count($row) === count($header)) {
                $csvRow = array_combine($header, $row);
                $mappedRow = $this->mapCsvFields($csvRow);
                $papers[] = $mappedRow;
            }
        }

        return $papers;
    }

    private function mapCsvFields($csvRow)
    {
        return [
            'type' => $csvRow['Content Type'] ?? '',
            'citation-key' => '',
            'title' => $csvRow['Item Title'] ?? '',
            'author' => $csvRow['Authors'] ?? '',
            'booktitle' => $csvRow['Book Series Title'] ?? '',
            'volume' => $csvRow['Journal Volume'] ?? '',
            'pages' => '',
            'numpages' => '',
            'abstract' => '',
            'keywords' => '',
            'doi' => $csvRow['Item DOI'] ?? '',
            'journal' => $csvRow['Publication Title'] ?? '',
            'issn' => '',
            'location' => '',
            'isbn' => '',
            'address' => '',
            'url' => $csvRow['URL'] ?? '',
            'publisher' => '',
            'year' => $csvRow['Publication Year'] ?? '',
        ];
    }

    public function deleteFile($id)
    {
        $file = BibUpload::findOrFail($id);

        try {
            DB::transaction(function () use ($file) {
                $deletedPapersCount = $file->deleteAssociatedPapers();

                Storage::delete('files/' . $file->name);

                $file->delete();

                Log::logActivity(
                    action: __('project/conducting.import-studies.livewire.logs.deleted_file_and_papers', ['count' => $deletedPapersCount]),
                    description: $file->name,
                    projectId: $this->currentProject->id_project,
                );

                $toastMessage = __($this->toastMessages . '.file_deleted_success', ['count' => $deletedPapersCount]);
                $this->toast(
                    message: $toastMessage,
                    type: 'success'
                );

                $this->dispatch('refreshPapers');

            });
        } catch (\Exception $e) {
            $toastMessage = __($this->toastMessages . '.file_delete_error', ['message' => $e->getMessage()]);
            $this->toast(
                message: $toastMessage,
                type: 'error'
            );

            $this->dispatch('refreshPapers');
        }
    }

    public function render()
    {
        return view('livewire.conducting.file-upload', [
            'files' => BibUpload::all(),
        ]);
    }
}
