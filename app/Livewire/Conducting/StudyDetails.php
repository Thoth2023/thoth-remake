<?php

namespace App\Livewire\Conducting;

use Livewire\Component;

// app/View/Components/SearchInput.php
namespace App\View\Components;

use Illuminate\View\Component;

// app/Http/Livewire/StudyDetails.php
namespace App\Http\Livewire;

use Livewire\Component;

class StudyDetails extends Component
{
    public $study;

    protected $listeners = ['showStudyDetails'];

    public function showStudyDetails($studyId)
    {
        // // Fetch study details by ID
        // $this->study = Study::find($studyId);
        // $this->emit('openModal');
    }

    public function saveStudyDetails()
    {
        // Implement the logic to save study details
        $this->study->save();
        $this->emit('closeModal');
    }

    public function render()
    {
        return view('livewire.study-details');
    }
}
