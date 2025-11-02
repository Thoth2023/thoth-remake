<?php

namespace App\Livewire\Projects\Public;

use Livewire\Component;
use App\Models\Project;

class Criterias extends Component
{
    public $project;

    public function mount(Project $project)
    {
        $this->project = $project;
    }

    public function render()
    {
        $inclusion = $this->project->criterias()
            ->where('type', 'Inclusion')
            ->orderBy('id_criteria')
            ->get();

        $exclusion = $this->project->criterias()
            ->where('type', 'Exclusion')
            ->orderBy('id_criteria')
            ->get();

        return view('livewire.projects.public.criterias', compact('inclusion', 'exclusion'));
    }
}
