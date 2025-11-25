<?php

namespace App\Livewire\Planning\Overall;

use App\Utils\ToastHelper;
use Livewire\Component;
use App\Models\Project as ProjectModel;
use App\Models\Keyword as KeywordModel;
use App\Utils\ActivityLogHelper as Log;
use App\Traits\ProjectPermissions;

/**
 * Componente Livewire responsável pelo gerenciamento das palavras-chave
 * de um projeto de revisão sistemática da literatura.
 *
 * As palavras-chave são termos ou frases que representam conceitos-chave
 * na pesquisa e são fundamentais para:
 * - Categorizar e organizar as fontes de literatura
 * - Facilitar a identificação de informações relevantes
 * - Auxiliar na construção de strings de busca
 * - Definir o escopo temático da revisão sistemática
 *
 * Este componente faz parte da fase de planejamento geral da revisão sistemática,
 * onde os pesquisadores definem os termos principais que guiarão suas buscas
 * nas bases de dados acadêmicas.
 *
 * Funcionalidades:
 * - Adicionar novas palavras-chave ao projeto
 * - Editar palavras-chave existentes
 * - Excluir palavras-chave desnecessárias
 * - Validação para evitar palavras-chave duplicadas
 * - Log de atividades para auditoria e rastreabilidade
 */
class Keywords extends Component
{

    use ProjectPermissions;

    /**
     * Caminho base para as traduções específicas deste componente.
     * Utilizado para internacionalização (PT/BR e EN).
     *
     * @var string
     */
    private $translationPath = 'project/planning.overall.keyword.livewire';

    /**
     * Caminho para as mensagens de toast específicas deste componente.
     * Utilizado para feedback visual ao usuário após operações CRUD.
     *
     * @var string
     */
    private $toastMessages = 'project/planning.overall.keyword.livewire.toasts';

    /**
     * Instância do projeto atual sendo editado.
     * Contém todos os dados do projeto de revisão sistemática.
     *
     * @var ProjectModel
     */
    public $currentProject;

    /**
     * Palavra-chave atualmente sendo editada.
     * Null quando não há edição em andamento (modo criação).
     *
     * @var KeywordModel|null
     */
    public $currentKeyword;

    /**
     * Coleção de todas as palavras-chave associadas ao projeto atual.
     * Atualizada dinamicamente conforme operações CRUD são realizadas.
     *
     * @var \Illuminate\Database\Eloquent\Collection
     */
    public $keywords = [];

    /**
     * Fields to be filled by the form.
     */

    /**
     * Descrição da palavra-chave.
     * Campo principal que define o termo ou frase da palavra-chave.
     * Utilizado tanto para criação quanto para edição.
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
        'description' => 'required|string|regex:/^[\pL\pN\s\.,;:\?"\'\(\)\[\]\{\}\/\\\\_\-+=#@!%&*]+$/u|max:255',
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
        // Ex: /projects/123/planning/overall -> projectId = 123
        $projectId = request()->segment(2);

        // Carrega o projeto atual ou falha se não encontrado
        $this->currentProject = ProjectModel::findOrFail($projectId);

        // Inicializa a palavra-chave atual como null (modo criação)
        $this->currentKeyword = null;

        // Carrega todas as palavras-chave associadas ao projeto
        $this->keywords = KeywordModel::where(
            'id_project',
            $this->currentProject->id_project
        )->get();
    }

    /**
     * Dispatch a toast message to the view.
     */
    public function toast(string $message, string $type)
    {
        $this->dispatch('keywords', ToastHelper::dispatch($type, $message));
    }

    /**
     * Reset the fields to the default values.
     */
    public function resetFields()
    {
        // Limpa o campo de descrição
        $this->description = '';

        // Remove a referência à palavra-chave atual
        $this->currentKeyword = null;

        // Retorna o formulário ao modo de criação
        $this->form['isEditing'] = false;
    }

    /**
     * Update the items.
     */
    public function updateKeywords()
    {
        // Recarrega a lista de palavras-chave do banco de dados
        // Utilizado após operações CRUD para manter a interface sincronizada
        $this->keywords = KeywordModel::where(
            'id_project',
            $this->currentProject->id_project
        )->get();
    }

