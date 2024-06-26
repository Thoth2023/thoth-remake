<?php

namespace App\Livewire\Planning\QualityAssessment;

use Livewire\Component;

use App\Utils\ToastHelper;
use App\Utils\ActivityLogHelper as Log;
use App\Models\Project;
use App\Models\Project\Planning\QualityAssessment\Question;

class QuestionQuality extends Component
{
    private $translationPath = 'project/planning.quality-assessment.question-quality.livewire';
    private $toastMessages = 'project/planning.quality-assessment.question-quality.livewire.toasts';
    public $currentProject;
    public $currentQuestion;
    public $questions = [];

    /**
     * Fields to be filled by the form.
     */
    public $questionId;
    public $description;
    public $weight;

    /**
     * Form state.
     */
    public $form = [
        'isEditing' => false,
    ];

    /**
     * Validation rules.
     */
    protected $rules = [
        'currentProject' => 'required',
        'questionId' => 'required|string|max:10|regex:/^[a-zA-Z0-9]+$/',
        'description' => 'required|string|max:255',
        'weight' => 'required|numeric',
    ];

    /**
     * Custom error messages for the validation rules.
     */
    protected function messages()
    {
        return [
            'questionId.required' => __('common.required'),
            'weight.required' => __('common.required'),
            'description.required' => __('common.required'),
        ];
    }

    /**
     * Executed when the component is mounted. It sets the
     * project id and retrieves the items.
     */
    public function mount()
    {
        $projectId = request()->segment(2);
        $this->currentProject = Project::findOrFail($projectId);
        $this->currentQuestion = null;
        $this->questions = Question::where('id_project', $projectId)->get();
    }

    /**
     * Reset the fields to the default values.
     */
    public function resetFields()
    {
        $this->questionId = '';
        $this->description = '';
        $this->weight = '';
        $this->currentQuestion = null;
        $this->form['isEditing'] = false;
    }

    /**
     * Dispatch a toast message to the view.
     */
    public function toast(string $message, string $type)
    {
        $this->dispatch('question-quality', ToastHelper::dispatch($type, $message));
    }

    /**
     * Update the items.
     */
    public function updateQuestions()
    {
        $projectId = $this->currentProject->id_project;
        $this->questions = Question::where('id_project', $projectId)->get();
        $this->dispatch('update-qa-table');
        $this->dispatch('update-weight-sum');
        $this->dispatch('update-score-questions');
    }

    public function submit()
    {
        $this->validate();

        $updateIf = [
            'id_qa' => $this->currentQuestion?->id_qa,
        ];

        try {
            $value = $this->form['isEditing']
                ? 'Updated the question quality' : 'Added a question quality';
            $toastMessage = __($this->toastMessages . ($this->form['isEditing']
                ? '.updated' : '.added'));

            $updatedOrCreated = Question::updateOrCreate($updateIf, [
                'id' => $this->questionId,
                'description' => $this->description,
                'weight' => $this->weight,
                'id_project' => $this->currentProject->id_project,
            ]);

            Log::logActivity(
                action: $value,
                description: $updatedOrCreated->description,
                projectId: $this->currentProject->id_project
            );

            $this->updateQuestions();
            $this->toast(
                message: $toastMessage,
                type: 'success'
            );
        } catch (\Exception $e) {
            $this->toast(
                message: $e->getMessage(),
                type: 'error'
            );
        } finally {
            $this->resetFields();
        }
    }

    public function render()
    {
        return view('livewire.planning.quality-assessment.question-quality');
    }
}
