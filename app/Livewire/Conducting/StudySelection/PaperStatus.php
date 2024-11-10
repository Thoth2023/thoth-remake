<?php

namespace App\Livewire\Conducting\StudySelection;

use App\Models\Member;
use App\Models\Project;
use App\Models\Project\Conducting\Papers;
use App\Models\Project\Conducting\StudySelection\PapersSelection;
use App\Models\StatusSelection;
use Livewire\Attributes\On;
use Livewire\Component;

class PaperStatus extends Component
{

    public $currentProject;
    public $projectId;
    public $paperId;
    public $status_description;
    public $paperStatus;

    public function mount($paperId,$projectId)
    {
        $this->projectId = $projectId; // Usar o projectId passado diretamente
        $this->currentProject = Project::find($this->projectId);

        $this->paper = $paperId;
        $this->loadStatus();
    }

    #[On('refreshPaperStatus')]
    public function loadStatus()
    {

        // Buscar o membro específico para o projeto atual
        $member = Member::where('id_user', auth()->user()->id)
            ->where('id_project',$this->currentProject->id_project) // Certificar-se de que o membro pertence ao projeto atual
            ->first();

        $paperStatus = PapersSelection::where('id_paper', $this->paperId)
            ->join('status_selection', 'papers_selection.id_status', '=', 'status_selection.id_status')
            ->select('status_selection.description as status_description')
            ->where('papers_selection.id_member', $member->id_members)
            ->first();

        $this->status_description = $paperStatus ? $paperStatus->status_description : 'Unknown';

    }

    public function render()
    {
        return view('livewire.conducting.study-selection.paper-status');
    }
}
