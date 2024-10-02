<?php

namespace App\Livewire\Reporting;

use App\Models\Member;
use App\Models\Project as ProjectModel;
use App\Models\Project\Conducting\Papers;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class QualityAssessment extends Component
{
    public $currentProject;

    public function mount()
    {
        // Obtém o ID do projeto a partir da URL
        $projectId = request()->segment(2); // Exemplo usando a URL, mas pode ser da sessão

        // Busca o projeto e lança uma exceção se não for encontrado
        $this->currentProject = ProjectModel::findOrFail($projectId);
    }

    public function getPapersPerStatusQuality()
    {
        $papers = Papers::whereIn('data_base', function ($query) {
            $query->select('id_database')
                ->from('project_databases')
                ->where('id_project', $this->currentProject->id_project);
        })
            // Junção com outras tabelas necessárias
            ->join('papers_qa', 'papers_qa.id_paper', '=', 'papers.id_paper')
            ->join('status_qa', 'papers_qa.id_status', '=', 'status_qa.id_status')
            ->join('papers_selection', 'papers_selection.id_paper', '=', 'papers_qa.id_paper')
            ->leftJoin('paper_decision_conflicts', 'papers_qa.id_paper', '=', 'paper_decision_conflicts.id_paper')

            // Condição para pegar papers com id_status = 1 ou
            // papers que têm id_status = 2 na tabela papers_selection e conflitos com new_status_paper = 1
            ->where(function ($query) {
                $query->where('papers_selection.id_status', 1)
                    ->orWhere(function ($query) {
                        $query->where('papers_selection.id_status', 2)
                            ->where('paper_decision_conflicts.phase', 'study-selection')
                            ->where('paper_decision_conflicts.new_status_paper', 1);
                    });
            })

            // Selecionar a descrição do status_qa e contar o total de papers
            ->distinct('papers.id_paper')
            ->selectRaw('status_qa.status as status_description, COUNT(*) as total')
            ->groupBy('status_description')
            ->get();

        // Mapear os resultados para o formato necessário
        return $papers->map(function($paper) {
            return [
                'name' => $paper->status_description, // Acessa a descrição do status
                'y' => $paper->total // Total de papers por status
            ];
        });
    }

    public function getPapersByGeneralScore()
    {
        // Buscar o membro autenticado
        $member = Member::where('id_user', auth()->user()->id)->first();

        // Consulta para pegar a quantidade de papers por general score para o membro e projeto atual
        $papersPerGeneralScore = DB::table('papers_qa')
            ->join('general_score', 'papers_qa.id_gen_score', '=', 'general_score.id_general_score')
            ->join('papers', 'papers_qa.id_paper', '=', 'papers.id_paper')
            ->join('papers_selection', 'papers_selection.id_paper', '=', 'papers_qa.id_paper')
            ->leftJoin('paper_decision_conflicts', 'papers_qa.id_paper', '=', 'paper_decision_conflicts.id_paper')

            // Filtrar os papers conforme o status de aceitação ou resolução de conflitos
            ->where(function ($query) {
                // Papers aceitos (id_status = 1)
                $query->where('papers_selection.id_status', 1)
                    ->orWhere(function ($query) {
                        // Papers rejeitados, mas com conflito resolvido (new_status_paper = 1)
                        $query->where('papers_selection.id_status', 2)
                            ->where('paper_decision_conflicts.phase', 'study-selection')
                            ->where('paper_decision_conflicts.new_status_paper', 1);
                    });
            })

            // Filtrar pelo membro autenticado
            ->where('papers_qa.id_member', $member->id_members)

            // Filtrar pelos papers vinculados ao projeto atual
            ->whereIn('papers.data_base', function ($query) {
                $query->select('id_database')
                    ->from('project_databases')
                    ->where('id_project', $this->currentProject->id_project);
            })

            // Selecionar a descrição do general score e contar o total de papers
            ->selectRaw('general_score.description as score_name, COUNT(DISTINCT papers_qa.id_paper) as total')
            ->groupBy('score_name')
            ->get();

        // Mapear os resultados para o formato necessário
        return $papersPerGeneralScore->map(function($score) {
            return [
                'name' => $score->score_name, // Descrição do general score
                'y' => $score->total // Total de papers por score
            ];
        });
    }

    public function getPapersByUserAndStatusQuality()
    {
        // Consulta para pegar a quantidade de papers por status, agrupado por usuário
        $papersPerUserStatus = DB::table('papers_qa')
            ->join('status_qa', 'papers_qa.id_status', '=', 'status_qa.id_status')
            ->join('members', 'papers_qa.id_member', '=', 'members.id_members')
            ->join('users', 'members.id_user', '=', 'users.id') // Pega o nome do usuário
            ->join('papers_selection', 'papers_selection.id_paper', '=', 'papers_qa.id_paper')
            ->leftJoin('paper_decision_conflicts', 'papers_qa.id_paper', '=', 'paper_decision_conflicts.id_paper')

            // Filtrar pelo projeto atual
            ->where('members.id_project', $this->currentProject->id_project)

            // Condições de filtragem para id_status e conflitos
            ->where(function ($query) {
                // Inclui papers com id_status = 1
                $query->where('papers_selection.id_status', 1)
                    ->orWhere(function ($query) {
                        // Inclui papers com id_status = 2, mas que têm conflitos resolvidos
                        $query->where('papers_selection.id_status', 2)
                            ->where('paper_decision_conflicts.phase', 'study-selection')
                            ->where('paper_decision_conflicts.new_status_paper', 1);
                    });
            })

            // Selecionar usuário, status e contar o total de papers
            ->selectRaw('users.firstname as user_name, status_qa.status as status_name, COUNT(DISTINCT papers_qa.id_paper) as total')
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
        $papersPerStatus = $this->getPapersPerStatusQuality();
        $papersByGeneralScore = $this->getPapersByGeneralScore();
        $papersByUserAndStatusQuality = $this->getPapersByUserAndStatusQuality();

        return view('livewire.reporting.quality-assessment', compact('papersPerStatus','papersByUserAndStatusQuality','papersByGeneralScore'));

    }
}
