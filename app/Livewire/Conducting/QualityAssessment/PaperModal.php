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
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Traits\ProjectPermissions;

class PaperModal extends Component
{
    use ProjectPermissions;

    public $currentProject;
    public $projectId;
    public $paper;
    public $canEdit = false;
    public $questions;
    public $selected_questions_score = [];
    public $selected_status = "None";
    public $note;

    /**
     * Método de inicialização do componente.
     * Carrega o projeto atual e as questões com seus respectivos scores.
     */
    public function mount()
    {
        $this->projectId = request()->segment(2);
        $this->currentProject = Project::find($this->projectId); // Mantém como objeto Eloquent

        $this->questions = Question::where('id_project', $this->projectId)
            ->with(['qualityScores' => function ($query) {
                $query->select('id_score', 'score_rule', 'id_qa');
            }])
            ->get();
    }

    /**
     * Limpa o estado do componente entre avaliações.
     */
    public function resetState()
    {
        $this->paper = null;
        $this->selected_questions_score = [];
        $this->selected_status = "None";
        $this->note = null;
    }

    /**
     * Evento disparado para exibir o modal de avaliação de qualidade.
     */
    #[On('showPaperQuality')]
    public function showPaperQuality($paper)
    {
        $this->canEdit = $this->userCanEdit();

        // Reinicia o estado interno
        $this->resetState();

        // Obtém o membro associado ao projeto atual
        $member = Member::where('id_user', auth()->user()->id)
            ->where('id_project', $this->projectId)
            ->first();

        $this->paper = $paper;

        // Carrega o nome do banco de dados da referência
        $databaseName = DB::table('data_base')
            ->where('id_database', $this->paper['data_base'])
            ->value('name');

        $this->paper['database_name'] = $databaseName;

        // Define o status inicial do paper com base no banco
        $this->selected_status = $this->paper['status_description'];

        // Carrega nota anterior, caso exista
        $paperQA = PapersQA::where('id_paper', $this->paper['id_paper'])
            ->where('id_member', $member->id_members)
            ->first();
        $this->note = $paperQA ? $paperQA->note : '';

        // Carrega os scores previamente atribuídos
        $this->loadSelectedScores();

        // Exibe o modal de avaliação
        $this->dispatch('show-paper-quality');
    }

    /**
     * Salva a nota associada ao paper avaliado.
     */
    public function saveNote()
    {
        $member = Member::where('id_user', auth()->user()->id)
            ->where('id_project', $this->projectId)
            ->first();

        $paperQA = PapersQA::firstOrNew([
            'id_paper' => $this->paper['id_paper'],
            'id_member' => $member->id_members,
        ]);

        $paperQA->note = $this->note;
        $paperQA->save();

        session()->flash('successMessage', 'Nota salva com sucesso.');
        $this->dispatch('show-success-quality');
    }

    /**
     * Atualiza manualmente o status do paper (Ex: Removido, Não Classificado).
     */
    public function updateStatusManual()
    {
        // Garante que o projeto está carregado
        if (!$this->currentProject || !$this->currentProject->id_project) {
            $this->currentProject = Project::find($this->projectId);
        }

        $member = Member::where('id_user', auth()->user()->id)
            ->where('id_project', $this->projectId)
            ->first();

        $paper = Papers::find($this->paper['id_paper']);
        $papers_qa = PapersQA::firstOrNew([
            'id_paper' => $this->paper['id_paper'],
            'id_member' => $member->id_members,
        ]);

        $status = StatusQualityAssessment::where('status', $this->selected_status)->first();

        // Atualiza os status
        $paper->status_qa = $status->id_status;
        $papers_qa->id_status = $status->id_status;
        $papers_qa->save();

        // Se for administrador, reflete no status geral da tabela papers
        if ($member->level == 1) {
            $paper->status_selection = $status->id_status;
            $paper->save();
        }

        session()->flash('successMessage', __("project/conducting.quality-assessment.messages.status_quality_updated", [
            'status' => $status->status
        ]));

        // Atualiza o estado local e reativa o componente
        $this->selected_status = $status->status;
        $this->dispatch('show-success-quality');
    }

    /**
     * Calcula a nota parcial de uma questão específica.
     */
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

    /**
     * Retorna a descrição textual de um status QA com base no seu ID.
     */
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

    /**
     * Atualiza o score e recalcula o status geral do paper.
     */
    public function updateScore($questionId, $scoreId)
    {
        if (!$this->currentProject) {
            $this->currentProject = Project::find($this->projectId);
        }

        $member = Member::where('id_user', auth()->user()->id)
            ->where('id_project', $this->projectId)
            ->first();

        $score_partial = $this->calculateScorePartial($questionId, $scoreId);

        // Atualiza ou cria o registro da avaliação de QA
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

        // Atualiza tabela auxiliar
        DB::table('papers_qa_answer')->updateOrInsert(
            [
                'id_paper' => $this->paper['id_paper'],
                'id_question' => $questionId,
            ],
            [
                'id_answer' => $scoreId,
            ],
        );

        // Atualiza status geral
        $this->updatePaperQaStatus($this->paper['id_paper']);

        // Recarrega os scores do componente
        $this->loadSelectedScores();

        session()->flash('successMessage', __("project/conducting.quality-assessment.messages.evaluation_quality_score_updated"));

        // Atualiza o componente filho QualityScore
        $this->dispatch('reload-paper-modal');
        // Mostra mensagem de sucesso
        $this->dispatch('show-success-quality', 'Score atualizado com sucesso.');
    }

