<?php

namespace App\Livewire\Planning\Overall;

use Livewire\Component;
use App\Models\Project as ProjectModel;
use App\Models\Domain as DomainModel;
use App\Utils\ActivityLogHelper as Log;
use App\Utils\ToastHelper;
use App\Traits\ProjectPermissions;

/**
 * Componente Livewire responsável pelo gerenciamento dos domínios de conhecimento
 * de um projeto de revisão sistemática da literatura.
 * 
 * Os domínios representam as áreas de conhecimento ou campos de estudo que serão
 * abordados na revisão sistemática. Eles ajudam a categorizar e organizar o escopo
 * da pesquisa, facilitando a identificação de estudos relevantes e a análise
 * posterior dos resultados.
 * 
 * Funcionalidades:
 * - Adicionar novos domínios ao projeto
 * - Editar domínios existentes
 * - Excluir domínios desnecessários
 * - Validação para evitar domínios duplicados
 * - Log de atividades para auditoria
 */
class Domains extends Component
{

    use ProjectPermissions;

    /**
     * Caminho base para as traduções específicas deste componente.
     * Utilizado para internacionalização (PT/BR e EN).
     * 
     * @var string
     */
    private $translationPath = 'project/planning.overall.domain.livewire';
    
    /**
     * Caminho para as mensagens de toast específicas deste componente.
     * Utilizado para feedback visual ao usuário após operações.
     * 
     * @var string
     */
    private $toastMessages = 'project/planning.overall.domain.livewire.toasts';

    /**
     * Instância do projeto atual sendo editado.
     * Contém todos os dados do projeto de revisão sistemática.
     * 
     * @var ProjectModel
     */
    public $currentProject;
    
    /**
     * Domínio atualmente sendo editado.
     * Null quando não há edição em andamento.
     * 
     * @var DomainModel|null
     */
    public $currentDomain;
    
    /**
     * Coleção de todos os domínios associados ao projeto atual.
     * Atualizada dinamicamente conforme operações CRUD.
     * 
     * @var \Illuminate\Database\Eloquent\Collection
     */
    public $domains = [];

    /**
     * Fields to be filled by the form.
     */
    
    /**
     * Descrição do domínio de conhecimento.
     * Campo principal que define o nome/descrição da área de conhecimento.
     * 
     * @var string|null
     */
    public $description;

    /**
     * Form state.
     */
    
    /**
     * Estado do formulário para controle de operações.
     * Controla se o formulário está em modo de edição ou criação.
     * 
     * @var array
     */
    public $form = [
        'isEditing' => false,
    ];

    /**
     * Validation rules.
     */
    protected $rules = [
        'currentProject' => 'required',
        'description' => 'required|string|max:255',
    ];

    /**
     * Custom error messages for the validation rules.
     */
    protected function messages()
    {
        return [
            'description.required' => __($this->translationPath . '.description.required'),
        ];
    }

    /**
     * Executed when the component is mounted. It sets the
     * project id and retrieves the items.
     */
    public function mount()
    {
        // Obtém o ID do projeto a partir da URL (segundo segmento)
        $projectId = request()->segment(2);
        
        // Carrega o projeto atual ou falha se não encontrado
        $this->currentProject = ProjectModel::findOrFail($projectId);
        
        // Inicializa o domínio atual como null (modo criação)
        $this->currentDomain = null;
        
        // Carrega todos os domínios associados ao projeto
        $this->domains = DomainModel::where(
            'id_project',
            $this->currentProject->id_project
        )->get();
    }

    /**
     * Reset the fields to the default values.
     */
    public function resetFields()
    {
        // Limpa o campo de descrição
        $this->description = '';
        
        // Remove a referência ao domínio atual
        $this->currentDomain = null;
        
        // Retorna o formulário ao modo de criação
        $this->form['isEditing'] = false;
    }

    /**
     * Update the items.
     */
    public function updateDomains()
    {
        // Recarrega a lista de domínios do banco de dados
        // Utilizado após operações CRUD para manter a interface sincronizada
        $this->domains = DomainModel::where(
            'id_project',
            $this->currentProject->id_project
        )->get();
    }

