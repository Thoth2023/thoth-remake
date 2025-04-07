<?php

namespace App\Livewire\Conducting\DataExtraction;

use App\Models\Member;
use App\Models\Project;
use App\Models\Project\Conducting\DataExtraction\EvaluationExOp;
use App\Models\Project\Conducting\DataExtraction\EvaluationExTxt;
use App\Models\Project\Conducting\Papers;
use App\Models\Project\Planning\DataExtraction\Question;
use App\Models\StatusExtraction;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Traits\ProjectPermissions;

class PaperModal extends Component
{

    use ProjectPermissions;

    public $currentProject;
    public $projectId;
    public $paper;
    public $selected_status = "None";
    public $questions;
    public $evaluation;
    public $textAnswers = [];
    public $selectedOptions = [];
    public $canEdit = false;

    public function mount()
    {
        $this->projectId = request()->segment(2);
        $this->currentProject = Project::findOrFail($this->projectId);
        $this->questions = collect();

    }

    public function loadQuestions()
    {
        $this->questions = Question::with(['question_type', 'options'])
            ->where('id_project', $this->projectId)
            ->get();

        foreach ($this->questions as $question) {
            if (optional($question->question_type)->type == 'Text') {
                // Carrega respostas de texto
                $evaluation = EvaluationExTxt::where('id_qe', $question->id_de)
                    ->where('id_paper', $this->paper['id_paper'])
                    ->first();
                $this->textAnswers[$question->id] = $evaluation ? $evaluation->text : '';

            } elseif (optional($question->question_type)->type == 'Pick One List') {
                // Carrega seleção de uma única opção
                $evaluation = EvaluationExOp::where('id_qe', $question->id_de)
                ->where('id_paper', $this->paper['id_paper'])
                    ->first();
                // Armazena o ID da opção selecionada
                $this->selectedOptions[$question->id_de] = $evaluation ? $evaluation->id_option : null;

                $this->selectedOptions[$question->id_de] = $evaluation ? $evaluation->id_option : null;
            } elseif (optional($question->question_type)->type == 'Multiple Choice List') {
                // Carrega opções múltiplas
                $this->selectedOptions[$question->id_de] = EvaluationExOp::where('id_qe', $question->id_de)
                    ->where('id_paper', $this->paper['id_paper'])
                    ->pluck('id_option')
                    ->toArray();
            } else {
                $this->selectedOptions[$question->id_de] = $this->selectedOptions[$question->id_de] ?? [];
            }
        }
    }

    #[On('showPaperExtraction')]
    public function showPaperExtraction($paper)
    {

        // Verifica se o usuário tem permissão para visualizar o paper
        $this->canEdit = $this->userCanEdit();

        $this->paper = $paper;

        $databaseName = DB::table('data_base')
            ->where('id_database', $this->paper['data_base'])
            ->value('name');

        $this->paper['database_name'] = $databaseName;

        //status selecionado com base no status salvo no banco de dados
        $this->selected_status = $this->paper['status_description'];

        $this->loadQuestions();

        $this->dispatch('show-paper-extraction');
        $this->dispatch('reload-paper-extraction');
    }

    public function updateStatusManual()
    {
        $paper = Papers::where('id_paper', $this->paper['id_paper'])->first();

        // Verifica se o status selecionado realmente existe no banco de dados
        $status = StatusExtraction::where('description', $this->selected_status)->first();

        // Atualiza o status do paper
        if ($paper) {
            $paper->status_extraction = $status->id_status;
            $paper->save();
            session()->flash('successMessage', "Status Extraction updated successfully. New status: " . $status->description);
            // Dispara o modal de sucesso
            $this->dispatch('show-success-extraction');
        } else {
            session()->flash('errorMessage', "Paper not found.");
        }
    }

    public function saveTextAnswer($questionId, $content)
    {
        // Salva ou atualiza o texto no banco de dados
        $evaluation = EvaluationExTxt::updateOrCreate(
            ['id_qe' => $questionId, 'id_paper' => $this->paper['id_paper']],
            ['text' => $content]
        );
        // Atualiza o conteúdo do editor no frontend
        $this->textAnswers[$questionId] = $content;

        $this->loadTextAnswers();

        // Envia a mensagem de sucesso e despacha os eventos necessários
        session()->flash('successMessage', "Text Answer saved successfully");
        $this->dispatch('show-success-extraction');
    }
    public function loadTextAnswers()
    {
        foreach ($this->questions as $question) {
            if (optional($question->question_type)->type == 'Text') {
                // Carrega respostas de texto
                $evaluation = EvaluationExTxt::where('id_qe', $question->id_de)
                    ->where('id_paper', $this->paper['id_paper'])
                    ->first();
                $this->textAnswers[$question->id] = $evaluation ? $evaluation->text : '';

            } else {
                $this->selectedOptions[$question->id_de] = $this->selectedOptions[$question->id_de] ?? [];
            }
        }
    }
    public function saveOptionAnswer($questionId, $optionId)
    {
        //opção de única escolha
        EvaluationExOp::updateOrCreate(
            ['id_qe' => $questionId, 'id_paper' => $this->paper['id_paper']],
            ['id_option' => $optionId]
        );
        $this->selectedOptions[$questionId] = $optionId;

        session()->flash('successMessage', "Option updated successfully");

        $this->dispatch('show-success-extraction');

    }
    private function loadSelectedOptions()
    {
        $evaluations = EvaluationExOp::where('id_paper', $this->paper['id_paper'])->get();
        foreach ($evaluations as $evaluation) {
            $this->selectedOptions[$evaluation->id_qe] = $evaluation->id_option;
        }
    }
    public function toggleOption($questionId, $optionId)
    {
        //opções de múltipla escolha
        $existingEntry = EvaluationExOp::where('id_qe', $questionId)
            ->where('id_paper', $this->paper['id_paper'])
            ->where('id_option', $optionId)
            ->first();

        if ($existingEntry) {
            // Se já existe, remover a seleção
            $existingEntry->delete();
            $this->selectedOptions[$questionId] = array_diff($this->selectedOptions[$questionId], [$optionId]);
        } else {
            // Se não existe, adicionar a seleção
            EvaluationExOp::create([
                'id_qe' => $questionId,
                'id_paper' => $this->paper['id_paper'],
                'id_option' => $optionId,
            ]);

            $this->selectedOptions[$questionId][] = $optionId;
        }
        session()->flash('successMessage', "Option updated successfully");
        $this->dispatch('show-success-extraction');
        $this->dispatch('reload-paper-extraction');
    }

    public function render()
    {
        return view('livewire.conducting.data-extraction.paper-modal', [
            'questions' => $this->questions,
        ]);
    }
}
