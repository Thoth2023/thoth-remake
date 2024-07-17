<?php

namespace App\Livewire\Conducting\StudySelection;

use App\Models\EvaluationCriteria;
use App\Models\Member;
use App\Models\Project\Conducting\Papers;
use App\Models\StatusSelection;
use Livewire\Component;
use Livewire\Attributes\On;

class PaperModal extends Component
{

    public $paper;

    public $criterias;

    public $selected_criterias = [];

    public $selected_status = "None";

    public function save()
    {
        $member = Member::where('id_user', auth()->user()->id)->first();
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
    }

    #[On('showPaper')]
    public function showPaper($paper, $criterias)
    {
        $this->criterias = $criterias;
        $this->paper = $paper;
        $this->dispatch('show-paper');
    }

    public function render()
    {
        return view('livewire.conducting.study-selection.paper-modal');
    }
}
