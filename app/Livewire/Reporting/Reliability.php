<?php

namespace App\Livewire\Reporting;

use App\Models\Criteria;
use App\Models\EvaluationCriteria;
use App\Models\EvaluationQA;
use App\Models\Project;
use App\Models\Project\Conducting\Papers;
use App\Models\Project\Conducting\QualityAssessment\PapersQA;
use App\Models\Project\Conducting\StudySelection\PapersSelection;
use App\Models\Project\Planning\QualityAssessment\Question;
use Livewire\Component;
use Livewire\WithPagination;

class Reliability extends Component
{
    use WithPagination;

    public $currentProject;
    public $projectId;
    public $studySelectionAgreement;
    public $qualityAssessmentAgreement;
    public $studySelectionAgreementkappa;
    public $qualityAssessmentAgreementkappa;

    public function mount()
    {
        $this->projectId = request()->segment(2);
        $this->currentProject = Project::findOrFail($this->projectId);

        // Calcular a porcentagem de concordância
        $this->studySelectionAgreement = $this->calculateStudySelectionAgreement();
        $this->qualityAssessmentAgreement = $this->calculateQualityAssessmentAgreement();
        $this->studySelectionAgreementkappa = $this->calculateStudySelectionKappa();
        $this->qualityAssessmentAgreementkappa = $this->calculateQualityAssessmentKappa();

    }

    private function calculateStudySelectionAgreement()
    {
        // Obter os IDs de papers relacionados ao projeto através dos relacionamentos
        $papersIds = Papers::whereHas('bibUpload', function ($query) {
            $query->whereIn('id_project_database', function ($subQuery) {
                $subQuery->select('id_project_database')
                    ->from('project_databases')
                    ->where('id_project', $this->projectId);
            });
        })->pluck('id_paper');

        // Buscar os dados de seleção de estudos apenas para os papers relacionados ao projeto
        $papersSelections = PapersSelection::whereIn('id_paper', $papersIds)->get();
        $agreement = 0;
        $totalPapers = $papersSelections->groupBy('id_paper')->count();

        // Calcular o grau de concordância para cada paper
        foreach ($papersSelections->groupBy('id_paper') as $group) {
            // Contar quantos status diferentes existem para o mesmo id_paper
            $statusCount = $group->groupBy('id_status')->count();

            // Se todos os membros concordaram no mesmo status, então statusCount será 1
            if ($statusCount === 1) {
                $agreement++;
            }
        }

        // Calcular a porcentagem de concordância
        return $totalPapers > 0 ? ($agreement / $totalPapers) * 100 : 0;
    }

    private function calculateQualityAssessmentAgreement()
    {
        // Obter os IDs de papers relacionados ao projeto através dos relacionamentos
        $papersIds = Papers::whereHas('bibUpload', function ($query) {
            $query->whereIn('id_project_database', function ($subQuery) {
                $subQuery->select('id_project_database')
                    ->from('project_databases')
                    ->where('id_project', $this->projectId);
            });
        })->pluck('id_paper');

        // Buscar os dados de avaliação de qualidade apenas para os papers relacionados ao projeto
        $papersQA = PapersQA::whereIn('id_paper', $papersIds)->get();
        $agreement = 0;
        $totalPapersQA = $papersQA->groupBy('id_paper')->count();

        // Calcular o grau de concordância para cada paper
        foreach ($papersQA->groupBy('id_paper') as $group) {
            $statusCount = $group->groupBy('id_status')->count();
            if ($statusCount === 1) {
                $agreement++;
            }
        }

        // Calcular a porcentagem de concordância
        return $totalPapersQA > 0 ? ($agreement / $totalPapersQA) * 100 : 0;
    }


    public function calculateStudySelectionkappa()
    {
        $criterias = Criteria::where('id_project', $this->projectId)->get();

        $agreements = [];
        $totalPapers = 0;

        foreach ($criterias as $criteria) {
            $evaluations = EvaluationCriteria::where('id_criteria', $criteria->id_criteria)->get();
            $observedAgreement = 0;
            $expectedAgreement = 0;
            $groupedEvaluations = $evaluations->groupBy('id_paper');

            foreach ($groupedEvaluations as $paperId => $paperEvaluations) {
                $totalPapers++;
                $memberEvaluations = $paperEvaluations->groupBy('id_member');

                if ($memberEvaluations->count() === 2) {
                    $firstEvaluator = $memberEvaluations->first();
                    $secondEvaluator = $memberEvaluations->last();

                    if ($firstEvaluator->pluck('id_criteria')->sort()->values()->toArray() === $secondEvaluator->pluck('id_criteria')->sort()->values()->toArray()) {
                        $observedAgreement++;
                    }

                    $p1 = $firstEvaluator->count() / $totalPapers;
                    $p2 = $secondEvaluator->count() / $totalPapers;
                    $expectedAgreement += $p1 * $p2;
                }
            }

            if ($totalPapers > 0 && (1 - $expectedAgreement) !== 0) { // Verificação para evitar divisão por zero
                $P_O = $observedAgreement / $totalPapers;
                $P_E = $expectedAgreement / $totalPapers;
                $kappa = ($P_O - $P_E) / (1 - $P_E);
            } else {
                $kappa = 0; // Ou outro valor padrão, como `null`, dependendo do que fizer sentido no seu caso
            }

            $agreements[] = [
                'criteria' => $criteria->description,
                'kappa' => $kappa
            ];
        }

        return $agreements;
    }


    public function calculateQualityAssessmentkappa()
    {
        $questions = Question::where('id_project', $this->projectId)->get();

        $agreements = [];
        $totalPapers = 0;

        foreach ($questions as $question) {
            $evaluations = EvaluationQA::where('id_qa', $question->id_qa)->get();
            $observedAgreement = 0;
            $expectedAgreement = 0;
            $groupedEvaluations = $evaluations->groupBy('id_paper');

            foreach ($groupedEvaluations as $paperId => $paperEvaluations) {
                $totalPapers++;
                $memberEvaluations = $paperEvaluations->groupBy('id_member');

                if ($memberEvaluations->count() === 2) {
                    $firstEvaluator = $memberEvaluations->first();
                    $secondEvaluator = $memberEvaluations->last();

                    if ($firstEvaluator->pluck('id_score_qa')->sort()->values()->toArray() === $secondEvaluator->pluck('id_score_qa')->sort()->values()->toArray()) {
                        $observedAgreement++;
                    }

                    $p1 = $firstEvaluator->count() / $totalPapers;
                    $p2 = $secondEvaluator->count() / $totalPapers;
                    $expectedAgreement += $p1 * $p2;
                }
            }

            if ($totalPapers > 0 && (1 - $expectedAgreement) !== 0) { // Verificação para evitar divisão por zero
                $P_O = $observedAgreement / $totalPapers;
                $P_E = $expectedAgreement / $totalPapers;
                $kappa = ($P_O - $P_E) / (1 - $P_E);
            } else {
                $kappa = 0; // Ou outro valor padrão
            }

            $agreements[] = [
                'question' => $question->description,
                'kappa' => $kappa
            ];
        }

        return $agreements;
    }


    public function render()
    {
        return view('livewire.reporting.reliability', [
            'studySelectionAgreement' => $this->studySelectionAgreement,
            'qualityAssessmentAgreement' => $this->qualityAssessmentAgreement,
            'studySelectionAgreementkappa' => $this->studySelectionAgreementkappa,
            'qualityAssessmentAgreementkappa' => $this->qualityAssessmentAgreementkappa,
        ]);
    }

}
