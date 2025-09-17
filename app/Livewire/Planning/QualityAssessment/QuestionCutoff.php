<?php

namespace App\Livewire\Planning\QualityAssessment;

use App\Models\Project;
use App\Models\Project\Planning\QualityAssessment\Cutoff;
use App\Models\Project\Planning\QualityAssessment\GeneralScore;
use App\Models\Project\Planning\QualityAssessment\Question;
use App\Utils\ToastHelper;
use App\Utils\ActivityLogHelper as Log;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Traits\ProjectPermissions;

/**
 * Componente Livewire para gerenciar os valores de corte (cutoff) para avaliação de qualidade.
 *
 * Este componente permite definir e atualizar os valores de corte para aprovação
 * baseados em pontuações gerais do projeto.
 */
class QuestionCutoff extends Component
{

    use ProjectPermissions;

    /** @var Project Projeto atual sendo avaliado */
    public $currentProject;

    /** @var array Lista de questões do projeto */
    public $questions = [];

    /** @var bool Indica se o valor de corte atingiu o máximo permitido */
    public $isCutoffMaxValue;

    /** @var string Caminho para as mensagens de toast */
    private $toastMessages = 'project/planning.quality-assessment.general-score.livewire.toasts';

    /** @var float Soma total dos pesos das questões */
    public $sum = 0;

    /** @var mixed Pontuação geral selecionada */
    public $selectedGeneralScore;

    /** @var array Lista de pontuações gerais disponíveis */
    public $generalScores = [];

    /**
     * Traduz uma mensagem usando o namespace específico do componente.
     *
     * @param string $message Mensagem a ser traduzida
     * @param string $key Chave do namespace de tradução
     * @return string Mensagem traduzida
     */
    private function translate(string $message, string $key = 'toasts')
    {
        return __('project/planning.quality-assessment.min-general-score.livewire.' . $key . '.' . $message);
    }

    /**
     * Inicializa o componente, carregando dados do projeto e configurações de corte.
     */
    public function mount()
    {
        $projectId = request()->segment(2);
        $this->currentProject = Project::findOrFail($projectId);
        $this->questions = Question::where('id_project', $projectId)->get();
        $this->sum = $this->questions->sum('weight');

        // Atualiza para pegar apenas os GeneralScores vinculados ao projeto
        $this->generalScores = GeneralScore::where('id_project', $projectId)->get();

        // Trata a mensagem de estado vazio
        if ($this->generalScores->isEmpty()) {
            $this->generalScoresMessage = __('project/planning.quality-assessment.min-general-score.form.empty');
        } else {
            $this->generalScoresMessage = null;
        }

        // Carrega ou cria os dados de corte
        if (Cutoff::where('id_project', $projectId)->exists()) {
            $cutoff = Cutoff::where('id_project', $projectId)->first();
            $this->cutoff = $cutoff->score;
            $this->oldCutoff = $cutoff->score;
            $this->selectedGeneralScore = $cutoff->id_general_score;
        } else {
            Cutoff::create(['id_project' => $projectId, 'score' => 0]);
            $this->cutoff = 0;
            $this->oldCutoff = 0;
            $this->selectedGeneralScore = null;
        }
    }

    /**
     * Atualiza a soma total dos pesos de todas as questões.
     * Disparado quando os pesos das questões são modificados.
     */
    #[On('update-weight-sum')]
    public function updateSum()
    {
        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        $projectId = $this->currentProject->id_project;
        $this->questions = Question::where('id_project', $projectId)->get();
        $this->sum = $this->questions->sum('weight');
    }

    /**
     * Atualiza a soma dos pesos e reavalia o valor de corte.
     * Não aplica restrições de valor máximo.
     */
    #[On('update-cutoff')]
    public function updateSumCutoff()
    {
        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        $projectId = $this->currentProject->id_project;
        $this->questions = Question::where('id_project', $projectId)->get();
        $this->sum = $this->questions->sum('weight');

        /*if ($this->cutoff > $this->sum) {
            $this->cutoff = $this->sum;
            Cutoff::updateOrCreate(['id_project' => $projectId], [
                'id_project' => $projectId,
                'score' => $this->cutoff,
            ]);
            $this->isCutoffMaxValue = true;
        }*/
    }

    /**
     * Atualiza a pontuação geral selecionada no registro de corte.
     * Valida a entrada e registra a atualização.
     */
    public function updateCutoff()
    {
        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            $this->reloadCutoff();
            return;
        }

        $projectId = $this->currentProject->id_project;

        $selectedGeneralScore = is_array($this->selectedGeneralScore) ? $this->selectedGeneralScore['value'] : $this->selectedGeneralScore;

        // Valida se uma pontuação geral foi selecionada
        if (is_null($this->selectedGeneralScore) || $this->selectedGeneralScore === 0) {
            $this->toast(
                message: $this->translate('required'),
                type: 'error',
            );
            return;
        }

        Log::logActivity(
            action: $this->translate('updated'),
            description: $selectedGeneralScore,
            projectId: $projectId
        );

        // Atualiza ou cria o valor de corte
        Cutoff::updateOrCreate(
            ['id_project' => $projectId],
            ['id_general_score' => $selectedGeneralScore]
        );

        // Recarrega o valor atualizado e notifica
        $this->reloadCutoff();

        $this->toast(
            message: $this->translate('updated'),
            type: 'success',
        );

        $this->dispatch('update-select-minimal-approve');
    }

    /**
     * Recarrega a lista de pontuações gerais disponíveis.
     */
    #[On('general-scores-generated')]
    public function reloadGeneralScores()
    {
        $projectId = $this->currentProject->id_project;
        $this->generalScores = GeneralScore::where('id_project', $projectId)->get();
    }

     /**
     * Recarrega o valor de corte da pontuação geral selecionada.
     */
    #[On('update-select-minimal-approve')]
    public function reloadCutoff()
    {
        $projectId = $this->currentProject->id_project;
        $cutoff = Cutoff::where('id_project', $projectId)->first();

        if ($cutoff) {
            $this->selectedGeneralScore = $cutoff->id_general_score;
        }
    }

    /**
     * Renderiza o componente.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.planning.quality-assessment.question-cutoff');
    }

    /**
     * Dispara uma notificação toast para o usuário.
     *
     * @param string $message Mensagem a ser exibida
     * @param string $type Tipo de toast (success, error, etc)
     */
    private function toast(string $message, string $type)
    {
        $this->dispatch('question-cutoff', ToastHelper::dispatch($type, $message));
    }
}
