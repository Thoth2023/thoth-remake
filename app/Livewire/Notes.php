<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Note;
use Illuminate\Support\Facades\Auth;

class Notes extends Component
{
    public $note;
    public $notes;

    public function mount()
    {
        $this->notes = Auth::user()->notes()->latest()->get();
    }

    public function saveNote()
    {
        $this->validate([
            'note' => 'required|string|max:1000',
        ]);

        Note::create([
            'user_id' => Auth::id(),
            'content' => $this->note,
        ]);

        $this->note = '';
        $this->notes = Auth::user()->notes()->latest()->get();
    }

    public function render()
    {
        return view('livewire.notes');
    }
}