    /**
     * Dispatch a toast message to the view.
     */
    public function toast(string $message, string $type)
    {
        $this->dispatch('domains', ToastHelper::dispatch($type, $message));
    }

    /**
     * Submit the form. It validates the input fields
     * and creates or updates an item.
     */
    public function submit()
    {

        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        // Valida os dados do formulário
        $this->validate();

        // Define critérios para atualização (se estiver editando)
        $updateIf = [
            'id_domain' => $this->currentDomain?->id_domain,
        ];
        
        // Verifica se já existe um domínio com a mesma descrição no projeto
        $existingKeyword = DomainModel::where('description', $this->description)
            ->where('id_project', $this->currentProject->id_project)
            ->first();

        // Previne duplicação apenas em modo de criação
        if ($existingKeyword && !$this->form['isEditing']) {
            $toastMessage = __($this->toastMessages . '.duplicate');
            $this->toast(
                message: $toastMessage,
                type: 'error'
            );
            return;
        }
        
        try {
            // Define a ação para o log baseada no modo do formulário
            $value = $this->form['isEditing'] ? 'Updated the domain' : 'Added a domain';
            $toastMessage = __($this->toastMessages . ($this->form['isEditing']
                ? '.updated' : '.added'));

            // Cria ou atualiza o domínio no banco de dados
            $updatedOrCreated = DomainModel::updateOrCreate($updateIf, [
                'id_project' => $this->currentProject->id_project,
                'description' => $this->description,
            ]);

            // Registra a atividade no log do sistema
            Log::logActivity(
                action: $value,
                description: $updatedOrCreated->description,
                projectId: $this->currentProject->id_project
            );

            // Atualiza a lista de domínios na interface
            $this->updateDomains();
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
            // Sempre limpa os campos após a operação
            $this->resetFields();
        }
    }

    /**
     * Fill the form fields with the given data.
     */
    public function edit(string $domainId)
    {

        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        // Carrega o domínio a ser editado
        $this->currentDomain = DomainModel::findOrFail($domainId);
        $this->description = $this->currentDomain->description;

        // Verificar se existe outro domínio com a mesma descrição dentro do projeto, exceto o que está sendo editado
        $existingKeyword = DomainModel::where('description', $this->description)
            ->where('id_project', $this->currentProject->id_project)
            ->where('id_domain', '!=', $this->currentDomain->id_domain) // Excluir o domínio atual da verificação
            ->first();

        // Previne edição para descrição duplicada
        if ($existingKeyword) {
            $toastMessage = __($this->toastMessages . '.duplicate');
            $this->toast(
                message: $toastMessage,
                type: 'error'
            );
            return;
        }

        // Ativa o modo de edição
        $this->form['isEditing'] = true;
    }

    /**
     * Delete an item.
     */
    public function delete(string $domainId)
    {

        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        try {
            // Localiza o domínio a ser excluído
            $currentDomain = DomainModel::findOrFail($domainId);
            
            // Remove o domínio do banco de dados
            $currentDomain->delete();

            // Registra a exclusão no log do sistema
            Log::logActivity(
                action: 'Deleted the domain',
                description: $currentDomain->description,
                projectId: $this->currentProject->id_project
            );

            // Exibe mensagem de sucesso
            $this->toast(
                message: __($this->toastMessages . '.deleted'),
                type: 'success'
            );
            
            // Atualiza a lista de domínios
            $this->updateDomains();
        } catch (\Exception $e) {
            $this->toast(
                message: $e->getMessage(),
                type: 'error'
            );
        } finally {
            // Sempre limpa os campos após a operação
            $this->resetFields();
        }
    }

    /**
     * Render the component.
     */
    public function render()
    {
        $project = $this->currentProject;

        return view(
            'livewire.planning.overall.domains',
            compact(
                'project',
            )
        )->extends('layouts.app');
    }
}
