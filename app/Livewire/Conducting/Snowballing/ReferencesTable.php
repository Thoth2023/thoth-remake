<?php

namespace App\Livewire\Conducting\Snowballing;

use App\Models\Project\Conducting\PaperSnowballing;
use Livewire\Attributes\On;
use Livewire\Component;

class ReferencesTable extends Component
{
    public $references = [];
    public $paper_reference_id;

    #[On('show-success-snowballing')]
    #[On('showPaperSnowballing')]
    public function loadReferences()
    {
        if ($this->paper_reference_id) {
            // Filtrar referências pelo paper_reference_id
            $this->references = PaperSnowballing::where('paper_reference_id', $this->paper_reference_id)
                ->orderBy('id', 'ASC')
                ->get();
        } else {
            // Caso não tenha um paper_reference_id, não carrega nada ou carrega todas as referências
            $this->references = [];
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
