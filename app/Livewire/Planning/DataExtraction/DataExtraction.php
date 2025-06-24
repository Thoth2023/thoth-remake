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

	// Inicialização do componente livewire
    public function mount()
    {
        $projectId = request()->segment(2);
        $this->currentProject = ProjectModel::findOrFail($projectId);
        $this->questions = QuestionModel::where('id_project', $this->currentProject->id_project)->get();
    }

	// Exibe a mensagem de toast com o tipo e a mensagem fornecidos
    private function toast(string $message, string $type)
    {
        $this->dispatch('question-cutoff', ToastHelper::dispatch($type, $message));
    }

	// Listener do evento update-table dafunção para atualizar a tabela de perguntas
    #[On('update-table')]
    public function update()
    {
        // Verifica se o usuário tem permissão para editar
        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }
        
        $this->questions = QuestionModel::where('id_project', $this->currentProject->id_project)->get();
    }

	// Função para editar uma pergunta
    public function editQuestion($data)
    {
        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        $this->dispatch('data-extraction-table-edit-question', $data['id_de']);
    }

	// Função para deletar uma pergunta
    public function deleteQuestion($data)
    {

        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        $this->dispatch('data-extraction-table-delete-question', $data['id_de']);
    }

	// Função para editar uma opção de pergunta
    public function editOption($data)
    {

        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        $this->dispatch('data-extraction-table-edit-option', $data['id_option']);
    }

	// Função para deletar uma opção de pergunta
    public function deleteOption($data)
    {

        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        $this->dispatch('data-extraction-table-delete-option', $data['id_option']);
    }

	// Renderiza a view do componente, incluindo as perguntas e o projeto atual
    public function render()
    {

        return view('livewire.planning.data-extraction.data-extraction')
            ->with('questions', $this->questions)
            ->with('project', $this->currentProject);
    }
}
