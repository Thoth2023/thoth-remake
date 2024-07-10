<?php

namespace App\Livewire\Conducting;

use Livewire\Component;

// app/View/Components/ProgressBar.php
namespace App\View\Components;

use Illuminate\View\Component;

class ProgressBar extends Component
{
    public $progress;

    public function __construct($progress = 0)
    {
        $this->progress = $progress;

    }

    public function mount()
    {
        $this->progress = 0; 
        
    }

    public function render()
    {
        return view('livewire.conducting.progress-bar', compact('progress'));
    }
}
