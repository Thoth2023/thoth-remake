<?php

namespace App\Livewire\Conducting\QualityAssessment;

use App\Models\Member;
use App\Models\Project;
use App\Models\Project\Conducting\QualityAssessment\PapersQA;
use App\Models\Project\Conducting\StudySelection\PaperDecisionConflict;
use App\Models\StatusQualityAssessment;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\On;

class PaperModalConflicts extends Component
{
    public $currentProject;
    public $projectId;
    public $paper = null;
    public $membersWithEvaluations = [];
    public $note;
    public $selected_status = null;
    public $lastConfirmedBy = null;
    public $lastConfirmedAt = null;

    protected $rules = [
        'selected_status' => 'required',
    ];

    public function mount()
    {
        $this->projectId = request()->segment(2);
        $this->currentProject = Project::findOrFail($this->projectId);
    }

    #[On('showPaperConflictQuality')]
    public function showPaperConflictsQuality($paper)
    {
        $this->paper = $paper;
        $this->paperDecision = PaperDecisionConflict::where('id_paper', $this->paper['id_paper'])
            ->where('phase', 'quality') // Filtrar pela fase QA
            ->firstOrNew([]);

        // Carregar a nota do banco de dados (se houver)
        $this->note = $this->paperDecision->note ?? '';

        // Carregar o status atual do paper
        $this->selected_status = $this->paperDecision->new_status_paper ?: 'None';

        // Verificar quem realizou a última confirmação e quando
        if ($this->paperDecision->exists) {
            $this->lastConfirmedBy = Member::find($this->paperDecision->id_member);
            $this->lastConfirmedAt = $this->paperDecision->updated_at;
        } else {
            $this->lastConfirmedBy = null;
            $this->lastConfirmedAt = null;
        }

        // Carregar nome da base de dados
        $databaseName = DB::table('data_base')
            ->where('id_database', $this->paper['data_base'])
            ->value('name');

        $this->paper['database_name'] = $databaseName;

        $this->loadMembersWithEvaluations();

        $this->dispatch('show-paper-quality-conflict');
    }

    // Método para carregar membros e suas avaliações QA
    protected function loadMembersWithEvaluations()
    {
        // Buscar todos os membros e suas avaliações (papers_qa) para o projeto e o paper atual
        $this->membersWithEvaluations = Member::where('members.id_project', $this->projectId)
            ->leftJoin('users', 'members.id_user', '=', 'users.id')
            ->leftJoin('papers_qa', 'members.id_members', '=', 'papers_qa.id_member')
            ->leftJoin('general_score', 'papers_qa.id_gen_score', '=', 'general_score.id_general_score')
            ->leftJoin('status_qa', 'papers_qa.id_status', '=', 'status_qa.id_status')
            ->where('papers_qa.id_paper', $this->paper['id_paper'])
            ->orderBy('members.level', 'ASC') // Ordenar os administradores primeiro
            ->get([
                'members.id_members',
                'members.level',
                'users.firstname',
                'users.lastname',
                'papers_qa.score',
                'general_score.description AS general_score',
                'status_qa.status AS status'
            ])
            ->map(function ($member) {
                // Agrupar manualmente as informações do membro e suas avaliações
                return [
                    'firstname' => $member->firstname,
                    'lastname' => $member->lastname,
                    'level' => $member->level,
                    'score' => $member->score,
                    'general_score' => $member->general_score ?? 'N/A',
                    'status' => $member->status ?? 'None',
                ];
            });
    }

    public function save()
    {
        // Buscar o membro específico para o projeto atual
        $member = Member::where('id_user', auth()->user()->id)
            ->where('id_project', $this->projectId) // Certificar-se de que o membro pertence ao projeto atual
            ->first();
        $paper = PapersQA::where('id_paper', $this->paper['id_paper'])->first();

        // Obter o status atual e novo
        $oldStatus = $paper->id_status;
        $newStatus = StatusQualityAssessment::where('id_status', $this->selected_status)->first();

        if (!$newStatus) {
            session()->flash('errorMessage', __('project/conducting.quality-assessment.resolve.error-status'));
            $this->dispatch('show-success-conflicts-quality');
            return;
        }

        // Atualizar ou criar a decisão do paper QA
        $decision = PaperDecisionConflict::updateOrCreate(
            [
                'id_paper' => $this->paper['id_paper'],
                'phase' => 'quality',
            ],
            [
                'id_member' => $member->id_members,
                'old_status_paper' => $oldStatus,  //status da avaliação do administrador na tabela papers
                'new_status_paper' => $newStatus->id_status,
                'note' => $this->note,
            ]
        );

        session()->flash('successMessage', __('project/conducting.quality-assessment.resolve.success-decision'));
        $this->dispatch('show-success-conflicts-quality');
    }

    public function render()
    {
        return view('livewire.conducting.quality-assessment.paper-modal-conflicts');
    }
}
