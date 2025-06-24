<?php

namespace App\Livewire\Planning\Overall;

use App\Utils\ToastHelper;
use Livewire\Component;
use App\Models\StudyType as StudyTypeModel;
use App\Models\Project as ProjectModel;
use App\Models\ProjectStudyType as ProjectStudyTypeModel;
use App\Utils\ActivityLogHelper as Log;
use App\Traits\ProjectPermissions;

/**
 * Componente Livewire responsável pelo gerenciamento dos tipos de estudo
 * de um projeto de revisão sistemática da literatura.
 * 
 * Os tipos de estudo representam diferentes categorias ou classificações
 * metodológicas dos estudos que serão incluídos na revisão e são fundamentais para:
 * - Definir o escopo metodológico da revisão sistemática
 * - Estabelecer critérios de inclusão/exclusão baseados na metodologia
 * - Facilitar a análise e síntese dos resultados por tipo de estudo
 * 
 * Este componente faz parte da fase de planejamento geral da revisão sistemática,
 * onde os pesquisadores definem quais tipos de estudos serão considerados
 * relevantes para responder às questões de pesquisa. A definição adequada
 * dos tipos de estudo é crucial para a qualidade e validade da revisão.
 * 
 * Funcionalidades:
 * - Adicionar tipos de estudo pré-definidos ao projeto
 * - Remover tipos de estudo desnecessários
 * - Validação para evitar tipos duplicados
 * - Log de atividades para auditoria e rastreabilidade
 * 
 * Nota: Trabalha com tipos de estudo pré-cadastrados no sistema,
 * não permitindo criação de novos tipos pelos usuários.
 */
class Studies extends Component
{

    use ProjectPermissions;

    /**
     * Caminho base para as traduções específicas deste componente.
     * Utilizado para internacionalização (PT/BR e EN).
     * 
     * @var string
     */
    private $translationPath = 'project/planning.overall.study_type.livewire';
    
    /**
     * Caminho para as mensagens de toast específicas deste componente.
     * Utilizado para feedback visual ao usuário após operações.
     * 
     * @var string
     */
    private $toastMessages = 'project/planning.overall.study_type.livewire.toasts';

    /**
     * Instância do projeto atual sendo editado.
     * Contém todos os dados do projeto de revisão sistemática.
     * 
     * @var ProjectModel
     */
    public $currentProject;
    
    /**
     * Coleção de todos os tipos de estudo disponíveis no sistema.
     * Lista pré-definida de tipos metodológicos que podem ser associados ao projeto.
     * 
     * @var \Illuminate\Database\Eloquent\Collection
     */
    public $studies = [];

    /**
     * Fields to be filled by the form.
     */
    
    /**
     * Tipo de estudo selecionado no formulário.
     * Array contendo informações do tipo de estudo escolhido pelo usuário.
     * Estrutura esperada: ['value' => id_study_type, 'label' => description]
     * 
     * @var array|null
     */
    public $studyType;

    /**
     * Validation rules.
     */
    protected $rules = [
        'currentProject' => 'required',
        'studyType' => 'required|array',
        'studyType.*.value' => 'number',
    ];

    /**
     * Custom error messages for the validation rules.
     */
    protected function messages()
    {
        return [
            'studyType.required' => __($this->translationPath . '.study_type.required'),
        ];
    }

    /**
     * Dispatch a toast message to the view.
     */
    public function toast(string $message, string $type)
    {
        $this->dispatch('studies', ToastHelper::dispatch($type, $message));
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
        
        // Carrega todos os tipos de estudo disponíveis no sistema
        // Estes são tipos pré-cadastrados que podem ser associados ao projeto
        $this->studies = StudyTypeModel::all();
    }

    /**
     * Submit the form. It also validates the input fields.
     */
    public function submit()
    {
        // Verifica se o usuário tem permissão para editar
        // Visualizadores não podem adicionar ou remover tipos de estudo
        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        // Valida os dados do formulário conforme as regras definidas
        $this->validate();

        try {
            // Tenta criar uma nova associação projeto-tipo de estudo
            // firstOrNew retorna um modelo existente ou cria um novo sem salvar
            $projectStudyType = ProjectStudyTypeModel::firstOrNew([
                'id_project' => $this->currentProject->id_project,
                'id_study_type' => $this->studyType["value"],
            ]);

            // Verifica se a associação já existe no banco de dados
            // Importante para evitar duplicatas na relação many-to-many
            if ($projectStudyType->exists) {
                $this->toast(
                    message: __($this->translationPath . '.study_type.already_exists'),
                    type: 'info'
                );
                return;
            }

            // Carrega os dados completos do tipo de estudo para o log
            $studyType = StudyTypeModel::findOrFail($this->studyType["value"]);

            Log::logActivity(
                action: 'Added the study',
                description: $studyType->description,
                projectId: $this->currentProject->id_project,
            );

            // Salva a nova associação projeto-tipo de estudo no banco de dados
            $projectStudyType->save();
            $this->toast(
                message: __($this->toastMessages . '.added'),
                type: 'success'
            );
        } catch (\Exception $e) {
            $this->addError('studyType', $e->getMessage());
        }
    }

    /**
     * Delete an item.
     */
    public function delete(string $studyTypeId)
    {
        // Verifica se o usuário tem permissão para excluir
        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }
        
        // Localiza a associação projeto-tipo de estudo específica
        // Busca pela combinação de projeto e tipo de estudo para garantir precisão
        $studyType = ProjectStudyTypeModel::where('id_project', $this->currentProject->id_project)
            ->where('id_study_type', $studyTypeId)
            ->first();

        // Carrega os dados do tipo de estudo para o log antes da exclusão
        $deleted = StudyTypeModel::findOrFail($studyTypeId);
        
        // Remove a associação projeto-tipo de estudo do banco de dados
        // Usa safe navigation operator (?->) para evitar erro se não encontrar
        $studyType?->delete();

        // Registra a exclusão no log do sistema para auditoria
        Log::logActivity(
            action: 'Deleted the study',
            description: $deleted->description,
            projectId: $this->currentProject->id_project,
        );

        $this->toast(
            message: __($this->toastMessages . '.deleted'),
            type: 'success'
        );
    }

    /**
     * Render the component.
     */
    public function render()
    {
        $project = $this->currentProject;

        return view(
            'livewire.planning.overall.studies',
            compact(
                'project',
            )
        )->extends('layouts.app');
    }
}
