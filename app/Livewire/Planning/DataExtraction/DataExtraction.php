<?php

namespace App\Livewire\Planning\DataExtraction;

use App\Utils\CheckProjectDataPlanning;
use App\Utils\ToastHelper;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\Project as ProjectModel;
use App\Models\Project\Planning\DataExtraction\Question as QuestionModel;
use App\Traits\ProjectPermissions;

class DataExtraction extends Component
{

    use ProjectPermissions;

    public $currentProject;
    public $questions = [];
    private $toastMessages = 'project/planning.data-extraction.toasts';

    public function mount()
    {
        $projectId = request()->segment(2);
        $this->currentProject = ProjectModel::findOrFail($projectId);
        $this->questions = QuestionModel::where('id_project', $this->currentProject->id_project)->get();
    }

    private function toast(string $message, string $type)
    {
        $this->dispatch('question-cutoff', ToastHelper::dispatch($type, $message));
    }

    #[On('update-table')]
    public function update()
    {
        
        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }
        
        $this->questions = QuestionModel::where('id_project', $this->currentProject->id_project)->get();
    }

    public function editQuestion($data)
    {
        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        $this->dispatch('data-extraction-table-edit-question', $data['id_de']);
    }

    public function deleteQuestion($data)
    {

        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        $this->dispatch('data-extraction-table-delete-question', $data['id_de']);
    }

    public function editOption($data)
    {

        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        $this->dispatch('data-extraction-table-edit-option', $data['id_option']);
    }

    public function deleteOption($data)
    {

        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        $this->dispatch('data-extraction-table-delete-option', $data['id_option']);
    }

    public function render()
    {

        return view('livewire.planning.data-extraction.data-extraction')
            ->with('questions', $this->questions)
            ->with('project', $this->currentProject);
    }
}
