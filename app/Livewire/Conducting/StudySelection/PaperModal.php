<?php

namespace App\Livewire\Conducting\StudySelection;


use App\Jobs\AtualizarDadosCrossref;
use App\Jobs\AtualizarDadosSpringer;
use Illuminate\Support\Facades\Cache;
use GuzzleHttp\Client;
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


class PaperModal extends Component
{

    public $currentProject;
    public $projectId;
    public $paper = null;

    public $criterias;

    public $selected_criterias = [];

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
        $this->criterias = $criterias;
        $this->paper = $paper;

        $databaseName = DB::table('data_base')
            ->where('id_database', $this->paper['data_base'])
            ->value('name');

        $this->paper['database_name'] = $databaseName;

        // Buscar o membro específico para o projeto atual
        $member = Member::where('id_user', auth()->user()->id)
            ->where('id_project', $this->projectId) // Certificar-se de que o membro pertence ao projeto atual
            ->first();

        //carregar todos os critérios de uma vez
        $this->selected_criterias = EvaluationCriteria::where('id_paper', $this->paper['id_paper'])
            ->where('id_member', $member->id_members)
            ->pluck('id_criteria')
            ->toArray();

        //status selecionado com base no status salvo no banco de dados
        $this->selected_status = $this->paper['status_description'];

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

            session()->flash('successMessage', "Status updated in both Papers and PapersSelection. New status: " . $status->description);
        } else {
            session()->flash('successMessage', "Status updated for your selection. New status: " . $status->description);
        }

        // Mostra o modal de sucesso
        $this->dispatch('show-success');
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

        session()->flash('successMessage', 'Nota salva com sucesso.');
        // Mostra o modal de sucesso
        $this->dispatch('show-success');
    }

    public function changePreSelected($criteriaId, $type)
    {
        // Buscar o membro específico para o projeto atual
        $member = Member::where('id_user', auth()->user()->id)
            ->where('id_project', $this->projectId) // Certificar-se de que o membro pertence ao projeto atual
            ->first();
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

    public function refreshPaperData()
    {
        $paper = Papers::find($this->paper['id_paper'])->toArray();
        $criterias = $this->criterias; // Preserva os critérios atuais

        $this->showPaper($paper, $criterias); // Reutiliza a lógica de `showPaper` para atualizar dados do modal
    }

    public function atualizarDadosFaltantes()
    {
        if (empty($this->paper['doi']) && empty($this->paper['title'])) {
            session()->flash('errorMessage', 'DOI ou título do paper necessário para buscar dados.');
            $this->dispatch('show-success');
            return;
        }

        // Log para verificar o ID e DOI antes de despachar o Job
        Log::info("Despachando Job para paper ID {$this->paper['id_paper']}, DOI: {$this->paper['doi']} e Título: {$this->paper['title']}");

        AtualizarDadosCrossref::dispatch(
            $this->paper['id_paper'],
            $this->paper['doi'],
            $this->paper['title']
        );

        session()->flash('successMessage', 'A atualização dos dados está em andamento. Verifique mais tarde.');
        $this->dispatch('show-success');
        $this->dispatch('refresh-paper');
    }


    private function processarDadosCrossref($paperData)
    {
        $paper = Papers::find($this->paper['id_paper']);
        if ($paper) {
            $paper->abstract = $paper->abstract ?: ($paperData['abstract'] ?? '');
            $paper->keywords = $paper->keywords ?: (isset($paperData['subject']) ? implode(', ', $paperData['subject']) : '');
            if (empty($paper->doi) && isset($paperData['DOI'])) {
                $paper->doi = $paperData['DOI'];
            }
            $paper->save();
            $this->paper['abstract'] = $paper->abstract;
            $this->paper['keywords'] = $paper->keywords;
            $this->paper['doi'] = $paper->doi;
        }
    }

    public function atualizarDadosSpringer()
    {
        if (empty($this->paper['doi'])) {
            session()->flash('errorMessage', 'DOI necessário para buscar dados via Springer.');
            $this->dispatch('show-success');
            return;
        }

        Log::info("Despachando Job para atualização via Springer para paper ID {$this->paper['id_paper']}");

        AtualizarDadosSpringer::dispatch(
            $this->paper['id_paper'],
            $this->paper['doi']
        );

        session()->flash('successMessage', 'A atualização dos dados via Springer está em andamento. Verifique mais tarde.');
        $this->dispatch('show-success');
        $this->dispatch('refresh-paper');
    }



    public function render()
    {
        return view('livewire.conducting.study-selection.paper-modal');
    }
}
