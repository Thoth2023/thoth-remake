<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class SnowballingLookup extends Component
{
    public $doi;
    public $references = [];
    public $citations = [];

    public function fetch()
    {
        $response = Http::get("https://api.semanticscholar.org/graph/v1/paper/DOI:{$this->doi}", [
            'fields' => 'title,references.title,citations.title'
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $this->references = $data['references'] ?? [];
            $this->citations = $data['citations'] ?? [];
        } else {
            session()->flash('error', 'Erro ao buscar o DOI.');
        }
    }

    public function render()
    {
        return view('livewire.snowballing-lookup');
    }
}
