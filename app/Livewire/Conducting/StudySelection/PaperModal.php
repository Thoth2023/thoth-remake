<?php

namespace App\Livewire\Conducting\StudySelection;


use App\Models\Criteria;
use App\Models\EvaluationCriteria;
use App\Models\Member;
use App\Models\Project;
use App\Models\Project\Conducting\Papers;
use App\Models\Project\Conducting\StudySelection\PapersSelection;
use App\Models\ProjectDatabases;
use App\Models\StatusSelection;
use Illuminate\Pagination\LengthAwarePaginator;
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
    public $paper = null;
    public $canEdit = false;

    public $criterias;

    public $selected_criterias = [];
    public $temp_selected_criterias = [];

    public $selected_status = "None";
    public $note;

    public function mount()
    {
        $this->projectId = request()->segment(2);
        $this->currentProject = Project::findOrFail($this->projectId);

    }
    #[On('showPaper')]
    public function showPaper($paper, $criterias)
    {

        $this->canEdit = $this->userCanEdit();

        // Ordenar critérios: Inclusion primeiro (ordenado por ID), depois Exclusion (ordenado por ID)
        $this->criterias = collect($criterias)
            ->sortBy([
                fn ($a, $b) => $a['type'] === $b['type']
                    ? strnatcmp($a['id'], $b['id'])
                    : ($a['type'] === 'Inclusion' ? -1 : 1),
            ])
            ->values()
            ->toArray();

        // Se showPaper for chamado com o ID do paper, carrega o objeto e converte para array
        // Se o paper for passado como um array de dados, usa o id_paper
        $paperId = is_array($paper) ? $paper['id_paper'] : $paper;

        if (!$paperId) {
            Log::error('showPaper called without a valid paper ID or data.');
            return;
        }

        $this->paper = Papers::where('id_paper', $paperId)->first()->toArray();

        $databaseName = DB::table('data_base')
            ->where('id_database', $this->paper['data_base'])
            ->value('name');

        $this->paper['database_name'] = $databaseName ?? 'Unknown';

        // Buscar o membro específico para o projeto atual
        $member = Member::where('id_user', auth()->user()->id)
            ->where('id_project', $this->projectId)
            ->first();

        //carregar todos os critérios de uma vez
        $this->selected_criterias = EvaluationCriteria::where('id_paper', $this->paper['id_paper'])
            ->where('id_member', $member->id_members)
            ->pluck('id_criteria')
            ->toArray();

        $this->temp_selected_criterias = $this->selected_criterias;

        //status selecionado com base no status salvo no banco de dados
        $this->selected_status = $this->getPaperStatusDescription($this->paper['status_selection']);

        // Carregar a nota existente
        $paperSelection = PapersSelection::where('id_paper', $this->paper['id_paper'])
            ->where('id_member', $member->id_members)
            ->first();
        $this->note = $paperSelection ? $paperSelection->note : '';

        $this->dispatch('show-paper');
    }

    public function updateStatusManual()
    {
        // Buscar o membro específico para o projeto atual
        $member = Member::where('id_user', auth()->user()->id)
            ->where('id_project', $this->projectId) // Certificar-se de que o membro pertence ao projeto atual
            ->first();

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
            session()->forget('successMessage');
            session()->flash('successMessage', "Status updated in both Papers and PapersSelection. New status: " . $status->description);
        } else {
            session()->forget('successMessage');
            session()->flash('successMessage', "Status updated for your selection. New status: " . $status->description);
        }

        // Mostra o modal de sucesso
        $this->dispatch('show-success');
        $this->dispatch('refreshPaperStatus');
    }

    public function saveNote()
    {
        // Buscar o membro específico para o projeto atual
        $member = Member::where('id_user', auth()->user()->id)
            ->where('id_project', $this->projectId) // Certificar-se de que o membro pertence ao projeto atual
            ->first();

        // Verifica se já existe uma seleção de paper para o membro e paper atual
        $paperSelection = PapersSelection::where('id_paper', $this->paper['id_paper'])
            ->where('id_member', $member->id_members)
            ->first();

        if (!$paperSelection) {
            // Se não existir uma seleção, cria uma nova entrada
            $paperSelection = new PapersSelection();
            $paperSelection->id_paper = $this->paper['id_paper'];
            $paperSelection->id_member = $member->id_members;
        }

        // Atualiza a nota
        $paperSelection->note = $this->note;
        $paperSelection->save();

        session()->forget('successMessage');
        session()->flash('successMessage', 'Nota salva com sucesso.');
        // Mostra o modal de sucesso
        $this->dispatch('show-success');
        $this->dispatch('refreshPaperStatus');
    }

    public function saveSelectedCriterias()
    {
        // Buscar o membro específico para o projeto atual
        $member = Member::where('id_user', auth()->user()->id)
            ->where('id_project', $this->projectId)
            ->first();

        // Encontrar critérios que foram desmarcados
        $removedCriterias = array_diff($this->selected_criterias, $this->temp_selected_criterias);

        // Encontrar critérios que foram marcados
        $addedCriterias = array_diff($this->temp_selected_criterias, $this->selected_criterias);

        // Remover critérios desmarcados
        foreach ($removedCriterias as $criteriaId) {
            EvaluationCriteria::where('id_paper', $this->paper['id_paper'])
                ->where('id_criteria', $criteriaId)
                ->where('id_member', $member->id_members)
                ->delete();
        }

        // Adicionar novos critérios marcados
        foreach ($addedCriterias as $criteriaId) {
            EvaluationCriteria::create([
                'id_paper' => $this->paper['id_paper'],
                'id_criteria' => $criteriaId,
                'id_member' => $member->id_members,
            ]);
        }

        // Atualizar selected_criterias com os valores temporários
        $this->selected_criterias = $this->temp_selected_criterias;

        // Atualizar o status do paper
        $criterias = Criteria::whereIn('id_criteria', $this->selected_criterias)->get();
        foreach ($criterias as $criteria) {
            $this->updatePaperStatus($criteria->type);
        }

        session()->flash('successMessage', 'Critérios salvos com sucesso');
        $this->dispatch('show-success');
        $this->dispatch('refreshPaperStatus');

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


    private function updatePaperStatus($type)
    {
        // Buscar o membro específico para o projeto atual
        $member = Member::where('id_user', auth()->user()->id)
            ->where('id_project', $this->projectId) // Certificar-se de que o membro pertence ao projeto atual
            ->first();

        $id_project = $this->currentProject->id_project;
        $id_paper = $this->paper['id_paper'];
        $old_status = $this->paper['status_selection'];

        // Obter todos os critérios e regras de uma só vez
        $criterias = Criteria::where('id_project', $id_project)->get()->groupBy('type');
        $criterias_ev = EvaluationCriteria::where('id_paper', $id_paper)
            ->join('criteria', 'evaluation_criteria.id_criteria', '=', 'criteria.id_criteria')
            ->select('evaluation_criteria.*', 'criteria.type')
            ->where('id_member', $member->id_members)
            ->get()
            ->groupBy('type');

        $inclusion = $this->checkCriteriaRules($criterias['Inclusion'] ?? collect(), $criterias_ev['Inclusion'] ?? collect());
        $exclusion = $this->checkCriteriaRules($criterias['Exclusion'] ?? collect(), $criterias_ev['Exclusion'] ?? collect());

        $new_status = $this->determineNewStatus($inclusion, $exclusion, $old_status);

        if ($new_status !== $old_status) {
            // Atualiza o status no objeto atual
            $this->paper['status_selection'] = $new_status;

            // Atualização na tabela papers_selection
            $paperSelection = PapersSelection::where('id_paper', $id_paper)
                ->where('id_member', $member->id_members)
                ->first();

            if (!$paperSelection) {
                // Se não existir uma seleção para o paper e membro, cria uma nova entrada
                $paperSelection = new PapersSelection();
                $paperSelection->id_paper = $id_paper;
                $paperSelection->id_member = $member->id_members;
            }

            // Atualiza o status em papers_selection
            $paperSelection->id_status = $new_status;
            $paperSelection->save();

            // Se o membro for um administrador, também atualiza na tabela papers
            if ($member->level == 1) {
                Papers::where('id_paper', $id_paper)->update(['status_selection' => $new_status]);
            }
            // 🔥 Recarrega o paper atualizado
            $this->paper = Papers::where('id_paper', $id_paper)->first()->toArray();
            $this->paper['database_name'] = DB::table('data_base')
                ->where('id_database', $this->paper['data_base'])
                ->value('name') ?? '';

            session()->forget('successMessage');
            session()->flash('successMessage', "Status updated successfully.");
        }
    }


    private function checkCriteriaRules($criterias, $criterias_ev)
    {
        foreach ($criterias->pluck('rule')->unique() as $rule) {
            switch ($rule) {
                case 'ALL':
                    if ($criterias->count() == $criterias_ev->count()) {
                        return true;
                    }
                    break;
                case 'AT LEAST':
                    if ($criterias_ev->count() >= 1) {
                        return true;
                    }
                    break;
                case 'ANY':
                    if ($criterias_ev->count() > 0) {
                        return true;
                    }
                    break;
            }
        }
        return false;
    }

    private function determineNewStatus($inclusion, $exclusion, $old_status)
    {
        if ($inclusion && !$exclusion) {
            return 1; // Accepted
        } elseif (!$inclusion && $exclusion) {
            return 2; // Rejected
        } elseif ($inclusion && $exclusion) {
            return 2; // Rejected
        } else {
            return 3; // Unclassified
        }
    }


    public function nextPaper()
    {
        // Obtém o próximo paper baseado na ordem atual
        $nextPaper = Papers::where('id_paper', '>', $this->paper['id_paper'])
            ->where('data_base', $this->paper['data_base'])
            ->orderBy('id_paper')
            ->first();

        if ($nextPaper) {
            // Mostra o próximo
            $this->showPaper($nextPaper, $this->criterias);
        } else {
            session()->flash('errorMessage', 'No more papers available.');
            $this->dispatch('notify', message: 'No more papers available.', type: 'warning');
        }
    }

    public function previousPaper()
    {
        $previousPaper = Papers::where('id_paper', '<', $this->paper['id_paper'])
            ->where('data_base', $this->paper['data_base'])
            ->orderByDesc('id_paper')
            ->first();

        if ($previousPaper) {
            $this->showPaper($previousPaper, $this->criterias);
        } else {
            session()->flash('errorMessage', 'This is the first paper.');
            $this->dispatch('notify', message: 'This is the first paper.', type: 'info');
        }
    }


    public function render()
    {
        return view('livewire.conducting.study-selection.paper-modal');
    }
}
