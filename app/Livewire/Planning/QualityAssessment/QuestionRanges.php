<?php

namespace App\Livewire\Planning\QualityAssessment;

use App\Models\Project;
use App\Models\Project\Planning\QualityAssessment\Cutoff;
use App\Models\Project\Planning\QualityAssessment\GeneralScore;
use App\Models\Project\Planning\QualityAssessment\Question;
use App\Utils\ToastHelper;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Traits\ProjectPermissions;

/**
 * Componente Livewire para gerenciar intervalos de pontuação geral.
 *
 * Este componente permite criar e gerenciar intervalos de pontuação para avaliação
 * de qualidade, incluindo seus valores mínimos, máximos e descrições.
 */
class QuestionRanges extends Component
{

  use ProjectPermissions;

  /** @var Project Projeto atual sendo avaliado */
  public $currentProject;

  /** @var array Lista de intervalos de pontuação */
  public $items = [];

  /** @var array Cópia dos intervalos para comparação */
  public $oldItems = [];

  /** @var float Soma total dos pesos das questões */
  public $sum = 0;

  /** @var int Número de intervalos desejados */
  public $intervals = 5;

  /** @var string Caminho para as mensagens de toast */
  private $toastMessages = 'project/planning.quality-assessment.general-score.livewire.toasts';

  /**
   * Regras de validação para os campos do formulário.
   */
  protected $rules = [
    'items.*.description' => 'required|string|regex:/^[a-zA-ZÀ-ÿ0-9\s]+$/u',
    'intervals' => 'required|integer|min:2|max:10',
  ];

  /**
   * Mensagens de erro personalizadas para as regras de validação.
   *
   * @return array Mensagens de erro
   */
  protected function messages()
  {
      return [
          'items.*.description.required' => 'O campo descrição é obrigatório.',
          'items.*.description.regex' => 'A descrição só pode conter letras, números e espaços.',
          'intervals.required' => 'O número de intervalos é obrigatório.',
          'intervals.integer' => 'O número de intervalos deve ser um número inteiro.',
          'intervals.min' => 'O número de intervalos deve ser no mínimo 2.',
          'intervals.max' => 'O número de intervalos deve ser no máximo 10.',
      ];
  }

  /**
   * Popula a lista de intervalos com dados do banco de dados.
   */
    public function populateItems()
    {
        $this->items = [];
        $projectId = $this->currentProject->id_project;

        $items = GeneralScore::where('id_project', $projectId)
            ->orderBy('start', 'asc')
            ->get();

        foreach ($items as $item) {
            $this->items[] = [
                'id_general_score' => $item->id_general_score,
                'start' => $item->start,
                'end' => $item->end,
                'description' => $item->description,
            ];
        }

        $this->oldItems = $this->items;
    }

  /**
   * Inicializa o componente, carregando o projeto e seus intervalos.
   */
  public function mount()
  {
    $projectId = request()->segment(2);
    $this->currentProject = Project::findOrFail($projectId);
    $this->sum = Question::where('id_project', $projectId)->sum('weight');
    $this->populateItems();
    $this->intervals = count($this->items) === 0 ? 2 : count($this->items);
  }

  /**
   * Dispara uma notificação toast para o usuário.
   *
   * @param string $message Mensagem a ser exibida
   * @param string $type Tipo de toast (success, error, etc)
   */
  public function toast(string $message, string $type)
  {
    $this->dispatch('qa-ranges', ToastHelper::dispatch($type, $message));
  }

  /**
   * Atualiza a soma total dos pesos das questões.
   * Disparado quando os pesos são modificados.
   */
  #[On('update-weight-sum')]
  public function updateSum()
  {

    if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
      return;
    }

