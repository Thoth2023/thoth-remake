<?php

namespace App\Livewire\Reporting;

use App\Models\Project as ProjectModel;
use App\Models\Project\Conducting\Papers;
use App\Models\Project\Conducting\PaperSnowballing;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

class Snowballing extends Component
{
    public $currentProject;
    public $chartData;
    public $totalPapers = 0;
    public $maxDepth = 0;
    public $totalSeeds = 0;

    public function mount()
    {
        $projectId = request()->segment(2);
        $this->currentProject = ProjectModel::findOrFail($projectId);
        $this->loadData();
    }

    public function loadData()
    {
        try {
            // Busca todos os papers sementes do projeto
            $seedIds = PaperSnowballing::whereHas('paper.bibUpload.projectDatabase', function ($q) {
                $q->where('id_project', $this->currentProject->id_project);
            })
                ->distinct()
                ->pluck('paper_reference_id'); // retorna todos os IDs de referência únicos

            $seedPapers = Papers::whereIn('id_paper', $seedIds)->get();

            // Busca todos os snowballings relevantes do projeto
            $snowballings = PaperSnowballing::whereHas('paper.bibUpload.projectDatabase', function ($q) {
                $q->where('id_project', $this->currentProject->id_project);
            })
                ->where('is_relevant', 1)
                ->get();

            if ($seedPapers->isEmpty() && $snowballings->isEmpty()) {
                $this->chartData = json_encode([]);
                Log::warning("Sem papers relevantes ou sementes no projeto {$this->currentProject->id_project}");
                return;
            }

            $this->totalPapers = $snowballings->count();

            // Monta a árvore com n níveis a partir dos papers sementes
            $tree = [];

            foreach ($seedPapers as $seed) {
                $seedNode = [
                    'id' => 'paper-' . $seed->id_paper,
                    'name' => 'ID: ' . $seed->id_paper . ' — ' . ($seed->title ?? 'Paper Semente'),
                    'value' => 1,
                    'color' => '#16a34a', // verde para seeds
                    'expanded' => true,
                    'children' => $this->buildTree($snowballings, $seed->id_paper)
                ];

                $tree[] = $seedNode;
            }

            $this->totalSeeds = $seedPapers->count();

            // Calcula profundidade máxima da árvore
            $this->maxDepth = collect($tree)->map(fn($n) => $this->calculateMaxDepth($n))->max() ?? 0;

            // Monta JSON final para o gráfico
            $this->chartData = json_encode($tree, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);


            Log::info('Árvore Snowballing (multi-nível) montada com sucesso.', [
                'project_id' => $this->currentProject->id_project,
                'total_relevantes' => $this->totalPapers,
                'total_seeds' => $seedPapers->count(),
                'max_depth' => $this->maxDepth,
            ]);
        } catch (\Throwable $e) {
            Log::error('Erro ao montar árvore Snowballing (multi-nível): ' . $e->getMessage());
            $this->chartData = json_encode([]);
        }
    }

    /**
     * Monta recursivamente os filhos (sem limite de profundidade)
     */
    private function buildTree($snowballings, $referenceId)
    {
        // Filhos cujos paper_reference_id = referência do nó atual
        $children = $snowballings->filter(fn($p) => $p->paper_reference_id == $referenceId);

        return $children->map(function ($p) use ($snowballings) {
            // Cor conforme o tipo de snowballing
            $color = match ($p->type_snowballing) {
                'backward' => '#0a3d62', // azul marinho
                'forward'  => '#f39c12', // laranja
                default    => '#999999',
            };

            return [
                'id' => 'snow-' . $p->id,
                'name' => 'ID: ' . $p->id . ' — ' . ($p->title ?? 'Sem título') . ' (' . ($p->type_snowballing ?? '?') . ')',
                'value' => $p->relevance_score ?? 1,
                'color' => $color,
                'expanded' => true,
                'children' => $this->buildTree($snowballings, $p->id), // recursão infinita até o último nível
            ];
        })->values()->toArray();
    }

    /**
     * Calcula a profundidade máxima da árvore
     */
    private function calculateMaxDepth(array $node, int $depth = 1): int
    {
        if (empty($node['children'])) return $depth;
        $depths = array_map(fn($child) => $this->calculateMaxDepth($child, $depth + 1), $node['children']);
        return max($depths);
    }

    public function render()
    {
        return view('livewire.reporting.snowballing', [
            'chartData' => $this->chartData,
            'totalPapers' => $this->totalPapers,
            'maxDepth' => $this->maxDepth,
        ]);
    }
}