    /**
     * Submit the form. It validates the input fields
     * and creates or updates an item.
     */
    public function submit()
    {
        // Verifica se o usuário tem permissão para editar
        // Visualizadores não podem adicionar, editar ou excluir palavras-chave
        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        // Valida os dados do formulário conforme as regras definidas
        $this->validate();

        // Define critérios para atualização (se estiver editando)
        // Se currentKeyword for null, será uma criação
        $updateIf = [
            'id_keyword' => $this->currentKeyword?->id_keyword,
        ];

        // Verifica se já existe uma palavra-chave com a mesma descrição no projeto
        // Importante para evitar duplicatas que podem confundir a estratégia de busca
        $existingKeyword = KeywordModel::where('description', $this->description)
            ->where('id_project', $this->currentProject->id_project)
            ->first();

        // Previne duplicação apenas em modo de criação
        // Em modo de edição, a verificação é feita no método edit()
        if ($existingKeyword && !$this->form['isEditing']) {
            $toastMessage = __($this->toastMessages . '.duplicate');
            $this->toast(
                message: $toastMessage,
                type: 'error'
            );
            return;
        }

        // Define a mensagem de sucesso baseada no modo do formulário
        $toastMessage = $this->form['isEditing']
            ? $this->toastMessages . '.updated'
            : $this->toastMessages . '.added';

        try {
            // Cria ou atualiza a palavra-chave no banco de dados
            // updateOrCreate é usado para simplificar a lógica de criação/atualização
            $updatedOrCreated = KeywordModel::updateOrCreate($updateIf, [
                'id_project' => $this->currentProject->id_project,
                'description' => $this->description,
            ]);

            // Registra a atividade no log do sistema para auditoria
            Log::logActivity(
                action: $this->form['isEditing'] ? 'Updated the keyword' : 'Added a keyword',
                description: $updatedOrCreated->description,
                module: 1,
                projectId: $this->currentProject->id_project
            );

            // Atualiza a lista de palavras-chave na interface
            $this->updateKeywords();
            $this->toast(
                message: $toastMessage,
                type: 'success'
            );
        } catch (\Exception $e) {
            $this->addError('description', $e->getMessage());
        } finally {
            // Sempre limpa os campos após a operação, independente do resultado
            $this->resetFields();
        }
    }

    /**
     * Fill the form fields with the given data.
     */
    public function edit(string $keywordId)
    {
        // Verifica se o usuário tem permissão para editar
        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        // Carrega a palavra-chave a ser editada
        $this->currentKeyword = KeywordModel::findOrFail($keywordId);
        $this->description = $this->currentKeyword->description;

        // Verifica se existe outra palavra-chave com a mesma descrição no projeto,
        // excluindo a palavra-chave atual da verificação
        // Isso previne conflitos durante a edição
        $existingKeyword = KeywordModel::where('description', $this->description)
            ->where('id_project', $this->currentProject->id_project)
            ->where('id_keyword', '!=', $this->currentKeyword->id_keyword)
            ->first();

        // Se encontrar duplicata, impede a edição e exibe erro
        if ($existingKeyword) {
            $toastMessage = __($this->toastMessages . '.duplicate');
            $this->toast(
                message: $toastMessage,
                type: 'error'
            );
            return;
        }

        // Ativa o modo de edição no formulário
        $this->form['isEditing'] = true;
    }

    /**
     * Delete an item.
     */
    public function delete(string $keywordId)
    {
        // Verifica se o usuário tem permissão para excluir
        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        // Localiza a palavra-chave a ser excluída
        $currentKeyword = KeywordModel::findOrFail($keywordId);

        // Remove a palavra-chave do banco de dados
        $currentKeyword->delete();

        // Registra a exclusão no log do sistema para auditoria
        Log::logActivity(
            action: 'Deleted the keyword',
            description: $currentKeyword->description,
            module: 1,
            projectId: $this->currentProject->id_project
        );

        // Atualiza a lista de palavras-chave na interface
        $this->updateKeywords();

        // Limpa os campos do formulário
        $this->resetFields();
        $this->toast(
            message: $this->toastMessages . '.deleted',
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
            'livewire.planning.overall.keywords',
            compact(
                'project',
            )
        )->extends('layouts.app');
    }
}
