<?php

namespace App\Livewire\Planning\SearchString;

use App\Models\ProjectDatabases;
use Livewire\Component;
use Illuminate\Validation\Rule;
use App\Models\Project as ProjectModel;
use App\Models\SearchString as SearchStringModel;
use App\Models\Term;
use App\Utils\ActivityLogHelper as Log;
use App\Utils\ToastHelper;
use App\Models\ProjectDatabase;

class SearchString extends Component
{
    // caminho para as mensagens de toast
    private $toastMessages = 'project/planning.search-string.livewire.toasts';

    // Projeto atual
    public $currentProject;

    // String de busca atual
    public $currentSearchString;

    // Todas as strings de busca do projeto
    public $strings = [];

    // Descrição genérica da string de busca
    public $genericDescription;

    // ID da string de busca atual
    public $searchStringId;

    // Lista de bases de dados
    public $databases = [];

    // Lista de descrições por base de dados
    public $descriptions = [];

    // Descrição da string de busca atual
    public $description;

    // Lista de termos do projeto
    public $terms;

    /**
     * Estado do formulário.
     */
    public $form = [
        'isEditing' => false,
    ];

    /**
     * Regras de validação dos campos do formulário.
     */
    protected function rules()
    {
        return [
            'currentProject' => 'required',
            'description' => 'required|string|max:255',
        ];
    }

    /**
     * Mensagens traduzidas personalizadas para os toasts.
     */
    public function translate()
    {
        $toasts = 'project/planning.search-string.livewire.toasts';

        return [
            'updated-string' => __($toasts . '.updated-search-string'),
            'generated' => __($toasts . '.generated'),
            'updated' => __($toasts . '.updated'),
        ];
    }

    /**
     * Mensagens personalizadas de erro de validação.
     */
    protected function messages()
    {
        $tpath = 'project/planning.search-string.livewire';

        return [
            'description.required' => __($tpath . '.description.required'),
        ];
    }

    /**
     * Listeners que atualizam as bases de dados em tempo real.
     */
    protected $listeners = ['databaseAdded' => 'refreshDatabases', 'databaseDeleted' => 'refreshDatabases'];

    /**
     * Método executado ao montar o componente.
     * Busca o projeto atual e carrega os dados associados.
     */
    public function mount()
    {
        $projectId = request()->segment(2); // Obtém ID do projeto da URL
        $this->currentProject = ProjectModel::findOrFail($projectId);
        $this->currentSearchString = null;

        // Carrega bases de dados e strings existentes
        $this->loadProjectDatabases();

        // Busca as strings de busca associadas às bases
        $projectDatabases = ProjectDatabases::where([
            'id_project' => $this->currentProject->id_project
        ])->get();

        $this->genericDescription = $this->currentProject->generic_search_string;

        // Popula as descrições por índice de base
        foreach ($projectDatabases as $index => $database) {
            $this->descriptions[$index] = $database->search_string;
        }
    }

    /**
     * Limpa os campos do formulário.
     */
    public function resetFields()
    {
        $this->genericDescription = '';
        $this->currentSearchString = null;
        $this->form['isEditing'] = false;
    }

    /**
     * Atualiza a lista de strings de busca do projeto.
     */
    public function updateSearchStrings()
    {
        $this->strings = SearchStringModel::where(
            'id_project',
            $this->currentProject->id_project
        )->get();
    }

    /**
     * Carrega as bases de dados do projeto e suas descrições.
     */
    public function loadProjectDatabases()
    {
        $projectDatabases = ProjectDatabases::where('id_project', $this->currentProject->id_project)->get();
        $this->genericDescription = $this->currentProject->generic_search_string;

        foreach ($projectDatabases as $index => $database) {
            $this->descriptions[$index] = $database->search_string;
        }
    }

    /**
     * Atualiza as descrições ao receber eventos de adição ou remoção de bases.
     */
    public function refreshDatabases($projectId)
    {
        if ($this->currentProject->id_project == $projectId) {
            $this->loadProjectDatabases();
        }
    }

