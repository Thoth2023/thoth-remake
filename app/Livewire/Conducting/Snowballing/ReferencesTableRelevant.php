<?php

namespace App\Livewire\Conducting\Snowballing;

use App\Models\Project\Conducting\PaperSnowballing;
use Livewire\Attributes\On;
use Livewire\Component;

class ReferencesTableRelevant extends Component
{
    public $references = [];

    public $backwardCount = 0;
    public $forwardCount = 0;
    public $parent_snowballing_id;

    public function mount($data = [])
    {
        $this->parent_snowballing_id = $data['parent_snowballing_id'] ?? null;
        $this->loadReferences();
    }

    #[On('update-references-relevant')]
    public function updateReferences($data)
    {
        $this->parent_snowballing_id = $data['parent_snowballing_id'] ?? $this->parent_snowballing_id;
        $this->loadReferences();
    }
    #[On('show-success-snowballing-relevant')]
    #[On('showPaperSnowballingRelevant')]
    public function loadReferences()
    {
        if ($this->parent_snowballing_id) {
            $this->references = PaperSnowballing::where('parent_snowballing_id', $this->parent_snowballing_id)
                ->orderByDesc('relevance_score')
                ->orderByDesc('duplicate_count')
                ->orderBy('title')
                ->get();
            $this->backwardCount = PaperSnowballing::where('paper_reference_id', $this->parent_snowballing_id)
                ->where('type_snowballing', 'backward')
                ->count();

            $this->forwardCount = PaperSnowballing::where('paper_reference_id', $this->parent_snowballing_id)
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

        // alterna relevância
        $reference->is_relevant = $reference->is_relevant ? false : true;
        $reference->save();

        // notificação
        $this->dispatch('snowballing-relevant-toast', [
            'message' => __('project/conducting.snowballing.messages.relevance_updated'),
            'type'    => 'success'
        ]);
        $this->dispatch('success-relevant-paper');

        // recarrega lista
        $this->loadReferences();

        // caso a tabela pai use contadores, podemos futuramente disparar evento p/ atualizar
        // mas por enquanto não precisa
    }

    public function render()
    {
        return view('livewire.conducting.snowballing.references-table-relevant', [
            'references' => $this->references
        ]);
    }
}
