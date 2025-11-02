<?php

namespace App\Livewire\Projects\Public;

use Livewire\Component;
use App\Models\Project;

class ProjectTerms extends Component
{
    public Project $project;

    public function render()
    {
        $terms = $this->project->terms()->with('synonyms')->get();
        $genericString = $this->project->generic_search_string;

        return view('livewire.projects.public.project-terms', compact('terms', 'genericString'));
    }
}
