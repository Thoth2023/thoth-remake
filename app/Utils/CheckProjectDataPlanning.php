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

        // Verificar se existem dados na tabela 'domain'
        $domainExists = Domain::where('id_project', $projectId)->exists();
        if (!$domainExists) {
            session()->flash('error', __('project/conducting.check.domain'));
            return false;
        }

        // Verificar se existem dados na tabela 'project_languages'
        $projectLanguagesExists = ProjectLanguage::where('id_project', $projectId)->exists();
        if (!$projectLanguagesExists) {
            session()->flash('error',  __('project/conducting.check.language'));
            return false;
        }

        // Verificar se existem dados na tabela 'project_study_types'
        $projectStudyTypesExists = ProjectStudyType::where('id_project', $projectId)->exists();
        if (!$projectStudyTypesExists) {
            session()->flash('error',  __('project/conducting.check.study-types'));
            return false;
        }

        // Verificar se existem dados na tabela 'research_question'
        $researchQuestionsExists = ResearchQuestion::where('id_project', $projectId)->exists();
        if (!$researchQuestionsExists) {
            session()->flash('error',  __('project/conducting.check.research-questions'));
            return false;
        }

        // Verificar se existem dados na tabela 'project_databases'
        $projectDatabasesExists = ProjectDatabases::where('id_project', $projectId)->exists();
        if (!$projectDatabasesExists) {
            session()->flash('error',  __('project/conducting.check.databases'));
            return false;
        }

        //Verificar String Search
        $project = Project::findOrFail($projectId);
        // Verificar se 'feature_review' é diferente de 'Snowballing'
        if ($project->feature_review !== 'Snowballing') {
            // Se for diferente, verificar se há registros na tabela 'terms'
            $termExists = Term::where('id_project', $projectId)->exists();
            if (!$termExists) {
                session()->flash('error',  __('project/conducting.check.term'));
                return false;
            }
        }

        // Verificar se existem dados na tabela 'search_strategy'
        $searchStrategyExists = SearchStrategy::where('id_project', $projectId)->exists();
        if (!$searchStrategyExists) {
            session()->flash('error',  __('project/conducting.check.search-strategy'));
            return false;
        }

        // Verificar se existem dados na tabela 'criteria'
        $criteriaExists = Criteria::where('id_project', $projectId)->exists();
        if (!$criteriaExists) {
            session()->flash('error',  __('project/conducting.check.criteria'));
            return false;
        }

        // Verificar se existem dados na tabela 'general_score'
        $generalScoreExists = GeneralScore::where('id_project', $projectId)->exists();
        if (!$generalScoreExists) {
            session()->flash('error',  __('project/conducting.check.general-score'));
            return false;
        }
        // Verificar se existem dados na tabela 'qa_cutoff' e se 'id_general_score' não é nulo
        $cutoffExists = Cutoff::where('id_project', $projectId)
            ->whereNotNull('id_general_score')
            ->exists();
        if (!$cutoffExists) {
            session()->flash('error',  __('project/conducting.check.cutoff'));
            return false;
        }

        // Verificar se há alguma pergunta com 'min_to_app' NULL
        $questionHasNullMinToApp = Question::where('id_project', $projectId)
            ->whereNull('min_to_app')->exists();
        if ($questionHasNullMinToApp) {
            session()->flash('error',  __('project/conducting.check.score-min'));
            return false;
        }

        // Verificar se existem dados na tabela 'question_quality' com 'min_to_app' diferente de NULL
        $questionExists = Question::where('id_project', $projectId)->exists();
        if (!$questionExists) {
            session()->flash('error',  __('project/conducting.check.question-qa'));
            return false;
        }

        // Verificar se existem dados na tabela 'score_quality' vinculados a 'question_quality'
        $scoreExists = Question::where('id_project', $projectId)
            ->whereHas('qualityScores')
            ->exists();
        if (!$scoreExists) {
            session()->flash('error',  __('project/conducting.check.score-qa'));
            return false;
        }

        // Verificar se existem dados na tabela 'data_extraction'
        $questionExists = DataExtractionQuestion::where('id_project', $projectId)->exists();
        if (!$questionExists) {
            session()->flash('error',  __('project/conducting.check.data-extraction'));
            return false;
        }

        // Verificar se existem dados na tabela 'options_extraction' relacionados a 'questions_extraction'
        $optionExists = Option::whereHas('question', function ($query) use ($projectId) {
            $query->where('id_project', $projectId);
        })->exists();

        if (!$optionExists) {
            session()->flash('error',  __('project/conducting.check.option-extraction'));
            return false;
        }

        return true;
    }
}
