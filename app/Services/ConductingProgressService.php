<?php

namespace App\Services;

use App\Models\BibUpload;
use App\Models\ProjectDatabases;
use App\Models\Project\Conducting\Papers;
use App\Models\Member;
use App\Models\StatusSelection;
use App\Models\StatusQualityAssessment;
use App\Models\StatusExtraction;

class ConductingProgressService
{
    public function calculateProgress(int $projectId): array
    {
        // 1) Importação
        $totalImported = $this->getTotalImportedStudies($projectId);
        $importStudies = $totalImported > 0 ? 100.0 : 0.0;

        // 2) Seleção de Estudos
        $studySelection = $this->getStudySelection($projectId, $totalImported);
        $progressStudySelection       = (float) ($studySelection['percentage']  ?? 0.0);
        $unclassifiedStudySelection   = (int)   ($studySelection['unclassified'] ?? 0);

        // 3) Avaliação de Qualidade
        $qualityAssessment = $this->getQualityAssessment($projectId, $totalImported, $unclassifiedStudySelection);
        $progressQualityAssessment    = (float) ($qualityAssessment['percentage']  ?? 0.0);
        $unclassifiedQualityAssessment= (int)   ($qualityAssessment['unclassified'] ?? 0);

        // 4) Extração de Dados
        $dataExtraction = $this->getExtraction($projectId, $totalImported, $unclassifiedQualityAssessment);

        // 5) Progresso geral (25% cada etapa)
        $overall = ($importStudies * 0.25)
            + ($progressStudySelection * 0.25)
            + ($progressQualityAssessment * 0.25)
            + ($dataExtraction * 0.25);

        return [
            'overall'            => round($overall, 2),
            'import_studies'     => round($importStudies, 2),
            'study_selection'    => round($progressStudySelection, 2),
            'quality_assessment' => round($progressQualityAssessment, 2),
            'data_extraction'    => round($dataExtraction, 2),
            'snowballing'        => 0.0, // por enquanto
        ];
    }


    private function getUserIds(int $projectId)
    {
        return Member::where('id_project', $projectId)->pluck('id_members');
    }

    private function getBibIds(int $projectId)
    {
        $db = ProjectDatabases::where('id_project', $projectId)->pluck('id_project_database');
        return BibUpload::whereIn('id_project_database', $db)->pluck('id_bib');
    }

    private function getTotalImportedStudies(int $projectId): int
    {
        return Papers::whereIn('id_bib', $this->getBibIds($projectId))->count();
    }

    private function getStudySelection(int $projectId, int $totalImported): array
    {
        if ($totalImported === 0)
            return ['percentage' => 0, 'unclassified' => 0];

        $memberIds = $this->getUserIds($projectId);
        $bibIds = $this->getBibIds($projectId);

        // pegar IDs dos status
        $statuses = StatusSelection::whereIn('description', [
            'Rejected', 'Unclassified', 'Removed', 'Accepted', 'Duplicate'
        ])->pluck('id_status', 'description');

        // total de papers avaliados pelo usuário
        $totalEvaluated = Papers::whereIn('id_bib', $bibIds)
            ->join('papers_selection', 'papers_selection.id_paper', '=', 'papers.id_paper')
            ->whereIn('papers_selection.id_member', $memberIds)
            ->count();

        // total unclassified
        $unclassified = Papers::whereIn('id_bib', $bibIds)
            ->join('papers_selection', 'papers_selection.id_paper', '=', 'papers.id_paper')
            ->whereIn('papers_selection.id_member', $memberIds)
            ->where('papers_selection.id_status', $statuses['Unclassified'])
            ->count();

        // classificados = avaliados - unclassified
        $classified = max(0, $totalEvaluated - $unclassified);

        // porcentagem com base apenas nos avaliados
        $percentage = $totalEvaluated > 0
            ? ($classified / $totalEvaluated) * 100
            : 0;

        return [
            'percentage' => $percentage,
            'unclassified' => $unclassified
        ];
    }



    private function getQualityAssessment(int $projectId, int $totalImported, int $unclassifiedSelection): array
    {
        if ($totalImported === 0)
            return ['percentage' => 0, 'unclassified' => 0];

        $memberIds = $this->getUserIds($projectId);
        $bibIds = $this->getBibIds($projectId);

        $statuses = StatusQualityAssessment::whereIn('status', [
            'Rejected', 'Unclassified', 'Removed', 'Accepted'
        ])->pluck('id_status', 'status');

        $unclassifiedStatus = $statuses['Unclassified'];

        // Somente papers que entraram na QA
        $papers = Papers::whereIn('id_bib', $bibIds)
            ->join('papers_qa', 'papers_qa.id_paper', '=', 'papers.id_paper')
            ->join('papers_selection', 'papers_selection.id_paper', '=', 'papers_qa.id_paper')
            ->leftJoin('paper_decision_conflicts', 'papers.id_paper', '=', 'paper_decision_conflicts.id_paper')
            ->where(function ($query) {
                $query->where('papers_selection.id_status', 1)
                    ->orWhere(function ($query) {
                        $query->where('papers_selection.id_status', 2)
                            ->where('paper_decision_conflicts.new_status_paper', 1);
                    });
            })
            ->whereIn('papers_selection.id_member', $memberIds)
            ->whereIn('papers_qa.id_member', $memberIds);

        $totalEvaluated = $papers->count();

        $unclassifiedQA = $papers->where('papers_qa.id_status', $unclassifiedStatus)->count();

        $totalUnclassified = $unclassifiedSelection + $unclassifiedQA;

        $classified = max(0, $totalEvaluated - $unclassifiedQA);

        $percentage = $totalEvaluated > 0
            ? ($classified / $totalEvaluated) * 100
            : 0;

        return [
            'percentage' => $percentage,
            'unclassified' => $totalUnclassified
        ];
    }



    private function getExtraction(int $projectId, int $totalImported, int $unclassifiedQA): float
    {
        if ($totalImported === 0) return 0;

        $memberIds = $this->getUserIds($projectId);
        $bibIds = $this->getBibIds($projectId);

        $statuses = StatusExtraction::whereIn('description', ['Done', 'To Do', 'Removed'])
            ->pluck('id_status', 'description');

        $todoStatus = $statuses['To Do'];

        $papers = Papers::whereIn('id_bib', $bibIds)
            ->join('papers_qa', 'papers_qa.id_paper', '=', 'papers.id_paper')
            ->leftJoin('paper_decision_conflicts', 'papers.id_paper', '=', 'paper_decision_conflicts.id_paper')
            ->where(function ($query) {
                $query->where('papers_qa.id_status', 1)
                    ->orWhere(function ($query) {
                        $query->where('papers_qa.id_status', 2)
                            ->where('paper_decision_conflicts.phase', 'quality')
                            ->where('paper_decision_conflicts.new_status_paper', 1);
                    });
            })
            ->whereIn('papers_qa.id_member', $memberIds);

        $totalEvaluated = $papers->count();
        $todo = $papers->where('status_extraction', $todoStatus)->count();

        $classified = max(0, $totalEvaluated - $todo);

        return $totalEvaluated > 0
            ? ($classified / $totalEvaluated) * 100
            : 0;
    }


}
