<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Note;
use Illuminate\Support\Facades\Auth;

class UserNotes extends Component
{
    public $newNote = '';

    public function saveNote()
    {
        $this->validate([
            'newNote' => 'required|string|max:1000'
        ]);

        Note::create([
            'user_id' => Auth::id(),
            'content' => $this->newNote,
        ]);

        $this->newNote = '';
        session()->flash('message', 'Nota salva com sucesso!');
    }

    public function render()
    {
        $notes = Auth::user()->notes()->latest()->get();

        return view('livewire.user-notes', [
            'notes' => $notes,
        ]);
    }
}
