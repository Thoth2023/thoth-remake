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
        $this->currentProject = Project::findOrFail($this->projectId);

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
        $this->resetState();

        // Buscar o membro específico para o projeto atual
        $member = Member::where('id_user', auth()->user()->id)
            ->where('id_project', $this->projectId)
            ->first();

        $this->paper = $paper;

        $databaseName = DB::table('data_base')
            ->where('id_database', $this->paper['data_base'])
            ->value('name');

        $this->paper['database_name'] = $databaseName;
        $this->selected_status = $this->paper['status_description'];

        // Carregar a nota existente
        $paperQA = PapersQA::where('id_paper', $this->paper['id_paper'])
            ->where('id_member', $member->id_members)
            ->first();
        $this->note = $paperQA ? $paperQA->note : '';

        // Carregar scores anteriores
        $this->loadSelectedScores();

        // Exibe modal
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
        $member = Member::where('id_user', auth()->user()->id)
            ->where('id_project', $this->projectId)
            ->first();

        $paper = Papers::find($this->paper['id_paper']);
        $papers_qa = PapersQA::firstOrNew([
            'id_paper' => $this->paper['id_paper'],
            'id_member' => $member->id_members,
        ]);

        $status = StatusQualityAssessment::where('status', $this->selected_status)->first();

        $paper->status_qa = $status->id_status;
        $papers_qa->id_status = $status->id_status;
        $papers_qa->save();

        if ($member->level == 1) {
            $paper->status_selection = $status->id_status;
            $paper->save();
        }

        session()->flash('successMessage', __("project/conducting.quality-assessment.messages.status_quality_updated", [
            'status' => $status->status
        ]));

        $this->selected_status = $status->status;
        $this->dispatch('show-success-quality');
    }

    /**
     * Calcula o score parcial de uma questão.
     */
    private function calculateScorePartial($questionId, $scoreId)
    {
        // Busca a questão pelo ID
        $question = Question::find($questionId);
        // Busca a regra de score pelo ID — forçando o retorno de um único registro
        $scoreRule = QualityScore::where('id_score', $scoreId)->first();

        if ($question && $scoreRule) {
            $weight = $question->weight;
            $percentage = floatval($scoreRule->score ?? 0) / 100;
            return $weight * $percentage;
        }
        // Caso algum dado não exista, retorna 0
        return 0;
    }


    /**
     * Atualiza um único score (usado nos selects individuais).
     */
    public function updateScore($questionId, $scoreId)
    {
        // Buscar membro do projeto
        $member = Member::where('id_user', auth()->user()->id)
            ->where('id_project', $this->projectId)
            ->first();

        $score_partial = $this->calculateScorePartial($questionId, $scoreId);

        // Atualiza ou cria o registro de avaliação individual
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

        // Atualiza status e recarrega
        $this->updatePaperQaStatus($this->paper['id_paper']);
        $this->loadSelectedScores();

        session()->flash('successMessage', __("project/conducting.quality-assessment.messages.evaluation_quality_score_updated"));
        $this->dispatch('reload-paper-modal');
        $this->dispatch('show-success-quality', 'Score atualizado com sucesso.');
        $this->dispatch('show-success-quality-score');
    }

    /**
     * Aplica todos as pontuações de uma só vez (botão "Aplicar/Salvar Pontuações").
     */
    public function applyScores()
    {
        $member = Member::where('id_user', auth()->user()->id)
            ->where('id_project', $this->projectId)
            ->first();

        //todas as questões devem ter pontuação selecionada
        $missing = [];
        foreach ($this->questions as $question) {
            if (empty($this->selected_questions_score[$question->id_qa])) {
                $missing[] = $question->id;
            }
        }

        if (!empty($missing)) {
            $this->dispatch('paper-quality-toast', [
                'message' => __("project/conducting.quality-assessment.messages.missing_scores", [
                    'count' => count($missing),
                ]),
                'type' => 'error'
            ]);

            return; // Interrompe o salvamento
        }

        //Prossegue com o salvamento normal
        foreach ($this->selected_questions_score as $questionId => $scoreId) {
            if (is_array($scoreId) && isset($scoreId['value'])) {
                $scoreId = $scoreId['value'];
            }

            // Garantir que seja numérico
            $scoreId = (int) $scoreId;

            $score_partial = $this->calculateScorePartial($questionId, $scoreId);

            logger()->info("Aplicando score:", [
                'questionId' => $questionId,
                'scoreId' => $scoreId,
                'score_partial' => $score_partial,
            ]);

            EvaluationQA::updateOrCreate(
                [
                    'id_paper' => $this->paper['id_paper'],
                    'id_qa' => $questionId,
                    'id_member' => $member->id_members,
                ],
                [
                    'id_score_qa' => $scoreId,
                    'score_partial' => $score_partial,
                ]
            );

            DB::table('papers_qa_answer')->updateOrInsert(
                [
                    'id_paper' => $this->paper['id_paper'],
                    'id_question' => $questionId,
                ],
                [
                    'id_answer' => $scoreId,
                ]
            );
        }

        // Atualiza status e recarrega
        $this->updatePaperQaStatus($this->paper['id_paper']);
        $this->loadSelectedScores();

        session()->flash('successMessage', __("project/conducting.quality-assessment.messages.evaluation_quality_score_updated"));
        $this->dispatch('reload-paper-modal');
        $this->dispatch('show-success-quality', 'Pontuações aplicadas com sucesso.');
        $this->dispatch('show-success-quality-score');
    }


    /**
     * Atualiza o status geral do paper com base no score acumulado.
     */
    public function updatePaperQaStatus($paperId)
    {
        $member = Member::where('id_user', auth()->user()->id)
            ->where('id_project', $this->projectId)
            ->first();

        // Soma total das pontuações
        $totalScore = EvaluationQA::where('id_paper', $paperId)
            ->where('id_member', $member->id_members)
            ->sum('score_partial');

        $generalScoreId = $this->findGeneralScoreId($totalScore);

        $totalQuestions = Question::where('id_project', $this->currentProject->id_project)->count();
        $answeredQuestions = EvaluationQA::where('id_paper', $paperId)
            ->where('id_member', $member->id_members)
            ->count();
        $todasRespostas = ($answeredQuestions === $totalQuestions);

        // Avaliação de cada questão comparada ao mínimo
        $scores = DB::table('evaluation_qa')
            ->join('question_quality', 'evaluation_qa.id_qa', '=', 'question_quality.id_qa')
            ->join('score_quality as sq1', 'evaluation_qa.id_score_qa', '=', 'sq1.id_score')
            ->join('score_quality as sq2', 'sq2.id_score', '=', 'question_quality.min_to_app')
            ->where('evaluation_qa.id_paper', $paperId)
            ->where('id_member', $member->id_members)
            ->select('sq1.score as score_selecionado', 'sq2.score as score_min_to_app')
            ->get();

        $belowMinScore = false;
        foreach ($scores as $score) {
            if ($score->score_selecionado < $score->score_min_to_app) {
                $belowMinScore = true;
                break;
            }
        }

        // Obter cutoff configurado
        $qaCutoff = DB::table('qa_cutoff')
            ->join('general_score', 'qa_cutoff.id_general_score', '=', 'general_score.id_general_score')
            ->where('qa_cutoff.id_project', $this->currentProject->id_project)
            ->select('general_score.start', 'general_score.end')
            ->first();

        // Determina novo status
        $newStatus = ($totalScore >= $qaCutoff->start && !$belowMinScore) ? 1 : 2;

        // Atualiza SEMPRE papers_qa
        PapersQA::updateOrCreate(
            [
                'id_paper' => $paperId,
                'id_member' => $member->id_members,
            ],
            [
                'score' => $totalScore,
                'id_gen_score' => $generalScoreId,
                'id_status' => $todasRespostas ? $newStatus : 2, // 🔸 Rejeitado se incompleto
            ]
        );

        // Atualiza SEMPRE o papers também (não depende de $todasRespostas)
        if ($member->level == 1) {
            Papers::where('id_paper', $paperId)->update([
                'score' => $totalScore,
                'id_gen_score' => $generalScoreId,
                'status_qa' => $newStatus, // 🔸 Sempre atualiza status
            ]);
        }

        logger()->info("Status QA atualizado", [
            'paper_id' => $paperId,
            'total_score' => $totalScore,
            'status' => $newStatus,
            'todasRespostas' => $todasRespostas,
            'belowMinScore' => $belowMinScore
        ]);
    }


    /**
     * Localiza o intervalo correto do score geral.
     */
    private function findGeneralScoreId($totalScore)
    {
        if ($totalScore === 0 || $totalScore < DB::table('general_score')
                ->where('id_project', $this->currentProject->id_project)
                ->min('start')) {

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
     * Carrega os scores já atribuídos às questões do paper.
     */
    private function loadSelectedScores()
    {
        $member = Member::where('id_user', auth()->user()->id)
            ->where('id_project', $this->projectId)
            ->first();

        $evaluations = EvaluationQA::where('id_paper', $this->paper['id_paper'])
            ->where('id_member', $member->id_members)
            ->get(['id_qa', 'id_score_qa']);

        $this->selected_questions_score = [];

        foreach ($evaluations as $evaluation) {
            $this->selected_questions_score[$evaluation->id_qa] = $evaluation->id_score_qa;
        }

        logger()->info('Scores carregados do banco:', $this->selected_questions_score);
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
