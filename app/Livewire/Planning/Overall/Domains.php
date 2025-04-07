<?php

namespace App\Livewire\Planning\Overall;

use Livewire\Component;
use App\Models\Project as ProjectModel;
use App\Models\Domain as DomainModel;
use App\Utils\ActivityLogHelper as Log;
use App\Utils\ToastHelper;

class Domains extends Component
{
    private $translationPath = 'project/planning.overall.domain.livewire';
    private $toastMessages = 'project/planning.overall.domain.livewire.toasts';

    public $currentProject;
    public $currentDomain;
    public $domains = [];

    /**
     * Campos preenchidos pelo formulário.
     */
    public $description;

    /**
     * Estado do formulário (edição ou criação).
     */
    public $form = [
        'isEditing' => false,
    ];

    /**
     * Regras de validação para os campos do formulário.
     * 
     * Modificado por LuizaVelasque:
     * - Adicionado regex para impedir caracteres especiais na descrição.
     */
    protected $rules = [
        'currentProject' => 'required',
        'description' => [
            'required',
            'string',
            'max:255',
            'regex:/^[a-zA-ZÀ-ú0-9\s]+$/u'
        ],
    ];

    /**
     * Mensagens de erro personalizadas.
     */
    protected function messages()
    {
        return [
            'description.required' => __($this->translationPath . '.description.required'),
            'description.regex' => __('Descrição não pode conter caracteres especiais.'),
        ];
    }

    /**
     * Executado ao montar o componente. Define o projeto atual e busca os domínios relacionados.
     */
    public function mount()
    {
        $projectId = request()->segment(2);
        $this->currentProject = ProjectModel::findOrFail($projectId);
        $this->currentDomain = null;
        $this->domains = DomainModel::where(
            'id_project',
            $this->currentProject->id_project
        )->get();
    }

    /**
     * Reseta os campos do formulário para os valores padrões.
     */
    public function resetFields()
    {
        $this->description = '';
        $this->currentDomain = null;
        $this->form['isEditing'] = false;
    }

    /**
     * Atualiza a lista de domínios do projeto.
     */
    public function updateDomains()
    {
        $this->domains = DomainModel::where(
            'id_project',
            $this->currentProject->id_project
        )->get();
    }

    /**
     * Envia uma mensagem (toast) para a interface.
     */
    public function toast(string $message, string $type)
    {
        $this->dispatch('domains', ToastHelper::dispatch($type, $message));
    }

    /**
     * Submete o formulário: valida os campos e cria ou atualiza um domínio.
     */
    public function submit()
    {
        $this->validate();

        $updateIf = [
            'id_domain' => $this->currentDomain?->id_domain,
        ];

        $existingKeyword = DomainModel::where('description', $this->description)
            ->where('id_project', $this->currentProject->id_project)
            ->first();

        if ($existingKeyword && !$this->form['isEditing']) {
            $toastMessage = __($this->toastMessages . '.duplicate');
            $this->toast(
                message: $toastMessage,
                type: 'error'
            );
            return;
        }

        try {
            $value = $this->form['isEditing'] ? 'Updated the domain' : 'Added a domain';
            $toastMessage = __($this->toastMessages . ($this->form['isEditing']
                ? '.updated' : '.added'));

            $updatedOrCreated = DomainModel::updateOrCreate($updateIf, [
                'id_project' => $this->currentProject->id_project,
                'description' => $this->description,
            ]);

            Log::logActivity(
                action: $value,
                description: $updatedOrCreated->description,
                projectId: $this->currentProject->id_project
            );

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
            $this->resetFields();
        }
    }

    /**
     * Preenche os campos do formulário com os dados do domínio selecionado para edição.
     */
    public function edit(string $domainId)
    {
        $this->currentDomain = DomainModel::findOrFail($domainId);
        $this->description = $this->currentDomain->description;

        // Verifica se já existe outro domínio com a mesma descrição dentro do projeto (exceto o que está sendo editado)
        $existingKeyword = DomainModel::where('description', $this->description)
            ->where('id_project', $this->currentProject->id_project)
            ->where('id_domain', '!=', $this->currentDomain->id_domain)
            ->first();

        if ($existingKeyword) {
            $toastMessage = __($this->toastMessages . '.duplicate');
            $this->toast(
                message: $toastMessage,
                type: 'error'
            );
            return;
        }

        $this->form['isEditing'] = true;
    }

    /**
     * Exclui um domínio.
     */
    public function delete(string $domainId)
    {
        try {
            $currentDomain = DomainModel::findOrFail($domainId);
            $currentDomain->delete();

            Log::logActivity(
                action: 'Deleted the domain',
                description: $currentDomain->description,
                projectId: $this->currentProject->id_project
            );

            $this->toast(
                message: __($this->toastMessages . '.deleted'),
                type: 'success'
            );
            $this->updateDomains();
        } catch (\Exception $e) {
            $this->toast(
                message: $e->getMessage(),
                type: 'error'
            );
        } finally {
            $this->resetFields();
        }

    }
/**
 * Renderiza o componente.
 */
public function render()
{
    $project = $this->currentProject;

    return view(
        'livewire.planning.overall.domains',
        compact('project')
    );
}
