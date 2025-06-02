<?php 

// Define o namespace da classe, organizando-a dentro da estrutura de pastas da aplicação
namespace App\Livewire\Planning\SearchStrategy;

// Importa a classe base para componentes Livewire
use Livewire\Component;

// Importa o model Project, renomeando como ProjectModel para evitar ambiguidade
use App\Models\Project as ProjectModel;

// Importa o model SearchStrategy, também renomeado
use App\Models\SearchStrategy as SearchStrategyModel;

// Importa helper para registro de atividades (logs de ações do usuário)
use App\Utils\ActivityLogHelper as Log;

// Importa helper para exibir notificações (toasts) para o usuário
use App\Utils\ToastHelper;

// Importa trait com métodos relacionados a permissões em projetos
use App\Traits\ProjectPermissions;

/**
 * Componente Livewire responsável por gerenciar a **estratégia de busca**
 * (Search Strategy) de um projeto específico no sistema.
 *
 * Funcionalidades:
 * - Exibe a estratégia de busca já cadastrada
 * - Permite editar e validar a descrição
 * - Salva ou atualiza a estratégia no banco de dados
 * - Registra log da atividade
 * - Exibe mensagens de sucesso ou erro ao usuário
 */
class Strategy extends Component
{
    // Trait que inclui métodos auxiliares relacionados a permissões do usuário no projeto
    use ProjectPermissions;

    // Atributo público para armazenar o ID do projeto
    public $projectId;

    // Armazena o objeto do projeto atual
    public $currentProject;

    // Armazena a estratégia de busca associada ao projeto
    public $searchStrategy;

    // Armazena a descrição atual da estratégia (editável pelo usuário)
    public $currentDescription;

    // Caminho para o arquivo de mensagens de toast (notificações)
    private $toastMessages = 'project/planning.search-strategy';

    // Regras de validação para o campo de descrição
    protected $rules = [
        'currentDescription' => [
            'required', // Campo obrigatório
            'string',   // Deve ser uma string
        ],
    ];
    
    // Mensagens de erro personalizadas para o campo de descrição
    protected $messages = [
        'currentDescription.required' => 'O campo descrição é obrigatório.',
        'currentDescription.regex' => 'A descrição deve conter pelo menos uma letra e não pode conter apenas caracteres especiais ou números.',
    ];

    /**
     * Método chamado ao inicializar o componente.
     * Recupera o ID do projeto pela URL e carrega os dados do projeto e da estratégia de busca.
     */
    public function mount()
    {
        // Recupera o ID do projeto a partir da URL (segundo segmento)
        $projectId = request()->segment(2);

        // Armazena o ID do projeto
        $this->projectId = $projectId;

        // Busca o projeto no banco de dados (ou lança erro se não encontrado)
        $this->currentProject = ProjectModel::findOrFail($this->projectId);

        // Busca a estratégia de busca associada ao projeto ou instancia uma nova se não existir
        $this->searchStrategy = SearchStrategyModel::where('id_project', $this->projectId)->firstOrNew([]);

        // Preenche a descrição atual no campo editável
        $this->currentDescription = $this->searchStrategy->description;
    }

    /**
     * Exibe uma notificação (toast) na interface.
     *
     * @param string $message Mensagem a ser exibida
     * @param string $type Tipo da notificação (ex: 'success', 'error')
     */
    public function toast(string $message, string $type)
    {
        // Envia a notificação para a view com base no helper
        $this->dispatch('search-strategy', ToastHelper::dispatch($type, $message));
    }

    /**
     * Envia o formulário: valida os dados, salva a descrição
     * no banco e registra a atividade no log.
     */
    public function submit()
    {
        // Validação básica do campo (obrigatório e tipo string)
        $this->validate([
            'currentDescription' => 'required|string',
        ]);

        // Validação personalizada: exige pelo menos uma letra
        if (!$this->isValidDescription($this->currentDescription)) {
            $this->addError('currentDescription', 'A descrição deve conter pelo menos uma letra e não pode conter apenas caracteres especiais ou números.');
            return;
        }

        try {
            // Busca novamente o projeto
            $project = ProjectModel::findOrFail($this->projectId);

            // Atualiza ou cria a estratégia de busca vinculada ao projeto
            $project->searchStrategy()
                ->updateOrCreate([], ['description' => $this->currentDescription]);

            // Registra a ação no log do sistema
            Log::logActivity(
                action: 'Updated the search strategy',
                description: $this->currentDescription,
                projectId: $this->projectId
            );

            // Exibe notificação de sucesso
            $this->toast(
                message: __('project/planning.search-strategy.success'),
                type: 'success'
            );
        } catch (\Exception $e) {
            // Em caso de erro, exibe mensagem de erro
            $this->toast(
                message: $e->getMessage(),
                type: 'error'
            );
        }
    }

    /**
     * Verifica se a descrição fornecida é válida.
     * Regras:
     * - Deve conter pelo menos uma letra
     * - Não pode ser apenas números ou caracteres especiais
     *
     * @param string $description Descrição a ser validada
     * @return bool Retorna true se for válida
     */
    private function isValidDescription(string $description): bool
    {
        // Remove espaços em branco das extremidades
        $trimmedDescription = trim($description);

        // Verifica se contém pelo menos uma letra (inclusive acentos)
        if (!preg_match('/[a-zA-ZÀ-ÿ]/', $trimmedDescription)) {
            return false;
        }

        // Verifica se é composta apenas por números ou símbolos
        if (preg_match('/^[\d\W]+$/', $trimmedDescription)) {
            return false;
        }
    
        return true;
    }

    /**
     * Renderiza a view associada a este componente.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.planning.search-strategy.strategy');
    }
}
