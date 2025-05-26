<?php

namespace App\Livewire\Conducting;


use App\Jobs\ProcessFileImport;
use App\Rules\ValidBibFile;
use App\Utils\ToastHelper;
use App\Utils\ActivityLogHelper as Log;
use Illuminate\Support\Facades\Log as FacadesLog;
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

use App\Utils\CheckProjectDataPlanning;
use App\Traits\ProjectPermissions;
use App\Traits\LivewireExceptionHandler;

class FileUpload extends Component
{

    use ProjectPermissions;
    use WithFileUploads;
    use LivewireExceptionHandler;

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

        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        try {
            // Validações iniciais
            $this->validate();

            CheckProjectDataPlanning::checkProjectData($this->currentProject->id_project);

            // Preparar o nome do arquivo para salvar
            $originalName = pathinfo($this->file->getClientOriginalName(), PATHINFO_FILENAME);
            $cleanName = str_replace(' ', '_', $originalName);
            $extension = $this->file->getClientOriginalExtension();
            $name = $cleanName . '.' . $extension;
            FacadesLog::info('Preparando o nome do arquivo para salvar.', ['file_name' => $name]);

            // Obter o banco de dados do projeto selecionado
            $projectDatabase = ProjectDatabasesModel::where('id_project', $this->currentProject->id_project)
                ->where('id_database', $this->selectedDatabase['value'])
                ->first();

            if ($projectDatabase) {
                $id_project_database = $projectDatabase->id_project_database;

                // Verificação de duplicidade de nome de arquivo no banco de dados
                $existingFile = BibUpload::where('name', $name)
                    ->where('id_project_database', $id_project_database)
                    ->first();

                if ($existingFile) {
                    FacadesLog::warning('Tentativa de upload de arquivo duplicado.', ['file_name' => $name]);

                    // Notifica o usuário sobre a duplicidade de nome
                    $toastMessage = __($this->toastMessages . '.file_already_exists', ['file_name' => $name]);
                    $this->toast(
                        message: $toastMessage,
                        type: 'error'
                    );
                    return;
                }

                try {
                    // Salvar o arquivo no sistema de arquivos
                    $this->file->storeAs('files', $name);
                    FacadesLog::info('Arquivo salvo no sistema de arquivos com sucesso.', ['file_name' => $name]);

                    // Criar a entrada de BibUpload para o arquivo
                    $bibUpload = BibUpload::create([
                        'name' => $name,
                        'id_project_database' => $id_project_database,
                    ]);
                    $id_bib = $bibUpload->id_bib;
                    FacadesLog::info('Entrada de BibUpload criada com sucesso.', ['id_bib' => $id_bib]);

                    // Definir o caminho do arquivo e verificar o tipo de extensão
                    $filePath = storage_path('app/files/' . $name);
                    $projectId = $this->currentProject->id_project;
                    $database = $this->selectedDatabase['value'];

                    // Processamento Condicional
                    if (in_array($extension, ['bib', 'txt'])) {
                        // Despachar o job para arquivos .bib ou .txt
                        FacadesLog::info('Arquivo .bib ou .txt detectado, despachando o job para processamento.', ['file_path' => $filePath]);
                        dispatch(new ProcessFileImport($filePath, $projectId, $database, $id_bib));

                        // Exibir uma notificação de sucesso para o usuário
                        $toastMessage = __($this->toastMessages . '.file_uploaded_success');
                        $this->toast(
                            message: $toastMessage,
                            type: 'success'
                        );
                    } else {
                        // Processar CSV diretamente
                        FacadesLog::info('Arquivo CSV detectado, iniciando o processamento direto.', ['file_path' => $filePath]);
                        $papers = $this->extractCsvReferences($filePath);
                        $papersInserted = $bibUpload->importPapers($papers, $database, $projectId, $id_bib);

                        // Log de atividade para CSV
                        FacadesLog::info('Importação de estudos CSV concluída.', ['file_name' => $name, 'papers_inserted' => $papersInserted]);

                        Log::logActivity(
                            action: __('project/conducting.import-studies.livewire.logs.database_associated_papers_imported'),
                            description: "$name - $papersInserted papers inserted",
                            projectId: $projectId,
                        );

                        // Exibir uma notificação de sucesso com o número de papers importados
                        $toastMessage = __($this->toastMessages . '.file_uploaded_success', ['count' => $papersInserted]);
                        $this->toast(
                            message: $toastMessage,
                            type: 'success'
                        );
                    }

                    // Resetar os campos do formulário
                    $this->resetFields();
                    FacadesLog::info('Campos do formulário resetados com sucesso.');

                    // Enviar eventos para atualização no front-end
                    $this->dispatch('import-success');
                    $this->dispatch('refreshPapersCount');
                    FacadesLog::info('Eventos de importação e atualização de contagem de papers despachados com sucesso.');

                } catch (\Exception $e) {
                    // Lidar com erros no processo de criação de BibUpload ou despachar job/processamento CSV
                    $errorMessage = $e->getMessage();
                    FacadesLog::error('Erro ao salvar o arquivo ou processar BibUpload.', ['error' => $errorMessage]);
                    $this->handleException($e);
                }

            } else {
                // Mensagem de erro caso o banco de dados do projeto não seja encontrado
                FacadesLog::error('Banco de dados do projeto não encontrado.', ['project_id' => $this->currentProject->id_project]);

                $toastMessage = __($this->toastMessages . '.project_database_not_found');
                $this->toast(
                    message: $toastMessage,
                    type: 'error'
                );
            }
        } catch (\Exception $e) {
            // Captura erro na validação inicial ou verificação de dados
            $errorMessage = $e->getMessage();
            FacadesLog::error('Erro geral ao tentar salvar o arquivo.', ['error' => $errorMessage]);

            $this->handleException($e);
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

        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

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

                //atualizar os demais módulos
                $this->dispatch('import-success');
                $this->dispatch('refreshPapersCount');

            });
        } catch (\Exception $e) {
            $toastMessage = __($this->toastMessages . '.file_delete_error', ['message' => $e->getMessage()]);
            $this->toast(
                message: $toastMessage,
                type: 'error'
            );
        }
    }

    public function render()
    {
        // Verificar Campos necessários cadastrados no Planning
        CheckProjectDataPlanning::checkProjectData($this->currentProject->id_project);

        return view('livewire.conducting.file-upload', [
            'files' => BibUpload::whereHas('projectDatabase', function ($query) {
                $query->where('id_project', $this->currentProject->id_project);
            })->get(),
        ]);
    }
}