    /**
     * Atualiza o status geral do paper com base no score acumulado.
     */
    public function updatePaperQaStatus($paperId)
    {
        if (!$this->currentProject || !$this->currentProject->id_project) {
            $this->currentProject = Project::find($this->projectId);
        }

        $member = Member::where('id_user', auth()->user()->id)
            ->where('id_project', $this->projectId)
            ->first();

        // Soma total dos scores parciais
        $totalScore = EvaluationQA::where('id_paper', $paperId)
            ->where('id_member', $member->id_members)
            ->sum('score_partial');

        $generalScoreId = $this->findGeneralScoreId($totalScore);

        // Total de questões respondidas vs. total de questões
        $totalQuestions = Question::where('id_project', $this->currentProject->id_project)->count();
        $answeredQuestions = EvaluationQA::where('id_paper', $paperId)
            ->where('id_member', $member->id_members)
            ->count();
        $todasRespostas = ($answeredQuestions === $totalQuestions);

        // Verificação de notas abaixo do mínimo
        $scores = DB::table('evaluation_qa')
            ->join('question_quality', 'evaluation_qa.id_qa', '=', 'question_quality.id_qa')
            ->join('score_quality as sq1', 'evaluation_qa.id_score_qa', '=', 'sq1.id_score')
            ->join('score_quality as sq2', 'sq2.id_score', '=', 'question_quality.min_to_app')
            ->where('evaluation_qa.id_paper', $paperId)
            ->where('id_member', $member->id_members)
            ->select('sq1.score as score_selecionado', 'sq2.score as score_min_to_app')
            ->get();

        $belowMinScore = $scores->contains(fn($s) => $s->score_selecionado < $s->score_min_to_app);

        // Determina se o paper é aceito ou rejeitado
        $qaCutoff = DB::table('qa_cutoff')
            ->join('general_score', 'qa_cutoff.id_general_score', '=', 'general_score.id_general_score')
            ->where('qa_cutoff.id_project', $this->currentProject->id_project)
            ->select('general_score.start', 'general_score.end')
            ->first();

        $newStatus = ($totalScore >= $qaCutoff->start && !$belowMinScore) ? 1 : 2; // 1 = Aceito, 2 = Rejeitado

        // Atualiza dados nas tabelas correspondentes
        if ($generalScoreId && DB::table('general_score')->where('id_general_score', $generalScoreId)->exists()) {
            PapersQA::where('id_paper', $paperId)
                ->where('id_member', $member->id_members)
                ->update([
                    'score' => $totalScore,
                    'id_gen_score' => $generalScoreId,
                    'id_status' => $todasRespostas ? $newStatus : null,
                ]);

            if ($todasRespostas && $member->level == 1) {
                Papers::where('id_paper', $paperId)->update([
                    'score' => $totalScore,
                    'id_gen_score' => $generalScoreId,
                    'status_qa' => $newStatus,
                ]);
            }
        } else {
            Log::warning("generalScoreId inválido ou inexistente para o score total: $totalScore (paper_id: $paperId)");
        }

        // Atualiza status local e recarrega visualmente
        $this->selected_status = $this->getPaperStatusDescription($newStatus);
    }

    /**
     * Localiza o intervalo correto do score geral.
     */
    private function findGeneralScoreId($totalScore)
    {
        $minScore = DB::table('general_score')
            ->where('id_project', $this->currentProject->id_project)
            ->min('start');

        if ($totalScore === 0 || $totalScore < $minScore) {
            return DB::table('general_score')
                ->where('id_project', $this->currentProject->id_project)
                ->orderBy('start', 'asc')
                ->value('id_general_score');
        }

        return DB::table('general_score')
            ->where('start', '<=', $totalScore)
            ->where('end', '>=', $totalScore)
            ->where('id_project', $this->currentProject->id_project)
            ->value('id_general_score');
    }

    /**
     * Carrega as respostas já atribuídas às questões do paper.
     */
    private function loadSelectedScores()
    {
        $member = Member::where('id_user', auth()->user()->id)
            ->where('id_project', $this->projectId)
            ->first();

        $evaluations = EvaluationQA::where('id_paper', $this->paper['id_paper'])
            ->where('id_member', $member->id_members)
            ->get();

        foreach ($evaluations as $evaluation) {
            $this->selected_questions_score[$evaluation->id_qa] = $evaluation->id_score_qa;
        }
    }

    /**
     * Renderiza o componente.
     */
    public function render()
    {
        return view('livewire.conducting.quality-assessment.paper-modal', [
            'questions' => $this->questions,
        ]);
    }
}
