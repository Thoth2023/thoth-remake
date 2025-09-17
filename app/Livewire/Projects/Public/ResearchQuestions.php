<?php

namespace App\Livewire\Projects\Public;

use Livewire\Component;
use App\Models\Project;
use App\Models\ResearchQuestion;


class ResearchQuestions extends Component
{
    public $project;

    public function mount(Project $project)
    {
        $this->project = $project;
    }

    public function render()
    {
        $questions = ResearchQuestion::where('id_project', $this->project->id_project)->get();

        return view('livewire.projects.public.research-questions',[
            'questions' => $questions
        ]);
    }


}
