<?php

namespace App\Livewire\Conducting\Snowballing;

use App\Models\Project;
use App\Models\Project\Conducting\PaperSnowballing;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;

class PaperModalRelevant extends Component
{
    public $currentProject;
    public $projectId;
    public $paper = null;
    public $doi;

    public function mount()
    {
        $this->projectId = request()->segment(2);
        $this->currentProject = Project::findOrFail($this->projectId);
    }

    #[On('showPaperSnowballingRelevant')]
    public function showPaperSnowballingRelevant($paper)
    {
        $this->paper = $paper;
        $this->doi = $paper['doi'] ?? null;

        //
        $this->paper['database_name'] = $paper['source'] ?? __('project/conducting.snowballing.table.none');

        // Atualiza as referências relacionadas (por parent_snowballing_id)
        $this->dispatch('update-references-relevant', [
            'parent_snowballing_id' => $this->paper['id'] ?? null,
        ]);

        $this->dispatch('show-paper-snowballing-relevant');
    }

    public function render()
    {
        return view('livewire.conducting.snowballing.paper-modal-relevant');
    }
}
