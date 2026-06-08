<?php

namespace App\Livewire\Planning\QualityAssessment;

use Livewire\Attributes\On;
use Livewire\Component;
use App\Utils\ToastHelper;
use App\Utils\ActivityLogHelper as Log;
use App\Models\Project;
use App\Models\Member as MemberModel;
use App\Models\Project\Planning\QualityAssessment\Question;
use App\Models\Project\Conducting\QualityAssessment\PapersQa;
use App\Models\Project\Conducting\QualityAssessment\PapersQaAnswer;
use App\Traits\ProjectPermissions;

/**
 * Componente Livewire para gerenciar questões de qualidade.
 */
class QuestionQuality extends Component
{
    use ProjectPermissions;

    private $translationPath = 'project/planning.quality-assessment.question-quality.livewire';
    private $toastMessages   = 'project/planning.quality-assessment.question-quality.livewire.toasts';

    public $currentProject;
    public $currentQuestion;
    public $questions = [];

    public $questionId;
    public $description;
    public $weight;

    public $form = ['isEditing' => false];

    // Estado dos modais
    public $confirmingSubmit       = false;
    public $confirmingDeleteId     = null;
    public $deletionHasEvaluations = false;

    protected $rules = [
        'currentProject' => 'required',
        'questionId'     => 'required|string|max:10|regex:/^[a-zA-Z0-9]+$/',
        'description'    => 'required|string|regex:/^[\pL\pN\s\.,;:\?"\'\(\)\[\]\{\}\/\\\\_\-+=#@!%&*]+$/u|max:255',
        'weight'         => 'required|regex:/^\d+(\.\d{1,2})?$/',
    ];

    protected function messages()
    {
        return [
            'questionId.required'  => __('common.required'),
            'weight.required'      => __('common.required'),
            'description.required' => __('common.required'),
        ];
    }

    public function mount()
    {
        $projectId             = request()->segment(2);
        $this->currentProject  = Project::findOrFail($projectId);
        $this->currentQuestion = null;
        $this->questions       = Question::where('id_project', $projectId)->get();
    }

    public function resetFields()
    {
        $this->questionId              = '';
        $this->description             = '';
        $this->weight                  = '';
        $this->currentQuestion         = null;
        $this->form['isEditing']       = false;
        $this->confirmingSubmit        = false;
        $this->confirmingDeleteId      = null;
        $this->deletionHasEvaluations  = false;
    }

    public function toast(string $message, string $type)
    {
        $this->dispatch('question-quality', ToastHelper::dispatch($type, $message));
    }

    public function updateQuestions()
    {
        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        $this->questions = Question::where('id_project', $this->currentProject->id_project)->get();
        $this->dispatch('update-qa-table');
        $this->dispatch('update-weight-sum');
        $this->dispatch('update-score-questions');
    }

    // -----------------------------------------------------------------------
    // Helpers de avaliações QA
    // -----------------------------------------------------------------------

    /**
     * Verifica se já existem avaliações QA realizadas no projeto.
     */
    private function projectHasQaEvaluations(): bool
    {
        $memberIds = MemberModel::where('id_project', $this->currentProject->id_project)
            ->pluck('id_members');

        return PapersQa::whereIn('id_member', $memberIds)
            ->where('id_status', '!=', 3)
            ->exists();
    }

    /**
     * Reseta todas as avaliações QA do projeto.
     */
    private function resetQaEvaluations(): void
    {
        $memberIds = MemberModel::where('id_project', $this->currentProject->id_project)
            ->pluck('id_members');

        $papersQa = PapersQa::whereIn('id_member', $memberIds)
            ->where('id_status', '!=', 3)
            ->get();

        if ($papersQa->isEmpty()) {
            return;
        }

        $questionIds = Question::where('id_project', $this->currentProject->id_project)
            ->pluck('id_qa');

        PapersQaAnswer::whereIn('id_paper', $papersQa->pluck('id_paper'))
            ->whereIn('id_question', $questionIds)
            ->delete();

        foreach ($papersQa as $pqa) {
            $pqa->update(['id_status' => 3]);
        }

        $this->toast(
            message: __($this->toastMessages . '.reset_qa_evaluations'),
            type: 'warning'
        );
    }

    // -----------------------------------------------------------------------
    // Edit
    // -----------------------------------------------------------------------

    #[On('edit-question-quality')]
    public function edit($questionId)
    {
        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        $this->currentQuestion   = Question::findOrFail($questionId);
        $this->form['isEditing'] = true;
        $this->questionId        = $this->currentQuestion->id;
        $this->weight            = $this->currentQuestion->weight;
        $this->description       = $this->currentQuestion->description;
    }

