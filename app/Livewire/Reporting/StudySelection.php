<?php

namespace App\Livewire\Reporting;

use App\Models\EvaluationCriteria;
use App\Models\Project as ProjectModel;
use App\Models\Project\Conducting\Papers;
use App\Models\ProjectDatabases;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class StudySelection extends Component
{
    public $currentProject;

    public function mount()
    {
        // Obtém o ID do projeto a partir da URL
        $projectId = request()->segment(2); // Exemplo usando a URL, mas pode ser da sessão

        // Busca o projeto e lança uma exceção se não for encontrado
        $this->currentProject = ProjectModel::findOrFail($projectId);
    }

    public function getPapersPerStatusSelection()
    {
        // Consulta para pegar os papers vinculados ao projeto corrente, agrupados por status de seleção
        $papers = ProjectDatabases::where('id_project', $this->currentProject->id_project)
            ->join('data_base', 'project_databases.id_database', '=', 'data_base.id_database')
            ->join('bib_upload', 'project_databases.id_project_database', '=', 'bib_upload.id_project_database')
            ->join('papers', 'papers.id_bib', '=', 'bib_upload.id_bib')
            ->join('status_selection', 'papers.status_selection', '=', 'status_selection.id_status')
            ->selectRaw('status_selection.description as status_description, COUNT(papers.id) as total') // Conta os papers por status
            ->groupBy('status_selection.description') // Agrupa pelo status
            ->get();

        // Mapear os resultados para o formato necessário
        return $papers->map(function($paper) {
            return [
                'name' => $paper->status_description,
                'y' => (int) $paper->total // Total de papers por status
            ];
        });
    }


    public function getCriteriaPerUser()
    {
        // Consulta para obter a quantidade de vezes que cada usuário assinalou cada critério
        $criteriaPerUser = EvaluationCriteria::whereIn('id_paper', function ($query) {
            $query->select('id_paper')
                ->from('papers')
                ->whereIn('papers.data_base', function ($subQuery) {
                    $subQuery->select('id_database')
                        ->from('project_databases')
                        ->join('bib_upload', 'project_databases.id_project_database', '=', 'bib_upload.id_project_database')
                        ->join('papers', 'papers.id_bib', '=', 'bib_upload.id_bib')
                        ->where('project_databases.id_project', $this->currentProject->id_project); // Filtra pelo projeto corrente
                });
        })
            ->join('criteria', 'evaluation_criteria.id_criteria', '=', 'criteria.id_criteria')
            ->join('members', 'evaluation_criteria.id_member', '=', 'members.id_members')
            ->join('users', 'members.id_user', '=', 'users.id') // Pega o usuário responsável
            ->selectRaw('criteria.id as criteria_id, criteria.description as criteria_name, users.firstname as user_name, COUNT(*) as total')
            ->groupBy('criteria_id', 'criteria_name', 'user_name')
            ->orderByRaw("CASE WHEN criteria.type = 'Inclusion' THEN 0 ELSE 1 END")
            ->orderBy('criteria_id') // Ordena por critério para facilitar o agrupamento
            ->get();

        // Formatar os dados para serem usados no gráfico, incluindo o criteria_name
        return $criteriaPerUser->groupBy('criteria_id')->map(function ($criteriaGroup) {
            $criteriaName = $criteriaGroup->first()->criteria_name; // Pega o nome do critério
            return [
                'criteria_name' => $criteriaName,
                'users' => $criteriaGroup->mapWithKeys(function ($item) {
                    return [$item->user_name => $item->total];
                })
            ];
        });
    }

    public function getPapersByUserAndStatusSelection()
    {
        // Consulta para pegar a quantidade de papers por status, agrupado por usuário
        $papersPerUserStatus = DB::table('papers_selection')
            ->join('status_selection', 'papers_selection.id_status', '=', 'status_selection.id_status')
            ->join('members', 'papers_selection.id_member', '=', 'members.id_members')
            ->join('users', 'members.id_user', '=', 'users.id') // Pega o nome do usuário
            ->join('papers', 'papers_selection.id_paper', '=', 'papers.id_paper') // Vincula com papers para verificar o projeto
            ->join('bib_upload', 'papers.id_bib', '=', 'bib_upload.id_bib')
            ->join('project_databases', 'bib_upload.id_project_database', '=', 'project_databases.id_project_database')
            ->selectRaw('users.firstname as user_name, status_selection.description as status_name, COUNT(*) as total')
            ->where('project_databases.id_project', $this->currentProject->id_project) // Filtra pelo projeto corrente
            ->groupBy('user_name', 'status_name')
            ->orderBy('user_name') // Ordena por usuário para facilitar o agrupamento
            ->get();

        // Formatar os dados para uso no gráfico, agora agrupando por usuário
        return $papersPerUserStatus->groupBy('user_name')->map(function ($userGroup) {
            return [
                'statuses' => $userGroup->mapWithKeys(function ($item) {
                    return [$item->status_name => $item->total];
                })
            ];
        });
    }



    public function render()
    {
        // Obtém os dados para o gráfico de pizza
        $papersPerStatus = $this->getPapersPerStatusSelection();
        $papersByUserAndStatus = $this->getPapersByUserAndStatusSelection();
        // Obtenha os dados de critérios por usuário
        $criteriaData = $this->getCriteriaPerUser();

        return view('livewire.reporting.study-selection', compact('papersPerStatus','criteriaData','papersByUserAndStatus'));
    }
}
