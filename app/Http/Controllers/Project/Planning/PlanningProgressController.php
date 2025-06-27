<?php

namespace App\Http\Controllers\Project\Planning;

use App\Models\Domain;
use App\Models\ProjectLanguage;
use App\Models\ProjectStudyType;
use App\Models\Keyword;
use App\Models\Project;
use App\Models\ResearchQuestion;
use App\Models\Database;
use App\Models\Term;
use App\Models\Criteria;
use App\Models\Project\Planning\QualityAssessment\Question;
use App\Models\Project\Planning\QualityAssessment\GeneralScore as GeneralScoreModel;
use App\Models\Project\Planning\QualityAssessment\QualityScore as QualityScoreModel;
use App\Models\Project\Planning\QualityAssessment\Cutoff as CutoffScoreModel;
use App\Http\Requests\Project\Planning\DataExtraction\Question\StoreQuestionRequest;
use App\Http\Requests\Project\Planning\DataExtraction\Question\UpdateQuestionRequest;
use App\Models\Project\Planning\DataExtraction\Question as DataExtractionQuestionAlias;
use Illuminate\Http\Request;

class PlanningProgressController
{
    /**
     * Calculate the overall planning progress.
     *
     * @param string $projectId
     * @return array
     */
    public function calculate(string $projectId): array
    {
        // Informações gerais = 5 itens
        // Questões de pesquisa = 1
        // Base de dados = 1
        // Termos = 1
        // Estratégia de busca = 1
        // Critérios = 1
        // Avaliação de qualidade = 5
        // Extração = 2    
        $totalSections = 15; // Número total de seções no planejamento
        $completedSections = 0;
    
        // Verificar se pelo menos um domínio foi adicionado
        $planningProgress = Domain::where('id_project', $projectId)->exists() ? 1 : 0;
        // Verificar se pelo menos uma lang foi selecionada
        $languageProgress = ProjectLanguage::where('id_project', $projectId)->exists() ? 1 : 0;
        // Verificar se pelo menos um estudo foi selecionado
        $importStudiesProgress = ProjectStudyType::where('id_project', $projectId)->exists() ? 1 : 0;
        $keywordProgress = Keyword::where('id_project', $projectId)->exists() ? 1 : 0;
        
        $project = Project::find($projectId);
        $dateProgress = 0;
        if (
            $project &&
            !empty($project->start_date) &&
            !empty($project->end_date) &&
            $project->start_date >= '2000-01-01' &&
            $project->end_date <= '2100-12-31'
        ) {
            $dateProgress = 1;
        }
        
        $researchQuestionProgress = ResearchQuestion::where('id_project', $projectId)->exists() ? 1 : 0;
        
        $databaseProgress = Database::whereHas('projects', function ($query) use ($projectId) {
            $query->where('project_databases.id_project', $projectId);
        })->exists() ? 1 : 0;
        $termProgress = Term::where('id_project', $projectId)->exists() ? 1 : 0;

        $searchStrategyProgress = Project::where('id_project', $projectId)
        ->whereHas('searchStrategy', function ($query) {
            $query->whereNotNull('description');
        })->exists() ? 1 : 0;

        $criteriaProgress = Criteria::where('id_project', $projectId)->exists() ? 1 : 0;
        $qualityAssessmentProgress = DataExtractionQuestionAlias::where('id_project', $projectId)->exists() ? 1 : 0;
        
        $qualityScoreProgress = QualityScoreModel::whereHas('question', function ($query) use ($projectId) {
            $query->where('id_project', $projectId);
        })->exists() ? 1 : 0;

        $cutoffProgress = CutoffScoreModel::whereHas('generalScore', function ($query) use ($projectId) {
            $query->where('id_project', $projectId);
        })->exists() ? 1 : 0;

        $generalScoreProgress = GeneralScoreModel::where('id_project', $projectId)->exists() ? 1 : 0;
        $questionProgress = Question::where('id_project', $projectId)->exists() ? 1 : 0;

        // Calcular o número de seções preenchidas
        $completedSections += $planningProgress;
        $completedSections += $languageProgress;
        $completedSections += $importStudiesProgress;
        $completedSections += $keywordProgress;
        $completedSections += $dateProgress;
        $completedSections += $researchQuestionProgress;
        $completedSections += $databaseProgress;
        $completedSections += $termProgress;
        $completedSections += $searchStrategyProgress;
        $completedSections += $criteriaProgress;
        $completedSections += $qualityAssessmentProgress;
        $completedSections += $qualityScoreProgress;
        $completedSections += $generalScoreProgress;
        $completedSections += $cutoffProgress;
        $completedSections += $questionProgress;

        // Calcular o progresso geral como uma porcentagem
        $overallProgress = ($completedSections / $totalSections) * 100;
    
        return [
            'overall' => $overallProgress, // Progresso geral
            'planning' => ($planningProgress / $totalSections) * 100,
            'languages' => ($languageProgress / $totalSections) * 100,
            'importStudies' => ($importStudiesProgress / $totalSections) * 100,
            'keywords' => ($keywordProgress / $totalSections) * 100,
            'dates' => ($dateProgress / $totalSections) * 100,
            'researchQuestions' => ($researchQuestionProgress / $totalSections) * 100,
            'databases' => ($databaseProgress / $totalSections) * 100,
            'terms' => ($termProgress / $totalSections) * 100,
            'searchStrategy' => ($searchStrategyProgress / $totalSections) * 100,
            'criteria' => ($criteriaProgress / $totalSections) * 100,
            'qualityAssessment' => ($qualityAssessmentProgress / $totalSections) * 100,
            'qualityScore' => ($qualityScoreProgress / $totalSections) * 100,
            'generalScore' => ($generalScoreProgress / $totalSections) * 100,
            'cutoff' => ($cutoffProgress / $totalSections) * 100,
            'dataExtraction' => ($questionProgress / $totalSections) * 100,
        ];
    }
}