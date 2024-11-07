<?php

namespace App\Livewire\Conducting\StudySelection;

use App\Models\Member;
use App\Models\Project;
use App\Models\Project\Conducting\Papers;
use App\Models\Project\Conducting\StudySelection\PaperDecisionConflict;
use App\Models\Project\Conducting\StudySelection\PapersSelection;
use App\Models\StatusSelection;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\On;

class PaperModalConflicts extends Component
{

    public $currentProject;
    public $projectId;
    public $paper = null;
    public $membersWithEvaluations = [];
    public $criterias = [];
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
    #[On('showPaperConflict')]
    public function showPaperConflicts($paper)
    {
        $this->paper = $paper;
        // Carregar decisão de conflito na fase 'qa'
        $this->paperDecision = PaperDecisionConflict::where('id_paper', $this->paper['id_paper'])
            ->where('phase', 'study-selection') // Filtrar pela fase QA
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

        $databaseName = DB::table('data_base')
            ->where('id_database', $this->paper['data_base'])
            ->value('name');

        $this->paper['database_name'] = $databaseName;

        $this->loadMembersWithEvaluations();

        $this->dispatch('show-paper-conflict');
    }

    // Método para carregar membros e suas avaliações
    protected function loadMembersWithEvaluations()
    {
        $this->membersWithEvaluations = Member::where('id_project', $this->projectId)
            ->with([
                'user',
                'papers_selection' => function ($query) {
                    $query->where('id_paper', $this->paper['id_paper'])
                        ->with('status'); // Carregar o relacionamento de status
                },
                'evaluation_criteria' => function ($query) {
                    $query->where('id_paper', $this->paper['id_paper']);
                },
                'evaluation_criteria.criteria' // Carregando a relação com Criteria dentro de EvaluationCriteria
            ])
            ->orderBy('level', 'ASC') // Administradores (level 1) primeiro
            ->get()
            ->map(function ($member) {
                // Carregar o status de PapersSelection para o paper atual e membro atual
                $status = $member->papers_selection->first();

                return [
                    'member' => $member,
                    'criteria' => $member->evaluation_criteria->map->criteria,
                    'status' => $status && $status->status ? $status->status->description : 'None',
                ];
            });
    }

    public function save()
    {

        // Buscar o membro específico para o projeto atual
        $member = Member::where('id_user', auth()->user()->id)
            ->where('id_project', $this->projectId) // Certificar-se de que o membro pertence ao projeto atual
            ->first();
        $paper = Papers::where('id_paper', $this->paper['id_paper'])->first();

        // Obter o old_status_paper do campo 'status_selection' da tabela 'Papers'
        $oldStatus = $paper->status_selection;

        // Obter o novo status selecionado pelo usuário através da variável 'selected_status'
        $newStatus = StatusSelection::where('id_status', $this->selected_status)->first();

        // Certifique-se de que $newStatus foi encontrado
        if (!$newStatus) {
            session()->flash('errorMessage', __('project/conducting.study-selection.modal.error-status'));
            // Mostrar o modal de erro
            $this->dispatch('show-success-conflicts');
            return;
        }
        // Criar ou atualizar o registro na tabela PaperDecisionConflict
        $decision = PaperDecisionConflict::updateOrCreate(
            [
                'id_paper' => $this->paper['id_paper'],
                'phase' => 'study-selection',
            ],
            [

                'id_member' => $member->id_members,
                'old_status_paper' => $oldStatus,
                'new_status_paper' => $newStatus->id_status,
                'note' => $this->note,
            ]
        );

        // Atualizar o status_selection na tabela Papers
        $paper->status_selection = $newStatus->id_status;
        $paper->save();

        session()->flash('successMessage', __('project/conducting.study-selection.modal.sucess-decision'));


        // Exibir o modal de sucesso
        $this->dispatch('show-success-conflicts');
    }



    public function render()
    {
        return view('livewire.conducting.study-selection.paper-modal-conflicts');
    }
}
