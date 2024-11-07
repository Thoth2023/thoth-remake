<?php

namespace App\Livewire\Conducting\Snowballing;

use App\Models\Criteria;
use App\Models\EvaluationCriteria;
use App\Models\Member;
use App\Models\Project;
use App\Models\Project\Conducting\Papers;
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

    public function save()
    {

        // Buscar o membro específico para o projeto atual
        $member = Member::where('id_user', auth()->user()->id)
            ->where('id_project', $this->projectId) // Certificar-se de que o membro pertence ao projeto atual
            ->first();
        foreach ($this->selected_criterias as $criteria) {
            EvaluationCriteria::create([
                'id_paper' => $this->paper['id_paper'],
                'id_criteria' => $criteria,
                'id_member' => $member->id_members,
            ]);
        }

        $paper = Papers::where('id_paper', $this->paper['id_paper'])->first();
        $status = StatusSelection::where('description', $this->selected_status)->first();
        $paper->status_selection = $status->id_status;

        $paper->save();
        $this->dispatch('paperSaved', ['message' => 'Paper information updated successfully!', 'type' => 'success']);
        //$this->resetFields();

    }

    #[On('showPaperSnowballing')]
    public function showPaperSnowballing($paper, $criterias)
    {

        $this->criterias = $criterias;
        $this->paper = $paper;

        // Obtém o nome do banco de dados associado ao paper
        $databaseName = DB::table('data_base')
            ->where('id_database', $this->paper['data_base'])
            ->value('name');

        $this->paper['database_name'] = $databaseName;

        // Carrega os critérios já avaliados e marca os checkboxes correspondentes
        $this->selected_criterias = DB::table('evaluation_criteria')
            ->where('id_paper', $this->paper['id_paper'])
            ->pluck('id_criteria')
            ->toArray();

        // Dispara o evento para mostrar o modal
        $this->dispatch('show-paper-snowballing');
    }

    public function changePreSelected($criteriaId, $type)
    {
        // Buscar o membro específico para o projeto atual
        $member = Member::where('id_user', auth()->user()->id)
            ->where('id_project', $this->projectId) // Certificar-se de que o membro pertence ao projeto atual
            ->first();

        if (in_array($criteriaId, $this->selected_criterias)) {
            EvaluationCriteria::create([
                'id_paper' => $this->paper['id_paper'],
                'id_criteria' => $criteriaId,
                'id_member' => $member->id_members,
            ]);

            // Lógica para atualizar o status com base nas regras
            $this->updatePaperStatus($type);

        } else {
            EvaluationCriteria::where('id_paper', $this->paper['id_paper'])
                ->where('id_criteria', $criteriaId)
                ->where('id_member', $member->id_members)
                ->delete();
        }

        // Definir mensagem de sucesso na sessão
        session()->flash('successMessage', 'Criteria updated successfully.');

        // Emitir evento para atualizar o paper-modal e mostrar o modal de sucesso
        //$this->dispatch('updatePaperModal');
        $this->dispatch('show-success-snowballing');

    }

    private function updatePaperStatus($type)
    {

        $id_project = $this->currentProject->id_project;
        $id_paper = $this->paper['id_paper'];
        $old_status = $this->paper['status_selection'];

        $criterias['inclusion'] = Criteria::where('id_project', $id_project)->where('type', 'Inclusion')->get();
        $criterias['exclusion'] = Criteria::where('id_project', $id_project)->where('type', 'Exclusion')->get();
        $criterias_ev = EvaluationCriteria::where('id_paper', $id_paper)->join('criteria', 'evaluation_criteria.id_criteria', '=', 'criteria.id_criteria')
            ->select('evaluation_criteria.*', 'criteria.type')->get();
        $in_rules = Criteria::where('id_project', $id_project)->where('type', 'Inclusion')->distinct()->pluck('rule');
        $ex_rules = Criteria::where('id_project', $id_project)->where('type', 'Exclusion')->distinct()->pluck('rule');
        $inclusion = false;
        $exclusion = false;


        foreach ($in_rules as $in_rule) {

            switch ($in_rule) {
                case 'ALL':
                    if ($criterias['inclusion']->count() == $criterias_ev->where('type', 'Inclusion')->count()) {
                        $inclusion = true;
                    }
                    break;
                case 'AT LEAST':
                    if ($criterias_ev->where('type', 'Inclusion')->count() >= 1) {
                        $inclusion = true;
                    }
                    break;
                case 'ANY':
                    if ($criterias_ev->where('type', 'Inclusion')->count() > 0) {
                        $inclusion = true;
                    }
                    break;
            }
        }

        foreach ($ex_rules as $ex_rule) {
            switch ($ex_rule) {
                case 'ALL':
                    if ($criterias['exclusion']->count() == $criterias_ev->where('type', 'Exclusion')->count()) {
                        $inclusion = false;
                        $exclusion = true;
                    }
                    break;
                case 'AT LEAST':
                    if ($criterias_ev->where('type', 'Exclusion')->count() >= 1) {
                        $exclusion = true;
                        $inclusion = false;
                    }
                    break;
                case 'ANY':
                    if ($criterias_ev->where('type', 'Exclusion')->count() > 0) {
                        $exclusion = true;
                        $inclusion = false;
                    }
                    break;
            }
        }

        $change = false;


        if ($old_status != 4 && $old_status != 5) {
            if ($inclusion && !$exclusion) {
                if ($old_status != 1) {
                    $new_status = 1; // Accepted
                    $change = true;
                }
            } elseif (!$inclusion && $exclusion) {
                if ($old_status != 2) {
                    $new_status = 2; // Rejected
                    $change = true;
                }
            } else {
                if ($old_status != 3) {
                    $new_status = 3; // Unclassified
                    $change = true;
                }
            }
        }

        if ($change) {
            $this->paper['status_selection'] = $new_status;
            Papers::where('id_paper', $id_paper)->update(['status_selection' => $new_status]);
            $this->dispatch('papersUpdated');
        }
    }


    public function render()
    {
        return view('livewire.conducting.snowballing.paper-modal');
    }
}
