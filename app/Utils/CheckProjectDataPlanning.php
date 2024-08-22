<?php

namespace App\Utils;

use App\Models\BibUpload;
use App\Models\Criteria;
use App\Models\Domain;
use App\Models\Project;
use App\Models\Project\Conducting\Papers;
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
            session()->flash('error', 'Dados de "Domain" não cadastrados para este projeto.');
            return false;
        }

        // Verificar se existem dados na tabela 'project_languages'
        $projectLanguagesExists = ProjectLanguage::where('id_project', $projectId)->exists();
        if (!$projectLanguagesExists) {
            session()->flash('error', 'Dados de "Project Languages" não cadastrados para este projeto.');
            return false;
        }

        // Verificar se existem dados na tabela 'project_study_types'
        $projectStudyTypesExists = ProjectStudyType::where('id_project', $projectId)->exists();
        if (!$projectStudyTypesExists) {
            session()->flash('error', 'Dados de "Project Study Types" não cadastrados para este projeto.');
            return false;
        }

        // Verificar se existem dados na tabela 'research_question'
        $researchQuestionsExists = ResearchQuestion::where('id_project', $projectId)->exists();
        if (!$researchQuestionsExists) {
            session()->flash('error', 'Dados de "Research Questions" não cadastrados para este projeto.');
            return false;
        }

        // Verificar se existem dados na tabela 'project_databases'
        $projectDatabasesExists = ProjectDatabases::where('id_project', $projectId)->exists();
        if (!$projectDatabasesExists) {
            session()->flash('error', 'Dados de "Project Databases" não cadastrados para este projeto.');
            return false;
        }

        //Verificar String Search
        $project = Project::findOrFail($projectId);
        // Verificar se 'feature_review' é diferente de 'Snowballing'
        if ($project->feature_review !== 'Snowballing') {
            // Se for diferente, verificar se há registros na tabela 'terms'
            $termExists = Term::where('id_project', $projectId)->exists();
            if (!$termExists) {
                session()->flash('error', 'Dados de "Term" não cadastrados para este projeto.');
                return false;
            }
        }

        // Verificar se existem dados na tabela 'search_strategy'
        $searchStrategyExists = SearchStrategy::where('id_project', $projectId)->exists();
        if (!$searchStrategyExists) {
            session()->flash('error', 'Dados de "Search Strategy" não cadastrados para este projeto.');
            return false;
        }

        // Verificar se existem dados na tabela 'criteria'
        $criteriaExists = Criteria::where('id_project', $projectId)->exists();
        if (!$criteriaExists) {
            session()->flash('error', 'Dados de "Criteria" não cadastrados para este projeto.');
            return false;
        }

        // Verificar se existem dados na tabela 'general_score'
        $generalScoreExists = GeneralScore::where('id_project', $projectId)->exists();
        if (!$generalScoreExists) {
            session()->flash('error', 'Dados de "General Score" não cadastrados para este projeto.');
            return false;
        }
        // Verificar se existem dados na tabela 'qa_cutoff' e se 'id_general_score' não é nulo
        $cutoffExists = Cutoff::where('id_project', $projectId)
            ->whereNotNull('id_general_score')
            ->exists();
        if (!$cutoffExists) {
            session()->flash('error', 'Dados de "QA Cutoff" não cadastrados ou "id_general_score" está vazio para este projeto.');
            return false;
        }

        // Verificar se há alguma pergunta com 'min_to_app' NULL
        $questionHasNullMinToApp = Question::where('id_project', $projectId)
            ->whereNull('min_to_app')->exists();
        if ($questionHasNullMinToApp) {
            session()->flash('error', 'Existem perguntas com "min_to_app" não definido para este projeto.');
            return false;
        }

        // Verificar se existem dados na tabela 'question_quality' com 'min_to_app' diferente de NULL
        $questionExists = Question::where('id_project', $projectId)->exists();
        if (!$questionExists) {
            session()->flash('error', 'Dados de "Question Quality" não cadastrados ou "min_to_app" não definido para este projeto.');
            return false;
        }

        // Verificar se existem dados na tabela 'score_quality' vinculados a 'question_quality'
        $scoreExists = Question::where('id_project', $projectId)
            ->whereHas('qualityScores')
            ->exists();
        if (!$scoreExists) {
            session()->flash('error', 'Dados de "Score Quality" não cadastrados para este projeto.');
            return false;
        }

        // Verificar se existem dados na tabela 'data_extraction'
        $questionExists = DataExtractionQuestion::where('id_project', $projectId)->exists();
        if (!$questionExists) {
            session()->flash('error', 'Dados de "Question Extraction" não cadastrados para este projeto.');
            return false;
        }

        // Verificar se existem dados na tabela 'options_extraction' relacionados a 'questions_extraction'
        $optionExists = Option::whereHas('question', function ($query) use ($projectId) {
            $query->where('id_project', $projectId);
        })->exists();

        if (!$optionExists) {
            session()->flash('error', 'Não há opções cadastradas para as questões de extração deste projeto.');
            return false;
        }

        return true;
    }
}
