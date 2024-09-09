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
    public $note = null;
    public $selected_status = "None";

    public function mount()
    {
        $this->projectId = request()->segment(2);
        $this->currentProject = Project::findOrFail($this->projectId);

    }
    #[On('showPaperConflict')]
    public function showPaperConflicts($paper)
    {
        $this->paper = $paper;

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



    public function submit()
    {
        $member = Member::where('id_user', auth()->user()->id)->first();
        $paper = Papers::where('id_paper', $this->paper['id_paper'])->first();

        // Obter o old_status_paper do campo 'status_selection' da tabela 'Papers'
        $oldStatus = $paper->status_selection;
        // Obter o novo status selecionado pelo usuário através da variável 'selected_status'
        $newStatus = StatusSelection::where('description', $this->selected_status)->first();

        // Criar ou atualizar o registro na tabela PaperDecisionConflict
        $decision = PaperDecisionConflict::updateOrCreate(
        // Condições para buscar um registro existente
            [
                'id_paper' => $this->paper['id_paper'],
                'id_member' => $member->id_members,
                'phase' => 'study-selection',
            ],
            // Valores que serão atualizados ou inseridos
            [
                'old_status_paper' => $oldStatus,
                'new_status_paper' => $newStatus->description, // Usando a descrição do novo status selecionado
                'note' => $this->note, // O conteúdo da nota do editor de texto
            ]
        );

        // Debugging: verificar o resultado da operação
        dd($decision);

        session()->flash('successMessage', 'Note and status saved successfully.');

        // Exibir o modal de sucesso
        $this->dispatch('show-success');
    }

    public function submitNote()
    {
        // Emitir o evento para capturar o valor do Quill no frontend
        $this->dispatch('submit-note');

        // Adicionar um pequeno delay para garantir que o valor foi atualizado
        usleep(200000); // 200ms

        // Agora o valor 'note' será capturado corretamente
        $this->submit(); // Chamando o método submit que já trata o salvamento
    }


    public function updateStatusManual()
    {
        $member = Member::where('id_user', auth()->user()->id)->first();

        // Pega o paper associado
        $paper = Papers::where('id_paper', $this->paper['id_paper'])->first();

        // Pega o status selecionado
        $status = StatusSelection::where('description', $this->selected_status)->first();

        // Atualiza na tabela papers_selection
        $paperSelection = PapersSelection::where('id_paper', $this->paper['id_paper'])
            ->where('id_member', $member->id_members)
            ->first();

        if (!$paperSelection) {
            // Se não existir uma seleção para o paper e membro, cria uma nova entrada
            $paperSelection = new PapersSelection();
            $paperSelection->id_paper = $this->paper['id_paper'];
            $paperSelection->id_member = $member->id_members;
        }

        // Atualiza o status em papers_selection
        $paperSelection->id_status = $status->id_status;
        $paperSelection->save();

        // Se o membro for um administrador, também atualiza na tabela papers
        if ($member->level == 1) {
            $paper->status_selection = $status->id_status;
            $paper->save();

            session()->flash('successMessage', "Status updated in both Papers and PapersSelection. New status: " . $status->description);
        } else {
            session()->flash('successMessage', "Status updated for your selection. New status: " . $status->description);
        }

        // Mostra o modal de sucesso
        $this->dispatch('show-success');
    }


    public function render()
    {
        return view('livewire.conducting.study-selection.paper-modal-conflicts');
    }
}
