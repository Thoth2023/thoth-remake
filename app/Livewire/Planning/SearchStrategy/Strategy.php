<?php

namespace App\Livewire\Planning\SearchStrategy;

use Livewire\Component;
use App\Models\Project as ProjectModel;
use App\Models\SearchStrategy as SearchStrategyModel;
use App\Utils\ActivityLogHelper as Log;
use App\Utils\ToastHelper;

/**
 * Componente Livewire responsável por gerenciar a estratégia de busca (Search Strategy)
 * associada a um projeto específico no planejamento.
 */
class Strategy extends Component
{
    /**
     * ID do projeto atual, extraído da URL.
     *
     * @var int
     */
    public $projectId;

    /**
     * Modelo da estratégia de busca associada ao projeto.
     *
     * @var \App\Models\SearchStrategy|null
     */
    public $searchStrategy;

    /**
     * Descrição atual da estratégia de busca, usada no formulário.
     *
     * @var string|null
     */
    public $currentDescription;

    /**
     * Regras de validação para o formulário.
     *
     * @var array
     */
    protected $rules = [
        'currentDescription' => 'required|string',
    ];

    /**
     * Inicializa o componente e carrega a estratégia de busca do projeto.
     * 
     * O ID do projeto é extraído da URL (segundo segmento).
     * Se não existir uma estratégia de busca, um novo modelo é instanciado.
     *
     * @return void
     */
    public function mount()
    {
        $projectId = request()->segment(2);
        $this->projectId = $projectId;

        // Busca a estratégia de busca existente ou cria um modelo novo
        $this->searchStrategy = SearchStrategyModel::where('id_project', $this->projectId)
            ->firstOrNew([]);

        // Preenche o campo de descrição com o valor atual
        $this->currentDescription = $this->searchStrategy->description;
    }

    /**
     * Exibe uma notificação (toast) na interface.
     *
     * @param string $message Mensagem a ser exibida.
     * @param string $type Tipo da mensagem (ex: 'success', 'error').
     * @return void
     */
    public function toast(string $message, string $type)
    {
        // Envia evento de toast para a interface
        $this->dispatch('search-strategy', ToastHelper::dispatch($type, $message));
    }

    /**
     * Valida e salva a estratégia de busca do projeto.
     * 
     * Caso ocorra um erro, exibe uma mensagem de erro para o usuário.
     *
     * @return void
     */
    public function submit()
    {
        $this->validate();

        try {
            // Garante que o projeto existe
            $project = ProjectModel::findOrFail($this->projectId);

            // Cria ou atualiza a estratégia de busca com a nova descrição
            $project->searchStrategy()
                ->updateOrCreate([], ['description' => $this->currentDescription]);

            // Registra a atividade no log
            Log::logActivity(
                action: 'Updated the search strategy',
                description: $this->currentDescription,
                projectId: $this->projectId
            );

            // Exibe mensagem de sucesso
            $this->toast(
                message: __('project/planning.search-strategy.success'),
                type: 'success'
            );
        } catch (\Exception $e) {
            // Exibe mensagem de erro, caso algo dê errado
            $this->toast(
                message: $e->getMessage(),
                type: 'error'
            );
        }
    }

    /**
     * Renderiza a view associada ao componente.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.planning.search-strategy.strategy');
    }
}
