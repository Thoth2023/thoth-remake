<?php

namespace App\Livewire\Conducting\DataExtraction;

use App\Models\Project\Conducting\Papers;
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

    #[On('show-success-extraction')]
    public function loadStatus()
    {
        $paperStatus = Papers::where('id_paper', $this->paper)
            ->join('status_extraction', 'papers.status_extraction', '=', 'status_extraction.id_status')
            ->select('papers.*', 'status_extraction.description as status_description')
            ->first();
        $this->status_description = $paperStatus ? $paperStatus->status_description : 'Unknown';
    }

    public function render()
    {
        return view('livewire.conducting.data-extraction.paper-status');
    }
}
