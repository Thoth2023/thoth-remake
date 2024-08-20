<?php

namespace App\Livewire\Conducting\QualityAssessment;

use App\Models\Project\Conducting\Papers;
use App\Models\StatusQualityAssessment;
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

    #[On('show-success-quality')]
    public function loadStatus()
    {
        $paperStatus = Papers::where('id_paper', $this->paper)
            ->join('status_qa', 'papers.status_qa', '=', 'status_qa.id_status')
            ->select('papers.*', 'status_qa.status as status_description')
            ->first();

        $this->status_description = $paperStatus ? $paperStatus->status_description : 'Unknown';

    }

    public function render()
    {
        return view('livewire.conducting.quality-assessment.paper-status');
    }
}
