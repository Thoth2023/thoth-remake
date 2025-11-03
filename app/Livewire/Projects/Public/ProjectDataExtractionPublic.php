<?php

namespace App\Livewire\Projects\Public;

use App\Models\Project;
use App\Models\Project\Planning\DataExtraction\Question;
use Livewire\Component;

class ProjectDataExtractionPublic extends Component
{
    public $project;
    public $questions = [];

    public function mount(Project $project)
    {
        $this->project = $project;

        $this->questions = Question::with('options', 'question_type')
            ->where('id_project', $project->id_project)
            ->get() ?? collect();
    }

    public function render()
    {
        return view('livewire.projects.public.project-data-extraction-public');
    }
}
