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
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\On;

class PaperModal extends Component
{

    public $currentProject;
    public $projectId;
    public $paper = null;

    public $criterias;

    public $selected_criterias = [];

    public $selected_status = "None";

    public function mount()
    {
        $this->projectId = request()->segment(2);
        $this->currentProject = Project::findOrFail($this->projectId);

    }


    #[On('showPaper')]
    public function showPaper($paper, $criterias)
    {
        $this->criterias = $criterias;
        $this->paper = $paper;

        $databaseName = DB::table('data_base')
            ->where('id_database', $this->paper['data_base'])
            ->value('name');

        $this->paper['database_name'] = $databaseName;

        $member = Member::where('id_user', auth()->user()->id)->first();

        //carregar todos os critérios de uma vez
        $this->selected_criterias = EvaluationCriteria::where('id_paper', $this->paper['id_paper'])
            ->where('id_member', $member->id_members)
            ->pluck('id_criteria')
            ->toArray();

        //status selecionado com base no status salvo no banco de dados
        $this->selected_status = $this->paper['status_description'];

        $this->dispatch('show-paper');
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



    public function changePreSelected($criteriaId, $type)
    {
        $member = Member::where('id_user', auth()->user()->id)->first();
        $isSelected = in_array($criteriaId, $this->selected_criterias);

        if ($isSelected) {
            EvaluationCriteria::create([
                'id_paper' => $this->paper['id_paper'],
                'id_criteria' => $criteriaId,
                'id_member' => $member->id_members,
            ]);
        } else {
            EvaluationCriteria::where('id_paper', $this->paper['id_paper'])
                ->where('id_criteria', $criteriaId)
                ->where('id_member', $member->id_members)
                ->delete();
        }

        $this->updatePaperStatus($type);

        session()->flash('successMessage', "Criteria updated successfully. New status: " . $this->getPaperStatusDescription($this->paper['status_selection']));

        // Atualiza a view para mostrar o alert
        $this->dispatch('show-success');
        $this->dispatch('reload-papers');
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
        // Verificar membro
        $member = Member::where('id_user', auth()->user()->id)->first();

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

    public function render()
    {
        return view('livewire.conducting.study-selection.paper-modal');
    }
}
