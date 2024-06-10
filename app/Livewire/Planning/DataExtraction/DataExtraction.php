<?php

namespace App\Livewire\Planning\DataExtraction;

use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\Project as ProjectModel;
use App\Models\Project\Planning\DataExtraction\Question as QuestionModel;

class DataExtraction extends Component
{
    public $currentProject;
    public $questions = [];

    public function mount()
    {
        $projectId = request()->segment(2);
        $this->currentProject = ProjectModel::findOrFail($projectId);
        $this->questions = QuestionModel::where('id_project', $this->currentProject->id_project)->get();
    }

    #[On('update-table')]
    public function update()
    {
        $this->questions = QuestionModel::where('id_project', $this->currentProject->id_project)->get();
    }

    public function render()
    {
        return view('livewire.planning.data-extraction.data-extraction')
            ->with('questions', $this->questions)
            ->with('project', $this->currentProject);
    }
}