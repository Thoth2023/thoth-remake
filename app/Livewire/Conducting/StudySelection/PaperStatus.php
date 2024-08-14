<?php

namespace App\Livewire\Conducting\StudySelection;

use App\Models\Project\Conducting\Papers;
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
        $paperStatus = Papers::where('id_paper', $this->paper)
            ->join('status_selection', 'papers.status_selection', '=', 'status_selection.id_status')
            ->select('papers.*', 'status_selection.description as status_description')
            ->first();

        $this->status_description = $paperStatus ? $paperStatus->status_description : 'Unknown';

    }

    public function render()
    {
        return view('livewire.conducting.study-selection.paper-status');
    }
}
