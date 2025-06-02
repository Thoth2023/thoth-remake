<?php

namespace App\Http\Controllers\Project\Conducting;

use App\Models\BibUpload;
use App\Livewire\Conducting\StudySelection\Count as StudySelectionCount;
use App\Livewire\Conducting\QualityAssessment\Count as QualityAssessmentCount;
use App\Livewire\Conducting\DataExtraction\Count as DataExtractionCount;
use App\Models\Project\Conducting\Papers;
use App\Models\ProjectDatabases;

class ConductingProgressController
{
    public function calculateProgress($projectId)
    {
        // Importar Estudos
        $totalImported = $this->getTotalImportedStudies($projectId);
        $importStudies = $totalImported > 0 ? 100.0 : 0.0;

        // Seleção de Estudos
        $studySelection = $this->getStudySelectionPercentage($totalImported);

        $progressStudySelection = $studySelection['percentage'];
        $unclassifiedStudySelection = $studySelection['unclassified'];

        // Avaliação de Qualidade
        $qualityAssessment = $this->getQualityAssessmentPercentage($totalImported, $unclassifiedStudySelection);

        $progressQualityAssessment = $qualityAssessment['percentage'];
        $unclassifiedQualityAssessment = $qualityAssessment['unclassified'];

        // Extração de Dados
        $dataExtraction = $this->getDataExtractionPercentage($totalImported, $unclassifiedQualityAssessment);

        // Progresso: 25% + 25% + 25% + 25%
        $conductingProgress = ($importStudies * 0.25) +
            ($progressStudySelection * 0.25) +
            ($progressQualityAssessment * 0.25) +
            ($dataExtraction * 0.25);

        return round($conductingProgress, 2);
    }

    private function getTotalImportedStudies($projectId): int
    {
        $idsDatabase = ProjectDatabases::where('id_project', $projectId)->pluck('id_project_database');

        if ($idsDatabase->isEmpty()) return 0;

        $idsBib = BibUpload::whereIn('id_project_database', $idsDatabase)->pluck('id_bib');

        if ($idsBib->isEmpty()) return 0;

        return Papers::whereIn('id_bib', $idsBib)->count();
    }

    private function getStudySelectionPercentage($totalImported): array
    {
        if ($totalImported === 0) {
            return [
                'percentage' => 0.0,
                'unclassified' => 0
            ];
        }

        $count = new StudySelectionCount();
        $count->mount();
        $count->loadCounters();

        $unclassified = count($count->unclassified);
        $classified = $totalImported - $unclassified;
        $percentage = ($classified / $totalImported) * 100;

        return [
            'percentage' => $percentage,
            'unclassified' => $unclassified
        ];
    }

    private function getQualityAssessmentPercentage($totalImported, $unclassifiedStudySelection): array
    {
        if ($totalImported === 0) {
            return [
                'percentage' => 0.0,
                'unclassified' => 0
            ];
        }

        $count = new QualityAssessmentCount();
        $count->mount();
        $count->loadCounters();

        $unclassified = count($count->unclassified);
        // Leva em consieração os estudos de Seleção de Estudos que ainda não foram classificados
        $classified = $totalImported - $unclassified - $unclassifiedStudySelection;
        $percentage = ($classified / $totalImported) * 100;

        return [
            'percentage' => $percentage,
            'unclassified' => $unclassified + $unclassifiedStudySelection
        ];
    }

    private function getDataExtractionPercentage($totalImported, $unclassifiedQualityAssessment): float
    {
        if ($totalImported === 0) return 0.0;

        $count = new DataExtractionCount();
        $count->mount();
        $count->loadCounters();

        // Leva em consieração os estudos de Seleção de Estudos e o Avaliação de Qualidade que ainda não foram classificados
        $classified = $totalImported - count($count->to_do) - $unclassifiedQualityAssessment;

        return ($classified / $totalImported) * 100;
    }
}
