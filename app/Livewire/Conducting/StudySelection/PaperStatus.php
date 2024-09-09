<?php

namespace App\Livewire\Conducting\StudySelection;

use App\Models\Member;
use App\Models\Project\Conducting\Papers;
use App\Models\Project\Conducting\StudySelection\PapersSelection;
use App\Models\StatusSelection;
use Livewire\Attributes\On;
use Livewire\Component;

class PaperStatus extends Component
{
    public $paper;
    public $status_description;
    public $paperStatus;

    public function mount($paper)
    {
        $this->paper = $paper;
        $this->loadStatus();
    }

    #[On('show-success')]
    public function loadStatus()
    {
        $member = Member::where('id_user', auth()->user()->id)->first();

        $paperStatus = PapersSelection::where('id_paper', $this->paper)
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
