<?php

namespace App\Livewire\Planning\Overall;

use App\Utils\ToastHelper;
use Livewire\Component;
use App\Models\Language as LanguageModel;
use App\Models\Project as ProjectModel;
use App\Models\ProjectLanguage as ProjectLanguageModel;
use App\Utils\ActivityLogHelper as Log;
use App\Traits\ProjectPermissions;

/**
 * Componente Livewire responsável pelo gerenciamento dos idiomas
 * de um projeto de revisão sistemática da literatura.
 * 
 * Os idiomas representam as diferentes línguas nas quais as fontes de literatura
 * são escritas e são fundamentais para:
 * - Definir o escopo linguístico da revisão sistemática
 * - Filtrar estudos por idioma durante as buscas
 * - Estabelecer critérios de inclusão/exclusão baseados no idioma
 * - Garantir que a revisão abranja a literatura relevante em diferentes idiomas
 * 
 * Este componente faz parte da fase de planejamento geral da revisão sistemática,
 * onde os pesquisadores definem quais idiomas serão considerados na busca
 * e seleção de estudos.
 * 
 * Funcionalidades:
 * - Adicionar idiomas pré-definidos ao projeto
 * - Remover idiomas desnecessários
 * - Validação para evitar idiomas duplicados
 * - Log de atividades para auditoria e rastreabilidade
 * 
 * Nota: Diferente de outros componentes, este trabalha com idiomas pré-cadastrados
 * no sistema, não permitindo criação de novos idiomas pelos usuários.
 */
class Languages extends Component
{

    use ProjectPermissions;

    /**
     * Caminho base para as traduções específicas deste componente.
     * Utilizado para internacionalização (PT/BR e EN).
     * 
     * @var string
     */
    private $translationPath = 'project/planning.overall.language.livewire';
    
    /**
     * Caminho para as mensagens de toast específicas deste componente.
     * Utilizado para feedback visual ao usuário após operações.
     * 
     * @var string
     */
    private $toastMessages = 'project/planning.overall.language.livewire.toasts';

    /**
     * Instância do projeto atual sendo editado.
     * Contém todos os dados do projeto de revisão sistemática.
     * 
     * @var ProjectModel
     */
    public $currentProject;
    
    /**
     * Coleção de todos os idiomas disponíveis no sistema.
     * Lista pré-definida de idiomas que podem ser associados ao projeto.
     * 
     * @var \Illuminate\Database\Eloquent\Collection
     */
    public $languages = [];

    /**
     * Fields to be filled by the form.
     */
    
    /**
     * Idioma selecionado no formulário.
     * Array contendo informações do idioma escolhido pelo usuário.
     * Estrutura esperada: ['value' => id_language, 'label' => description]
     * 
     * @var array|null
     */
    public $language;

    /**
     * Validation rules.
     */
    protected $rules = [
        'currentProject' => 'required',
        'language' => 'required|array',
        'language.*.value' => 'number|exists:languages,id_language',
    ];

    /**
     * Custom error messages for the validation rules.
     */
    protected function messages()
    {
        return [
            'language.required' => __($this->translationPath . '.language.required'),
        ];
    }

    /**
     * Executed when the component is mounted. It sets the
     * project id and retrieves the items.
     */
    public function mount()
    {
        // Obtém o ID do projeto a partir da URL (segundo segmento)
        // Ex: /projects/123/planning/overall -> projectId = 123
        $projectId = request()->segment(2);
        
        // Carrega o projeto atual ou falha se não encontrado
        $this->currentProject = ProjectModel::findOrFail($projectId);
        
        // Carrega todos os idiomas disponíveis no sistema
        // Estes são idiomas pré-cadastrados que podem ser associados ao projeto
        $this->languages = LanguageModel::all();
    }

    /**
     * Dispatch a toast message to the view.
     */
    public function toast(string $message, string $type)
    {
        $this->dispatch('languages', ToastHelper::dispatch($type, $message));
    }

    /**
     * Submit the form. It also validates the input fields.
     */
    public function submit()
    {
        // Verifica se o usuário tem permissão para editar
        // Visualizadores não podem adicionar ou remover idiomas
        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        // Valida os dados do formulário conforme as regras definidas
        $this->validate();

        try {
            // Tenta criar uma nova associação projeto-idioma
            // firstOrNew retorna um modelo existente ou cria um novo sem salvar
            $projectLanguage = ProjectLanguageModel::firstOrNew([
                'id_project' => $this->currentProject->id_project,
                'id_language' => $this->language["value"],
            ]);

            // Verifica se a associação já existe no banco de dados
            // Importante para evitar duplicatas na relação many-to-many
            if ($projectLanguage->exists) {
                $this->toast(
                    message: __($this->translationPath . '.language.already_exists'),
                    type: 'info',
                );
                return;
            }

            // Carrega os dados completos do idioma para o log
            $language = LanguageModel::findOrFail($this->language["value"]);

            // Registra a atividade no log do sistema para auditoria
            Log::logActivity(
                action: 'Added the language',
                description: $language->description,
                projectId: $this->currentProject->id_project,
            );

            // Salva a nova associação projeto-idioma no banco de dados
            $projectLanguage->save();

            $this->toast(
                message: __($this->toastMessages . '.added'),
                type: 'success',
            );
        } catch (\Exception $e) {
            $this->addError('language', $e->getMessage());
        }
    }

    /**
     * Delete an item.
     */
    public function delete(string $languageId)
    {
        // Verifica se o usuário tem permissão para excluir
        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        // Localiza a associação projeto-idioma específica
        // Busca pela combinação de projeto e idioma para garantir precisão
        $language = ProjectLanguageModel::where('id_project', $this->currentProject->id_project)
            ->where('id_language', $languageId)
            ->first();

        // Carrega os dados do idioma para o log antes da exclusão
        $deleted = LanguageModel::findOrFail($languageId);
        
        // Remove a associação projeto-idioma do banco de dados
        $language->delete();

        Log::logActivity(
            action: 'Deleted the language',
            description: $deleted->description,
            projectId: $this->currentProject->id_project,
        );

        $this->toast(
            message: __($this->toastMessages . '.deleted'),
            type: 'success',
        );
    }

    /**
     * Render the component.
     */
    public function render()
    {
        $project = $this->currentProject;

        return view(
            'livewire.planning.overall.languages',
            compact(
                'project',
            )
        )->extends('layouts.app');
    }
}
