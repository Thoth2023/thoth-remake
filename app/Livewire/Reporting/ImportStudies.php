<?php

namespace App\Livewire\Reporting;

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
        // Busca os databases cadastrados para o projeto corrente
        return ProjectDatabases::where('id_project', $this->currentProject->id_project)
            ->join('data_base', 'project_databases.id_database', '=', 'data_base.id_database')
            ->leftJoin('bib_upload', 'project_databases.id_project_database', '=', 'bib_upload.id_project_database')
            ->leftJoin('papers', 'papers.id_bib', '=', 'bib_upload.id_bib')
            ->select(
                'data_base.name',
                DB::raw('COALESCE(COUNT(papers.id), 0) as papers_count') // Conta os papers por database, retorna 0 se não houver papers
            )
            ->groupBy('data_base.name') // Agrupa pelo nome
            ->get()
            ->map(function ($database) {
                // Mapeia os resultados
                return [
                    'name' => $database->name,
                    'y' => (int) $database->papers_count,
                ];
            })
            ->toArray();
    }


    public function getPapersByYearAndDatabase()
    {
        // Consulta para obter os papers relacionados ao projeto corrente agrupados por ano e database
        $papersByYearAndDatabase = ProjectDatabases::where('id_project', $this->currentProject->id_project)
            ->join('data_base', 'project_databases.id_database', '=', 'data_base.id_database')
            ->leftJoin('bib_upload', 'project_databases.id_project_database', '=', 'bib_upload.id_project_database')
            ->leftJoin('papers', 'papers.id_bib', '=', 'bib_upload.id_bib')
            ->selectRaw('papers.year, data_base.name as database_name, COUNT(papers.id) as total') // Conta os papers por ano e database
            ->groupBy('papers.year', 'data_base.name')
            ->orderBy('papers.year')
            ->get();

        // Retorna os dados formatados para o gráfico
        return $papersByYearAndDatabase->groupBy('year')->map(function ($yearGroup) {
            return $yearGroup->mapWithKeys(function ($item) {
                return [$item->database_name => (int) $item->total]; // Garantir que o total seja inteiro
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
