<?php

namespace App\Livewire\Planning\QualityAssessment;

use App\Models\Project;
use App\Models\Project\Planning\QualityAssessment\Cutoff;
use App\Models\Project\Planning\QualityAssessment\GeneralScore;
use App\Models\Project\Planning\QualityAssessment\Question;
use App\Utils\ToastHelper;
use Livewire\Attributes\On;
use Livewire\Component;

class QuestionRanges extends Component
{
  public $currentProject;
  public $items = [];
  public $sum = 0;
  public $intervals = 5;

  public function mount()
  {
    $projectId = request()->segment(2);
    $this->currentProject = Project::findOrFail($projectId);
    $this->sum = Question::where('id_project', $projectId)->sum('weight');
    $items = GeneralScore::where('id_project', $projectId)->get();
    $this->intervals = count($items) === 0 ? 2 : count($items);

    for ($i = 0; $i < count($items); $i++) {
      $this->items[] = [
        'id_general_score' => $items[$i]->id_general_score,
        'start' => $items[$i]->start,
        'end' => $items[$i]->end,
        'description' => $items[$i]->description
      ];
    }
  }

  /**
   * Dispatch a toast message to the view.
   */
  public function toast(string $message, string $type)
  {
    $this->dispatch('qa-ranges', ToastHelper::dispatch($type, $message));
  }

  #[On('update-weight-sum')]
  public function updateSum()
  {
    $projectId = $this->currentProject->id_project;
    $this->sum = Question::where('id_project', $projectId)->sum('weight');
  }

  public function updateMin($index, $value)
  {
    try {
      $this->items[$index]['start'] = $value;

      GeneralScore::updateOrCreate([
        'id_general_score' => $this->items[$index]
      ], [
        'start' => $value,
      ]);
    } catch (\Exception $e) {
      $this->toast(
        message: $e->getMessage(),
        type: 'error'
      );
    }
  }

  public function updateMax($index, $value)
  {
    try {
      if ($index < count($this->items) - 1 && $value >= $this->items[$index]['start']) {
        $this->items[$index]['end'] = $value;
        $this->items[$index + 1]['start'] = round($value + 0.01, 2);

        GeneralScore::updateOrCreate([
          'id_general_score' => $this->items[$index]
        ], [
          'end' => $value,
        ]);

        GeneralScore::updateOrCreate([
          'id_general_score' => $this->items[$index + 1]
        ], [
          'start' => round($value + 0.01, 2),
        ]);
      } else if ($index < count($this->items) - 1) {
        $this->items[$index]['end'] = round($this->items[$index]['start'] + 0.01, 2);
        $this->updateMax($index, $this->items[$index]['end']);
      }
    } catch (\Exception $e) {
      $this->toast(
        message: $e->getMessage(),
        type: 'error'
      );
    }
  }

  public function updateLabel($idGeneralScore, $value)
  {
    GeneralScore::updateOrCreate([
      'id_general_score' => $idGeneralScore,
    ], [
      'description' => $value,
    ]);

    $this->toast(
      message: 'Label updated successfully.',
      type: 'success'
    );
  }

  public function addItem()
  {
    if (count($this->items) == 0) {
      $this->items[] = [
        'start' => 0.01,
        'end' => $this->sum,
        'description' => ''
      ];
      return;
    }

    if (
      count($this->items) >= 1
      && $this->items[count($this->items) - 1]['end'] >= $this->sum
    ) {
      $this->toast(
        message: 'O valor máximo do último item já está no máximo permitido.',
        type: 'info'
      );
      return;
    }

    if (count($this->items) >= 1) {
      $this->items[] = [
        'start' => $this->items[count($this->items) - 1]['max'] + 0.01,
        'end' => $this->sum,
        'description' => ''
      ];
    }
  }

  public function generateIntervals()
  {
    if ($this->intervals < 2) {
      $this->intervals = 2;
    }

    if ($this->intervals > 10) {
      $this->intervals = 10;
    }

    $sum = $this->sum;
    $items = [];
    $min = 0.01;
    $max = round($sum / $this->intervals, 2);
    GeneralScore::where('id_project', $this->currentProject->id_project)->delete();

    for ($i = 0; $i < $this->intervals; $i++) {
      $items[] = [
        'start' => $min,
        'end' => $max,
        'description' => 'Intervalo ' . $i + 1,
        'id_project' => $this->currentProject->id_project
      ];
      $min = round($max + 0.01, 2);
      $max = round($max + $sum / $this->intervals, 2);

      GeneralScore::create($items[$i]);
    }

    $this->items = $items;
  }

  public function render()
  {
    return view('livewire.planning.quality-assessment.question-ranges');
  }
}