    // -----------------------------------------------------------------------
    // Submit — criação e edição
    // -----------------------------------------------------------------------

    /**
     * Processa o formulário.
     * Alterações de peso disparam confirmação se já existirem avaliações QA.
     * Alterações apenas de descrição ou ID salvam direto.
     */
    public function submit()
    {
        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        $this->validate();

        // Validação de peso mínimo
        if ($this->weight <= 0) {
            $this->toast(
                message: __($this->toastMessages . '.min_weight'),
                type: 'error'
            );
            return;
        }

        // Verificação de ID duplicado
        $existingQuestion = Question::where('id', $this->questionId)
            ->where('id_project', $this->currentProject->id_project)
            ->when($this->form['isEditing'], function ($query) {
                $query->where('id_qa', '!=', $this->currentQuestion?->id_qa);
            })
            ->first();

        if ($existingQuestion) {
            $this->toast(
                message: __($this->toastMessages . '.duplicate_id'),
                type: 'error'
            );
            return;
        }

        // Verifica se peso mudou (único campo que invalida avaliações QA)
        $weightChanged = $this->form['isEditing']
            && (float) $this->currentQuestion->weight !== (float) $this->weight;

        if ($weightChanged && $this->projectHasQaEvaluations()) {
            $this->confirmingSubmit = true;
            $this->dispatch('openQaSubmitConfirm');
            return;
        }

        $this->persistQuestion(resetEvaluations: false);
    }

    /**
     * Chamado após confirmação do modal: salva e reseta avaliações.
     */
    public function confirmSubmit()
    {
        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        $this->persistQuestion(resetEvaluations: true);
    }

    /**
     * Persiste a questão no banco de dados.
     */
    private function persistQuestion(bool $resetEvaluations = false): void
    {
        try {
            $isEditing    = $this->form['isEditing'];
            $toastMessage = __($this->toastMessages . ($isEditing ? '.updated' : '.added'));

            $updatedOrCreated = Question::updateOrCreate(
                ['id_qa' => $this->currentQuestion?->id_qa],
                [
                    'id'          => $this->questionId,
                    'description' => $this->description,
                    'weight'      => $this->weight,
                    'id_project'  => $this->currentProject->id_project,
                ]
            );

            Log::logActivity(
                action: $isEditing ? 'Updated the question quality' : 'Added a question quality',
                description: $updatedOrCreated->description,
                module: 1,
                projectId: $this->currentProject->id_project
            );

            $this->updateQuestions();
            $this->toast(message: $toastMessage, type: 'success');

            if ($resetEvaluations) {
                $this->resetQaEvaluations();
            }

        } catch (\Exception $e) {
            $this->toast(message: $e->getMessage(), type: 'error');
        } finally {
            $this->resetFields();
        }
    }

    // -----------------------------------------------------------------------
    // Delete
    // -----------------------------------------------------------------------

    /**
     * Verifica avaliações e abre modal de confirmação antes de excluir.
     */
    #[On('confirm-delete-question-quality')]
    public function confirmDelete($questionId)
    {
        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        $memberIds = MemberModel::where('id_project', $this->currentProject->id_project)
            ->pluck('id_members');

        $this->confirmingDeleteId     = $questionId;
        $this->deletionHasEvaluations = PapersQaAnswer::where('id_question', $questionId)
            ->whereIn(
                'id_paper',
                PapersQa::whereIn('id_member', $memberIds)
                    ->where('id_status', '!=', 3)
                    ->pluck('id_paper')
            )->exists();

        $this->dispatch('openQaDeleteConfirm');
    }

    /**
     * Executa a exclusão após confirmação.
     */
    #[On('delete-question-quality')]
    public function delete($questionId)
    {
        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        try {
            $currentQuestion = Question::findOrFail($questionId);
            $currentQuestion->delete();

            Log::logActivity(
                action: 'Deleted the quality score',
                description: $currentQuestion->description,
                module: 1,
                projectId: $this->currentProject->id_project
            );

            $this->updateQuestions();
            $this->toast(
                message: __($this->toastMessages . '.deleted'),
                type: 'success'
            );
            $this->dispatch('update-cutoff');
            $this->resetQaEvaluations();

        } catch (\Exception $e) {
            $this->toast(message: $e->getMessage(), type: 'error');
        } finally {
            $this->resetFields();
        }
    }

    public function render()
    {
        return view('livewire.planning.quality-assessment.question-quality');
    }
}
