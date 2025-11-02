<?php

namespace App\Livewire\Projects\Public;

use Livewire\Component;
use App\Models\Project;

class ProjectInfo extends Component
{
    public $project;

    public function mount(Project $project)
    {
        $this->project = $project;
    }

    public function render()
    {
        return view('livewire.projects.public.project-info');
    }
}
