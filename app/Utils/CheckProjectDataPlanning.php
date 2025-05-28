<?php

namespace App\Utils;

use App\Models\Criteria;
use App\Models\Domain;
use App\Models\Project;
use App\Models\Project\Conducting\QualityAssessment\GeneralScore;
use App\Models\Project\Planning\DataExtraction\Option;
use App\Models\Project\Planning\QualityAssessment\Cutoff;
use App\Models\Project\Planning\QualityAssessment\Question;
use App\Models\Project\Planning\DataExtraction\Question as DataExtractionQuestion;
use App\Models\ProjectDatabases;
use App\Models\ProjectLanguage;
use App\Models\ProjectStudyType;
use App\Models\ResearchQuestion;
use App\Models\SearchStrategy;
use App\Models\Term;

class CheckProjectDataPlanning
{
    // Verificações se os campos estão cadastrados no Planning
    public static function checkProjectData(int $projectId)
    {
        // Array que vai armazenar todos os erros
        $errors = [];

        // Verificar se existem dados na tabela 'domain'
        $domainExists = Domain::where('id_project', $projectId)->exists();
        if (!$domainExists) {
            $errors[] = __('project/conducting.check.domain');
        }

        // Verificar se existem dados na tabela 'project_languages'
        $projectLanguagesExists = ProjectLanguage::where('id_project', $projectId)->exists();
        if (!$projectLanguagesExists) {
            $errors[] = __('project/conducting.check.language');
        }

        // Verificar se existem dados na tabela 'project_study_types'
        $projectStudyTypesExists = ProjectStudyType::where('id_project', $projectId)->exists();
        if (!$projectStudyTypesExists) {
            $errors[] = __('project/conducting.check.study-types');
        }

        // Verificar se existem dados na tabela 'research_question'
        $researchQuestionsExists = ResearchQuestion::where('id_project', $projectId)->exists();
        if (!$researchQuestionsExists) {
            $errors[] = __('project/conducting.check.research-questions');
        }

        // Verificar se existem dados na tabela 'project_databases'
        $projectDatabasesExists = ProjectDatabases::where('id_project', $projectId)->exists();
        if (!$projectDatabasesExists) {
            $errors[] = __('project/conducting.check.databases');
        }

        //Verificar String Search
        $project = Project::findOrFail($projectId);
        // Verificar se 'feature_review' é diferente de 'Snowballing'
        if ($project->feature_review !== 'Snowballing') {
            // Se for diferente, verificar se há registros na tabela 'terms'
            $termExists = Term::where('id_project', $projectId)->exists();
            if (!$termExists) {
                $errors[] = __('project/conducting.check.term');
            }
        }

        // Verificar se existem dados na tabela 'search_strategy'
        $searchStrategyExists = SearchStrategy::where('id_project', $projectId)->exists();
        if (!$searchStrategyExists) {
            $errors[] = __('project/conducting.check.search-strategy');
        }

        // Verificar se existem dados na tabela 'criteria'
        $criteriaExists = Criteria::where('id_project', $projectId)->exists();
        if (!$criteriaExists) {
            $errors[] = __('project/conducting.check.criteria');
        }

        // Verificar se existem dados na tabela 'general_score'
        $generalScoreExists = GeneralScore::where('id_project', $projectId)->exists();
        if (!$generalScoreExists) {
            $errors[] =  __('project/conducting.check.general-score');
        }
        // Verificar se existem dados na tabela 'qa_cutoff' e se 'id_general_score' não é nulo
        $cutoffExists = Cutoff::where('id_project', $projectId)
            ->whereNotNull('id_general_score')
            ->exists();
        if (!$cutoffExists) {
            $errors[] = __('project/conducting.check.cutoff');
        }

        // Verificar se há alguma pergunta com 'min_to_app' NULL
        $questionHasNullMinToApp = Question::where('id_project', $projectId)
            ->whereNull('min_to_app')->exists();
        if ($questionHasNullMinToApp) {
            $errors[] = __('project/conducting.check.score-min');
        }

        // Verificar se existem dados na tabela 'question_quality' com 'min_to_app' diferente de NULL
        $questionExists = Question::where('id_project', $projectId)->exists();
        if (!$questionExists) {
            $errors[] = __('project/conducting.check.question-qa');
        }

        // Verificar se existem dados na tabela 'score_quality' vinculados a 'question_quality'
        $scoreExists = Question::where('id_project', $projectId)
            ->whereHas('qualityScores')
            ->exists();
        if (!$scoreExists) {
            $errors[] = __('project/conducting.check.score-qa');
        }

        // Verificar se existem dados na tabela 'data_extraction'
        $questionExists = DataExtractionQuestion::where('id_project', $projectId)->exists();
        if (!$questionExists) {
            $errors[] = __('project/conducting.check.data-extraction');
        }

        // Verificar se existem dados na tabela 'options_extraction' relacionados a 'questions_extraction'
        $optionExists = Option::whereHas('question', function ($query) use ($projectId) {
            $query->where('id_project', $projectId);
        })->exists();

        if (!$optionExists) {
            $errors[] = __('project/conducting.check.option-extraction');
        }

        if(!empty($errors)) {
            $compiledErrors = implode('<br>', $errors);
            session()->flash('error', $compiledErrors);
            return false;
        }

        return true;
    }
}