    $projectId = $this->currentProject->id_project;
    $this->sum = Question::where('id_project', $projectId)->sum('weight');
  }

  /**
   * Atualiza o valor mínimo de um intervalo.
   *
   * @param int $index Índice do intervalo
   * @param float $value Novo valor mínimo
   */
  public function updateMin($index, $value)
  {

    if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
      return;
    }

    try {
      $this->items[$index]['start'] = $value;

      GeneralScore::updateOrCreate([
        'id_general_score' => $this->items[$index]
      ], [
        'start' => $value,
      ]);
      $this->dispatch('general-scores-generated');
    } catch (\Exception $e) {
      $this->toast(
        message: $e->getMessage(),
        type: 'error'
      );
    }
  }

  /**
   * Atualiza o valor máximo de um intervalo e ajusta o próximo intervalo.
   *
   * @param int $index Índice do intervalo
   * @param float $value Novo valor máximo
   */
  public function updateMax($index, $value)
  {

    if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
      return;
    }

    try {
      // Validar se o valor é um número válido
      if (!is_numeric($value)) {
        throw new \Exception(__('project/planning.quality-assessment.ranges.invalid-number'));
      }

      /**
       * Se o novo valor "end" for igual ao valor atual "end",
       * não faz nada
       */
      if ($this->items[$index]['end'] == $this->oldItems[$index]['end']) {
        return;
      }

      $this->items[$index]['end'] = round((float)$value, 2);
      $this->items[$index + 1]['start'] = round((float)$value + 0.01, 2);

      /**
       * Atualiza o valor atual de "end"
       */
      GeneralScore::updateOrCreate([
        'id_general_score' => $this->items[$index]['id_general_score']
      ], [
        'end' => $value,
      ]);

      if (count($this->items) <= $index + 1) {
        return;
      }

      /**
       * Atualiza o valor de "start" do próximo intervalo
       */
      GeneralScore::updateOrCreate([
        'id_general_score' => $this->items[$index + 1]['id_general_score']
      ], [
        'start' => round((float)$value + 0.01, 2),
      ]);

      $this->dispatch('general-scores-generated');

      $this->toast(
        message: __('project/planning.quality-assessment.ranges.interval-updated'),
        type: 'success'
      );
      $this->oldItems = $this->items;
    } catch (\Exception $e) {
      $this->toast(
        message: $e->getMessage(),
        type: 'error'
      );
    }
  }

  /**
   * Atualiza a descrição de um intervalo.
   *
   * @param int $index Índice do intervalo
   */
  public function updateLabel($index)
  {

    if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
      $this->items[$index]['description'] = $this->oldItems[$index]['description'];
      return;
    }

    try {
      $this->validate([
        "items.$index.description" => 'required|string|regex:/^[a-zA-ZÀ-ÿ0-9\s]+$/u',
      ]);

      $idGeneralScore = $this->items[$index]['id_general_score'];
      $value = $this->items[$index]['description'];

      if ($this->oldItems[$index]['description'] === $value) {
        return;
      }

      GeneralScore::updateOrCreate([
        'id_general_score' => $idGeneralScore,
      ], [
        'description' => $value,
      ]);

      $this->dispatch('update-select-minimal-approve');

      $this->toast(
        message: __('project/planning.quality-assessment.ranges.label-updated'),
        type: 'success'
      );

      $this->oldItems[$index]['description'] = $value;
    } catch (\Exception $e) {
      $this->toast(
        message: $e->getMessage(),
        type: 'error'
      );
    }
  }

  /**
   * Gera novos intervalos baseado no número especificado.
   * Verifica dependências antes de excluir intervalos existentes.
   */
    public function generateIntervals()
    {
        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        // Garantir limites seguros
        $this->intervals = max(2, min($this->intervals, 10));

        $projectId = $this->currentProject->id_project;

        $existingScores = GeneralScore::where('id_project', $projectId)->orderBy('start')->get();
        $existingCount = $existingScores->count();

        $hasEvaluations = DB::table('papers_qa')
            ->join('general_score', 'papers_qa.id_gen_score', '=', 'general_score.id_general_score')
            ->where('general_score.id_project', $projectId)
            ->exists();

        // 3- reduzir intervalos
        if ($this->intervals < $existingCount) {
            if ($hasEvaluations) {
                $this->toast(
                    message: __('project/planning.quality-assessment.ranges.reduction-not-allowed'),
                    type: 'error'
                );
                return;
            }

            // Nenhuma avaliação vinculada — pode deletar tudo e recriar
            GeneralScore::where('id_project', $projectId)->delete();
            $existingCount = 0;
        }

        // Soma total dos pesos
        $sumWeights = Question::where('id_project', $projectId)->sum('weight');
        $rangeStep = round($sumWeights / $this->intervals, 2);

        $start = 0.01;
        $newItems = [];

        for ($i = 1; $i <= $this->intervals; $i++) {
            $end = round($start + $rangeStep - 0.01, 2);

            // Atualizar existentes
            if ($i <= $existingCount) {
                $existing = $existingScores[$i - 1];
                $existing->update([
                    'start' => $start,
                    'end' => $end,
                ]);
            } else {
                // Criar novos intervalos
                $newItems[] = [
                    'id_project' => $projectId,
                    'start' => $start,
                    'end' => $end,
                    'description' => __('project/planning.quality-assessment.ranges.new-label', ['n' => $i]),
                ];
            }

            $start = round($end + 0.01, 2);
        }

        if (!empty($newItems)) {
            GeneralScore::insert($newItems);
        }

        // Atualiza os itens na tela
        $this->items = [];
        $this->oldItems = [];
        $this->populateItems();

        // Força Livewire a re-renderizar o componente
        $this->dispatch('$refresh');

        $this->toast(
            message: __('project/planning.quality-assessment.ranges.generated-successfully'),
            type: 'success'
        );

        $this->dispatch('general-scores-generated');
    }


    /**
   * Manipula atualizações automáticas de propriedades.
   * Atualiza a descrição quando o campo é modificado.
   *
   * @param string $propertyName Nome da propriedade atualizada
   */
  public function updated($propertyName)
  {
    if (preg_match('/items\.(\d+)\.description/', $propertyName, $matches)) {
      $index = $matches[1];
      $this->updateLabel($index);
    }
  }

  /**
   * Renderiza o componente.
   *
   * @return \Illuminate\View\View
   */
  public function render()
  {
    return view('livewire.planning.quality-assessment.question-ranges');
  }
}
