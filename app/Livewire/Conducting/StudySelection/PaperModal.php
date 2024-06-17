<?php

namespace App\Livewire\Conducting\StudySelection;

use Livewire\Component;
use Livewire\Attributes\On;

class PaperModal extends Component
{

    public $paper;

    protected $listeners = ['showPaper'];

    #[On('showPaper')]
    public function showPaper($paper)
    {
        $this->paper = $paper;
        
        $this->dispatch('openModal');
    }

    public function render()
    {
        return view('livewire.conducting.study-selection.paper-modal');
    }
}
