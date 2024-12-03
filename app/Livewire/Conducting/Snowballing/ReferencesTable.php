<?php

namespace App\Livewire\Conducting\Snowballing;

use App\Models\Project\Conducting\PaperSnowballing;
use Livewire\Attributes\On;
use Livewire\Component;

class ReferencesTable extends Component
{
    public $references = [];
    public $paper_reference_id;

    public $backwardCount = 0; // Contador para Backward
    public $forwardCount = 0;  // Contador para Forward

    #[On('update-references')]
    public function updateReferences($data)
    {
        $this->paper_reference_id = $data['paper_reference_id'] ?? null;
        $this->loadReferences(); // Recarregar as referências com o novo ID
    }

    #[On('show-success-snowballing')]
    #[On('showPaperSnowballing')]
    public function loadReferences()
    {
        if ($this->paper_reference_id) {
            // Filtrar referências pelo paper_reference_id
            $this->references = PaperSnowballing::where('paper_reference_id', $this->paper_reference_id)
                ->orderBy('id', 'ASC')
                ->get();

            // Atualizar contadores de tipos
            $this->backwardCount = PaperSnowballing::where('paper_reference_id', $this->paper_reference_id)
                ->where('type_snowballing', 'backward')
                ->count();

            $this->forwardCount = PaperSnowballing::where('paper_reference_id', $this->paper_reference_id)
                ->where('type_snowballing', 'forward')
                ->count();
        } else {
            // Caso não tenha um paper_reference_id, não carrega nada ou carrega todas as referências
            $this->references = [];
            $this->backwardCount = 0;
            $this->forwardCount = 0;
        }
    }

    public function toggleRelevance($id)
    {
        $reference = PaperSnowballing::find($id);

        if ($reference->is_relevant === null) {
            $reference->is_relevant = true; // Se não avaliado, define como Sim
        } else {
            $reference->is_relevant = !$reference->is_relevant; // Alterna entre true e false
        }

        $reference->save();

        $this->dispatch('success', ['message' => 'Relevância atualizada!', 'type' => 'success']);
        $this->loadReferences(); // Recarrega a lista de referências
    }

    public function render()
    {
        return view('livewire.conducting.snowballing.references-table', [
            'references' => $this->references,
        ]);
    }
}
