<?php

namespace App\Livewire\Planning\Questions;

use Livewire\Component;
use App\Models\Project;
use App\Models\ResearchQuestion;

class Show extends Component
{
    public $project;
    
    public function mount(Project $project)
    {
        $this->project = $project;
    }

    public function render()
    {
        $questions = ResearchQuestion::where('id_project', $this->project->id_project)->get();
        
        return view('livewire.planning.questions.show', [
            'questions' => $questions
        ]);
    }
}
