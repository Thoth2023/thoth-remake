<?php

namespace App\Livewire\Conducting\StudySelection;

use Livewire\Component;
use Livewire\Attributes\On;

class PaperModal extends Component
{

    public $paper;


    #[On('showPaper')]
    public function showPaper($paper)
    {
        $this->paper = Papers::findOrFail($paper['id']);
        $this->dispatch('showPaperModal');
    }

    public function evaluatePaper($paperId, $inclusion, $exclusion)
{
    $paper = Papers::findOrFail($paperId);
    $paper->criteria_inclusion = $inclusion;
    $paper->criteria_exclusion = $exclusion;

    if ($inclusion) {
        $paper->status_selection = StatusSelection::where('description', 'Accepted')->first()->id_status;
    } elseif ($exclusion) {
        $paper->status_selection = StatusSelection::where('description', 'Rejected')->first()->id_status;
    }
    $paper->save();

    $this->dispatch('closePaperModal');
}

    public function render()
    {
        return view('livewire.conducting.study-selection.paper-modal');
    }
}
