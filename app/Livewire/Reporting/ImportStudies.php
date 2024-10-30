<?php

namespace App\Livewire\Reporting;

use App\Models\Project\Conducting\Papers;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Models\Project as ProjectModel;
use App\Models\ProjectDatabases;

class ImportStudies extends Component
{
    public $currentProject;
    public $databasesWithPaperCount = [];

    /**
     * Executed when the component is mounted.
     */
    public function mount()
    {
        // Obtém o ID do projeto a partir da URL
        $projectId = request()->segment(2);

        // Busca o projeto e lança uma exceção se não for encontrado
        $this->currentProject = ProjectModel::findOrFail($projectId);

        // Carrega as databases e os papers associados
        $this->databasesWithPaperCount = $this->getDatabasesWithPaperCount();
    }

    /**
     * Obtém as databases associadas ao projeto e conta os papers.
     */
    public function getDatabasesWithPaperCount()
    {
        // Pega os databases cadastrados para o projeto corrente na tabela project_databases
        return ProjectDatabases::where('id_project', $this->currentProject->id_project)
            ->join('data_base', 'project_databases.id_database', '=', 'data_base.id_database') // Une com a tabela de data_base
            ->leftJoin('papers', 'papers.data_base', '=', 'project_databases.id_database') // Une com a tabela de papers
            ->select(
                'data_base.name', // Nome da database
                DB::raw('COUNT(papers.id) as papers_count') // Conta os papers por database
            )
            ->groupBy('data_base.name') // Agrupa pelo nome da database
            ->get()
            ->map(function ($database) {
                // Mapeia os resultados para retornar o formato necessário para o gráfico
                return [
                    'name' => $database->name,
                    'y' => $database->papers_count,
                ];
            })->toArray();
    }

    public function getPapersByYearAndDatabase()
    {
        // Consulta para obter os papers agrupados por ano e base de dados
        $papersByYearAndDatabase = Papers::whereIn('data_base', function ($query) {
            $query->select('id_database')
                ->from('project_databases')
                ->where('id_project', $this->currentProject->id_project);
        })
            ->join('data_base', 'papers.data_base', '=', 'data_base.id_database')
            ->selectRaw('year, data_base.name as database_name, COUNT(*) as total')
            ->groupBy('year', 'database_name')
            ->orderBy('year')
            ->get();

        // Retorna os dados formatados para o gráfico
        return $papersByYearAndDatabase->groupBy('year')->map(function ($yearGroup) {
            return $yearGroup->mapWithKeys(function ($item) {
                return [$item->database_name => $item->total];
            });
        });
    }

    /**
     * Renderiza a view do componente.
     */
    public function render()
    {
        $papersPerDatabase = $this->databasesWithPaperCount;
        $papersByYearAndDatabase = $this->getPapersByYearAndDatabase();

        return view('livewire.reporting.import-studies', compact('papersPerDatabase','papersByYearAndDatabase'));
    }
}
