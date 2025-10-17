<?php

namespace App\Livewire\Conducting\Snowballing;

use App\Models\Project\Conducting\PaperSnowballing;
use Livewire\Attributes\On;
use Livewire\Component;

class ReferencesTable extends Component
{
    public $references = [];
    public $paper_reference_id;

    public $backwardCount = 0;
    public $forwardCount = 0;

    public function mount($data = [])
    {
        $this->paper_reference_id = $data['paper_reference_id'] ?? null;
        $this->loadReferences();
    }

    #[On('update-references')]
    public function updateReferences($data)
    {
        $this->paper_reference_id = $data['paper_reference_id'] ?? null;
        $this->loadReferences();
    }

    #[On('show-success-snowballing')]
    #[On('showPaperSnowballing')]
    public function loadReferences()
    {
        if ($this->paper_reference_id) {
            $this->references = PaperSnowballing::where('paper_reference_id', $this->paper_reference_id)
                ->orderByDesc('relevance_score')
                ->orderByDesc('duplicate_count')
                ->orderBy('title')
                ->get();

            $this->backwardCount = PaperSnowballing::where('paper_reference_id', $this->paper_reference_id)
                ->where('type_snowballing', 'backward')
                ->count();

            $this->forwardCount = PaperSnowballing::where('paper_reference_id', $this->paper_reference_id)
                ->where('type_snowballing', 'forward')
                ->count();
        } else {
            $this->references = [];
            $this->backwardCount = 0;
            $this->forwardCount = 0;
        }
    }

    public function toggleRelevance($id)
    {
        $reference = PaperSnowballing::find($id);
        if (!$reference) return;

        // Alterna relevância (toggle)
        $reference->is_relevant = $reference->is_relevant ? false : true;
        $reference->save();

        // Mensagem multilíngue de sucesso
        $this->dispatch('success-relevant-paper', [
            'message' => __('project/conducting.snowballing.messages.relevance_updated', [], app()->getLocale())
                ?? __('project/conducting.snowballing.messages.manual_done', ['type' => 'Relevance']),
            'type' => 'success'
        ]);

        $this->loadReferences();
    }

    public function render()
    {
        return view('livewire.conducting.snowballing.references-table', [
            'references' => $this->references,
            'backwardCount' => $this->backwardCount,
            'forwardCount' => $this->forwardCount,
        ]);
    }
}
