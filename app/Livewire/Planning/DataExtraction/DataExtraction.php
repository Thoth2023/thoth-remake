<?php

namespace App\Livewire\Planning\DataExtraction;

use App\Utils\ToastHelper;
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

    public function editQuestion($data)
    {
        $this->dispatch('data-extraction-table-edit-question', $data['id']);
    }

    public function deleteQuestion($data)
    {
        $this->dispatch('data-extraction-table-delete-question', $data['id']);
    }

    public function editOption($data)
    {
        $this->dispatch('data-extraction-table-edit-option', $data['id_option']);
    }

    public function deleteOption($data)
    {
        $this->dispatch('data-extraction-table-delete-option', $data['id_option']);
    }

    public function render()
    {
        return view('livewire.planning.data-extraction.data-extraction')
            ->with('questions', $this->questions)
            ->with('project', $this->currentProject);
    }
}