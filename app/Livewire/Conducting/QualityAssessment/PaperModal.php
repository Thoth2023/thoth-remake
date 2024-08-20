<?php

namespace App\Livewire\Conducting\QualityAssessment;

use App\Models\EvaluationQA;
use App\Models\Member;
use App\Models\Project;
use App\Models\Project\Conducting\Papers;
use App\Models\Project\Conducting\QualityAssessment\PapersQA;
use App\Models\Project\Planning\QualityAssessment\QualityScore;
use App\Models\Project\Planning\QualityAssessment\Question;
use App\Models\StatusQualityAssessment;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\On;

class PaperModal extends Component
{

    public $currentProject;
    public $projectId;
    public $paper;

    public $questions;

    public $selected_questions_score = [];

    public $selected_status = "None";

    public function mount()
    {
        $this->projectId = request()->segment(2);
        $this->currentProject = Project::findOrFail($this->projectId);

        // Carregar questões e scores
        $this->questions = Question::where('id_project', $this->projectId)
            ->with(['qualityScores' => function ($query) {
                $query->select('id_score', 'score_rule', 'id_qa');
            }])
            ->get();

        // Carregar os scores selecionados previamente
        //$this->loadSelectedScores();
    }

    #[On('showPaperQuality')]
    public function showPaperQuality($paper)
    {
        $member = Member::where('id_user', auth()->user()->id)->first();

        $this->paper = $paper;

        $databaseName = DB::table('data_base')
            ->where('id_database', $this->paper['data_base'])
            ->value('name');

        $this->paper['database_name'] = $databaseName;

        //status selecionado com base no status salvo no banco de dados
        $this->selected_status = $this->paper['status_description'];

        $this->dispatch('show-paper-quality');
    }

    public function updateStatusManual()
    {
        $paper = Papers::where('id_paper', $this->paper['id_paper'])->first();
        $status = StatusQualityAssessment::where('status', $this->selected_status)->first();
        $paper->status_qa = $status->id_status;

        $paper->save();

        session()->flash('successMessage', "Status Quality updated successfully. New status: " . $status->status);
        // Mostra o modal de sucesso
        $this->dispatch('show-success-quality');
    }

    // Método auxiliar para obter a descrição do status
    private function getPaperStatusDescription($status)
    {
        $statusDescriptions = [
            1 => 'Accepted',
            2 => 'Rejected',
            3 => 'Unclassified',
            4 => 'Duplicate',
            5 => 'Removed',
        ];

        return $statusDescriptions[$status] ?? 'Unknown';
    }

    public function updateScore($questionId, $scoreId)
    {
        $member = Member::where('id_user', auth()->user()->id)->first();

            $score_partial = $this->calculateScorePartial($questionId, $scoreId);

            EvaluationQA::updateOrCreate(
                [
                    'id_paper' => $this->paper['id_paper'],
                    'id_qa' => $questionId,
                    'id_member' => $member->id_members,
                    ],
                [
                    'id_score_qa' => $scoreId,
                    'score_partial' => $score_partial,
                    ],
            );

            DB::table('papers_qa_answer')->updateOrInsert(
                [
                    'id_paper' => $this->paper['id_paper'],
                    'id_question' => $questionId,
                ],
                [
                    'id_answer' => $scoreId,
                ],
            );

        //atualizar papers_qa
        $this->updatePaperQaStatus($this->paper['id_paper']);

        session()->flash('successMessage', "Evaluation Quality Score updated successfully.");

        // Se desejar, você pode adicionar uma mensagem de sucesso ou atualizar algum estado
        $this->dispatch('show-success-quality');
    }


    private function calculateScorePartial($questionId, $scoreId)
    {
        $question = Question::find($questionId);
        $scoreRule = QualityScore::find($scoreId);

        if ($question && $scoreRule) {
            $weight = $question->weight;
            $percentage = $scoreRule->score / 100;
            return $weight * $percentage;
        }

        return 0;
    }

    private function loadSelectedScores()
    {
        $evaluations = EvaluationQA::where('id_paper', $this->paper['id_paper'])->get();

        foreach ($evaluations as $evaluation) {
            $this->selected_questions_score[$evaluation->id_qa] = $evaluation->id_score_qa;
        }
    }

    public function updatePaperQaStatus($paperId)
    {
        //Calcular a soma de todos os `score_partial` de `evaluation_qa` para o `id_paper`
        $totalScore = EvaluationQA::where('id_paper', $paperId)
            ->sum('score_partial');

        //Determinar o `id_gen_score` correspondente
        $generalScoreId = $this->findGeneralScoreId($totalScore);

        // Obter o número total de questões para o projeto atual
        $totalQuestions = Question::where('id_project', $this->currentProject->id_project)->count();

        // Obter o número de avaliações feitas para o paper específico
        $answeredQuestions = EvaluationQA::where('id_paper', $paperId)->count();

        // Verificar se todas as questões foram respondidas
        $todasRespostas = ($answeredQuestions === $totalQuestions);

        //Verificar se o score está num intervalo maior ou menor que o cutoff em `qa_cutoff` em general_scores
        $qaCutoff = DB::table('qa_cutoff')
            ->join('general_score', 'qa_cutoff.id_general_score', '=', 'general_score.id_general_score')
            ->where('qa_cutoff.id_project', $this->currentProject->id_project)
            ->select('general_score.start', 'general_score.end', 'qa_cutoff.id_general_score')
            ->first();

        // 1 = Accepted, 2 = Rejected
        $newStatus = ($totalScore >= $qaCutoff->start ) ? 1 : 2;

        //Atualizar `papers_qa`
        PapersQA::where('id_paper', $paperId)->update([
            'score' => $totalScore,
            'id_gen_score' => $generalScoreId,
            'id_status' => $newStatus,
        ]);

        if ($todasRespostas === true) {
            //Atualiza em `papers`
            Papers::where('id_paper', $paperId)->update([
                'score' => $totalScore,
                'id_gen_score' => $generalScoreId,
                'status_qa' => $newStatus,
            ]);
        }
    }
    private function findGeneralScoreId($totalScore)
    {
        return DB::table('general_score')
            ->where('start', '<=', $totalScore)
            ->where('end', '>=', $totalScore)
            ->where('id_project', $this->currentProject->id_project)
            ->value('id_general_score');
    }

    public function render()
    {
        return view('livewire.conducting.quality-assessment.paper-modal', [
            'questions' => $this->questions,
        ]);
    }
}
