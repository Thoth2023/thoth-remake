<?php

namespace App\Livewire\Conducting\Snowballing;

use App\Models\Project\Conducting\PaperSnowballing;
use Livewire\Attributes\On;
use Livewire\Component;

class ReferencesTableRelevant extends Component
{
    public $references = [];
    public $parent_snowballing_id;

    public function mount($data = [])
    {
        $this->parent_snowballing_id = $data['parent_snowballing_id'] ?? null;
        $this->loadReferences();
    }

    #[On('update-references-relevant')]
    public function updateReferences($data)
    {
        $this->parent_snowballing_id = $data['parent_snowballing_id'] ?? null;
        $this->loadReferences();
    }

    public function loadReferences()
    {
        if ($this->parent_snowballing_id) {
            $this->references = PaperSnowballing::where('parent_snowballing_id', $this->parent_snowballing_id)
                ->orderByDesc('relevance_score')
                ->orderBy('title')
                ->get();
        } else {
            $this->references = [];
        }
    }

    public function render()
    {
        return view('livewire.conducting.snowballing.references-table-relevant', [
            'references' => $this->references
        ]);
    }
}
