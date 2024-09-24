<?php

namespace App\Livewire\Conducting\QualityAssessment;

use App\Models\Member;
use App\Models\Project\Conducting\QualityAssessment\PapersQA;
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
        $member = Member::where('id_user', auth()->user()->id)->first();

        $paperStatus = PapersQA::where('id_paper', $this->paper)
            ->join('status_qa', 'papers_qa.id_status', '=', 'status_qa.id_status')
            ->select('papers_qa.*', 'status_qa.status as status_description')
            ->where('id_member', $member->id_members)  // Filtrando pelo membro
            ->first();

        $this->status_description = $paperStatus ? $paperStatus->status_description : 'Unknown';

    }

    public function render()
    {
        return view('livewire.conducting.quality-assessment.paper-status');
    }
}