    /**
     * Exibe um toast na interface com base em tipo e mensagem.
     */
    public function toast(string $message, string $type)
    {
        $this->dispatch('search-string', ToastHelper::dispatch($type, $message));
    }

    /**
     * Preenche os campos para edição de uma string de busca.
     */
    public function edit(string $searchStringId)
    {
        $this->currentSearchString = SearchStringModel::findOrFail($searchStringId);
        $this->description = $this->currentSearchString->description;
    }

    /**
     * Exclui uma string de busca e registra a atividade.
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
     * Gera uma string de busca genérica baseada nos termos e sinônimos.
     */
    public function generateGenericSearchString()
    {
        $this->terms = Term::where('id_project', $this->currentProject->id_project)
            ->with('synonyms')
            ->get();

        $formattedTerms = $this->terms->map(function ($term) {
            $allTerms = array_merge([$term->description], $term->synonyms->pluck('description')->toArray());
            return '("' . implode('" OR "', $allTerms) . '")';
        });

        $this->genericDescription = implode(' AND ', $formattedTerms->toArray());
        return $this->genericDescription;
    }

    /**
     * Gera a string de busca formatada para uma base de dados específica.
     */
    public function generateSearchString($databaseName)
    {
        $this->terms = Term::where('id_project', $this->currentProject->id_project)
            ->with('synonyms')
            ->get();

        $formattedTerms = $this->terms->map(function ($term) {
            $allTerms = array_merge([$term->description], $term->synonyms->pluck('description')->toArray());
            return '("' . implode('" OR "', $allTerms) . '")';
        });

        // Formata de acordo com o banco de dados selecionado
        switch (strtoupper($databaseName)) {
            case 'SCOPUS':
                $searchString = "TITLE-ABS-KEY " . implode(' AND ', $formattedTerms->toArray());
                break;
            case 'ENGINEERING VILLAGE':
                $searchString = "( " . implode(' AND ', $formattedTerms->toArray()) . " AND ({english} WN LA) )";
                break;
            default:
                $searchString = $this->generateGenericSearchString();
                break;
        }

        $this->saveGenericSearchString();
        return $searchString;
    }

    /**
     * Formata e atualiza a descrição da string de busca para um índice de base.
     */
    public function formatSearchStringByDatabase($index, $name)
    {
        $this->terms = Term::where('id_project', $this->currentProject->id_project)
            ->with('synonyms')
            ->get();

        $generatedString = $this->generateSearchString($name);
        $this->descriptions[$index] = $generatedString;
    }

    /**
     * Gera todas as strings de busca para todas as bases do projeto.
     */
    public function generateAllSearchStrings()
    {
        foreach ($this->currentProject->databases as $index => $database) {
            $this->formatSearchStringByDatabase($index, $database->name);
            $this->saveSearchString($database->id_database, $index);
        }

        $this->generateGenericSearchString();
        $this->saveGenericSearchString();

        $this->toast(
            message: __($this->toastMessages . '.generated'),
            type: 'success'
        );
    }

    /**
     * Salva a string de busca genérica no projeto.
     */
    public function saveGenericSearchString()
    {
        $this->currentProject->update(['generic_search_string' => $this->genericDescription]);

        $this->toast(
            message: __($this->toastMessages . '.updated-string'),
            type: 'success'
        );
    }

    /**
     * Salva a string de busca individual de uma base.
     */
    public function saveSearchString($id_database, $index)
    {
        ProjectDatabase::where('id_project', $this->currentProject->id_project)
            ->where('id_database', $id_database)
            ->update(['search_string' => $this->descriptions[$index]]);

        $this->toast(
            message: __($this->toastMessages . '.updated-string'),
            type: 'success'
        );
    }

    /**
     * Renderiza a view associada ao componente Livewire.
     */
    public function render()
    {
        $project = $this->currentProject;

        return view('livewire.planning.search-string.search-string')
            ->with(compact('project'));
    }
}
