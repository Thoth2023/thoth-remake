<?php

namespace App\Livewire\Planning\Criteria;

use Livewire\Component;
use App\Models\Project as ProjectModel;
use App\Models\Project\Conducting\StudySelection\PapersSelection as PapersSelectionModel;
use App\Models\Member as MemberModel;
use App\Models\EvaluationCriteria as EvaluationCriteriaModel;
use App\Models\Criteria as CriteriaModel;
use App\Utils\ActivityLogHelper as Log;
use App\Utils\ToastHelper;
use App\Traits\ProjectPermissions;
use App\Traits\LivewireExceptionHandler;

/**
 * Componente Livewire para gerenciamento de critérios de planejamento de projeto.
 *
 * Este componente permite criar, editar, excluir e gerenciar critérios de inclusão
 * e exclusão para projetos, incluindo a definição de regras (ALL, ANY, AT_LEAST)
 * e seleção de critérios pré-selecionados.
 *
 * @package App\Livewire\Planning\Criteria
 * @author Felipe H. Scherer
 */
class Criteria extends Component
{
    use ProjectPermissions;
    use LivewireExceptionHandler;

    /**
     * Caminho base para as mensagens de toast traduzidas.
     *
     * @var string
     */
    private $toastMessages = 'project/planning.criteria.livewire.toasts';

    /**
     * Projeto atual sendo gerenciado.
     *
     * @var ProjectModel|null
     */
    public $currentProject;

    /**
     * Critério atual sendo editado.
     *
     * @var CriteriaModel|null
     */
    public $currentCriteria;

    /**
     * Lista de todos os critérios do projeto atual.
     *
     * @var \Illuminate\Database\Eloquent\Collection
     */
    public $criterias = [];

    /**
     * Tipo do critério (Inclusion/Exclusion).
     *
     * @var array
     */
    public $type;

    /**
     * Descrição do critério.
     *
     * @var string
     */
    public $description;

    /**
     * ID único do critério.
     *
     * @var string
     */
    public $criteriaId;

    /**
     * Regra de inclusão aplicada aos critérios de inclusão.
     *
     * @var array
     */
    public $inclusion_rule;

    /**
     * Regra de exclusão aplicada aos critérios de exclusão.
     *
     * @var array
     */
    public $exclusion_rule;

    /**
     * Estado do formulário.
     *
     * @var array
     */
    public $form = [
        'isEditing' => false,
    ];

    // -----------------------------------------------------------------------
    // Estado dos modais de confirmação
    // -----------------------------------------------------------------------

    /**
     * ID do critério pendente de exclusão.
     *
     * @var string|null
     */
    public $confirmingDeleteId = null;

    /**
     * Indica se o critério a ser excluído possui avaliações vinculadas.
     *
     * @var bool
     */
    public $deletionHasEvaluations = false;

    /**
     * Controla exibição do modal de confirmação do submit.
     *
     * @var bool
     */
    public $confirmingSubmit = false;

    // -----------------------------------------------------------------------
    // Validação
    // -----------------------------------------------------------------------

    /**
     * Define as regras de validação para os campos do formulário.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'currentProject'  => 'required',
            'criteriaId'      => 'required|string|max:20|regex:/^[a-zA-Z0-9]+$/',
            'description'     => 'required|string|regex:/^[\pL\pN\s\.,;:\?"\'\(\)\[\]\{\}\/\\\\_\-+=#@!%&*]+$/u|max:255',
            'type'            => 'required|array',
            'type.*.value'    => 'string',
        ];
    }

    /**
     * Define mensagens personalizadas para as regras de validação.
     *
     * @return array
     */
    protected function messages()
    {
        $tpath = 'project/planning.criteria.livewire';

        return [
            'description.required' => __($tpath . '.description.required'),
            'criteriaId.required'  => __($tpath . '.criteriaId.required'),
            'criteriaId.regex'     => __($tpath . '.criteriaId.regex'),
            'type.value.required'  => __($tpath . '.type.required'),
            'type.value.in'        => __($tpath . '.type.in'),
        ];
    }

    // -----------------------------------------------------------------------
    // Ciclo de vida
    // -----------------------------------------------------------------------

    /**
     * Inicializa o componente quando é montado.
     *
     * @return void
     */
    public function mount()
    {
        try {
            $projectId = request()->segment(2);

            $this->currentProject = ProjectModel::findOrFail($projectId);

            $this->criterias = CriteriaModel::where(
                'id_project',
                $this->currentProject->id_project
            )->get();

            $this->inclusion_rule['value'] = CriteriaModel::where(
                'id_project',
                $this->currentProject->id_project
            )->where('type', 'Inclusion')->first()->rule ?? 'ALL';

            $this->exclusion_rule['value'] = CriteriaModel::where(
                'id_project',
                $this->currentProject->id_project
            )->where('type', 'Exclusion')->first()->rule ?? 'ANY';

            $this->type['value'] = 'NONE';

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            $this->toast(
                message: __('O projeto não foi encontrado.'),
                type: 'error'
            );
            return redirect()->route('projects.index');
        } catch (\Exception $e) {
            $this->toast(
                message: __('Ocorreu um erro ao carregar os dados: ') . $e->getMessage(),
                type: 'error'
            );
        }
    }

    // -----------------------------------------------------------------------
    // Helpers internos
    // -----------------------------------------------------------------------

    /**
     * Reseta todos os campos do formulário para seus valores padrão.
     *
     * @return void
     */
    public function resetFields()
    {
        $this->criteriaId              = null;
        $this->description             = null;
        $this->type['value']           = null;
        $this->currentCriteria         = null;
        $this->form['isEditing']       = false;
        $this->confirmingSubmit        = false;
        $this->confirmingDeleteId      = null;
        $this->deletionHasEvaluations  = false;
    }

    /**
     * Envia uma mensagem toast para a view.
     *
     * @param string $message
     * @param string $type
     * @return void
     */
    public function toast(string $message, string $type)
    {
        $this->dispatch('criteria', ToastHelper::dispatch($type, $message));
    }

    /**
     * Traduz mensagens baseado na chave fornecida.
     *
     * @param string $key
     * @return string
     */
    public function translate($key)
    {
        return __($this->toastMessages . '.' . $key);
    }

    /**
     * Verifica se já existem avaliações feitas por membros do projeto atual.
     *
     * @return bool
     */
    private function projectHasEvaluations(): bool
    {
        $memberIds = MemberModel::where('id_project', $this->currentProject->id_project)
            ->pluck('id_members');

        return PapersSelectionModel::whereIn('id_member', $memberIds)
            ->where('id_status', '!=', 3)
            ->exists();
    }

    /**
     * Reseta todas as avaliações de artigos do projeto,
     * removendo os critérios avaliados e marcando os artigos como não avaliados.
     *
     * @return void
     */
    private function resetPaperEvaluations()
    {
        $memberIds = MemberModel::where('id_project', $this->currentProject->id_project)
            ->pluck('id_members');

        $papersSelection = PapersSelectionModel::whereIn('id_member', $memberIds)
            ->where('id_status', '!=', 3)
            ->get();

        EvaluationCriteriaModel::whereIn('id_member', $memberIds)
            ->whereIn('id_paper', $papersSelection->pluck('id_paper'))
            ->delete();

        if ($papersSelection->isEmpty()) {
            return;
        }

        foreach ($papersSelection as $paperSelection) {
            $paperSelection->update(['id_status' => 3]);
        }

        $this->toast(
            message: __('project/planning.criteria.livewire.toasts.reset_paper_evaluations'),
            type: 'success'
        );
    }

    /**
     * Atualiza a lista de critérios e as regras de inclusão/exclusão
     * a partir do banco de dados.
     *
     * @return void
     */
    public function updateCriterias()
    {
        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        $this->criterias = CriteriaModel::where(
            'id_project',
            $this->currentProject->id_project
        )->get();

        $this->inclusion_rule['value'] = CriteriaModel::where(
            'id_project',
            $this->currentProject->id_project
        )->where('type', 'Inclusion')->first()->rule ?? 'ALL';

        $this->exclusion_rule['value'] = CriteriaModel::where(
            'id_project',
            $this->currentProject->id_project
        )->where('type', 'Exclusion')->first()->rule ?? 'ANY';
    }

    // -----------------------------------------------------------------------
    // Submit — criação e edição de critério
    // -----------------------------------------------------------------------

    /**
     * Processa o envio do formulário.
     *
     * Se tipo ou regra mudarem em relação ao valor anterior,
     * abre modal de confirmação antes de salvar, pois as avaliações
     * existentes serão resetadas.
     * Edições apenas de descrição ou ID salvam diretamente, sem impacto
     * nas avaliações.
     *
     * @return void
     */
    public function submit()
    {
        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        $this->validate();

        $isEditing = $this->form['isEditing'];

        // Verifica duplicidade de ID
        if (!$isEditing && $this->currentProject->criterias->contains('id', $this->criteriaId)) {
            $this->toast(message: $this->translate('unique-id'), type: 'error');
            return;
        }

        if (
            $isEditing
            && $this->currentCriteria->id != $this->criteriaId
            && $this->currentProject->criterias->contains('id', $this->criteriaId)
        ) {
            $this->toast(message: $this->translate('unique-id'), type: 'error');
            return;
        }

        $newRule = $this->type['value'] === 'Inclusion'
            ? $this->inclusion_rule['value']
            : $this->exclusion_rule['value'];

        $typeChanged = $isEditing && $this->currentCriteria->type !== $this->type['value'];
        $ruleChanged = $isEditing && $this->currentCriteria->rule !== $newRule;

        // Se tipo ou regra mudaram E já existem avaliações, pede confirmação
        if (($typeChanged || $ruleChanged) && $this->projectHasEvaluations()) {
            $this->confirmingSubmit = true;
            $this->dispatch('openSubmitConfirm');
            return;
        }

        // Sem impacto em avaliações: salva diretamente
        $this->persistCriteria(resetEvaluations: false);
    }

    /**
     * Chamado quando o usuário confirma o modal de aviso do submit.
     * Persiste o critério e reseta as avaliações.
     *
     * @return void
     */
    public function confirmSubmit()
    {
        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        $this->persistCriteria(resetEvaluations: true);
    }

    /**
     * Persiste o critério no banco de dados (criação ou edição).
     *
     * @param bool $resetEvaluations Se true, reseta as avaliações dos artigos.
     * @return void
     */
    private function persistCriteria(bool $resetEvaluations = false)
    {
        try {
            $isEditing    = $this->form['isEditing'];
            $toastMessage = $this->translate($isEditing ? 'updated' : 'added');

            $updatedOrCreated = CriteriaModel::updateOrCreate(
                ['id_criteria' => $this->currentCriteria?->id_criteria],
                [
                    'id_project'  => $this->currentProject->id_project,
                    'id'          => $this->criteriaId,
                    'description' => $this->description,
                    'type'        => $this->type['value'],
                    'rule'        => $this->type['value'] === 'Inclusion'
                        ? $this->inclusion_rule['value']
                        : $this->exclusion_rule['value'],
                ]
            );

            Log::logActivity(
                action: $isEditing ? 'Updated the criteria' : 'Added a criteria',
                description: $updatedOrCreated->description,
                module: 1,
                projectId: $this->currentProject->id_project
            );

            $this->selectRule($updatedOrCreated->rule, $this->type['value']);
            $this->toast(message: $toastMessage, type: 'success');

            if ($resetEvaluations) {
                $this->resetPaperEvaluations();
            }

        } catch (\Exception $e) {
            $this->handleException($e);
        } finally {
            $this->resetFields();
        }
    }

    // -----------------------------------------------------------------------
    // Delete — exclusão de critério
    // -----------------------------------------------------------------------

    /**
     * Verifica se há avaliações vinculadas ao critério e abre
     * o modal de confirmação antes de excluir.
     *
     * @param string $criteriaId
     * @return void
     */
    public function confirmDelete(string $criteriaId)
    {
        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        $criteria  = CriteriaModel::findOrFail($criteriaId);
        $memberIds = MemberModel::where('id_project', $this->currentProject->id_project)
            ->pluck('id_members');

        $this->confirmingDeleteId     = $criteriaId; // salvo antes do dispatch
        $this->deletionHasEvaluations = EvaluationCriteriaModel::where('id_criteria', $criteria->id_criteria)
            ->whereIn('id_member', $memberIds)
            ->exists();

        $this->dispatch('openDeleteConfirm');
        // dispatch DEPOIS de setar o estado, garantindo que o JS leia o valor correto
    }

    /**
     * Executa a exclusão após confirmação do usuário.
     *
     * @param string $criteriaId
     * @return void
     */
    public function delete(string $criteriaId = null)
    {
        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        $id = $criteriaId ?? $this->confirmingDeleteId;

        if (!$id) {
            $this->toast(message: 'Criteria not found.', type: 'error');
            return;
        }

        try {
            $currentCriteria = CriteriaModel::findOrFail($id);
            $currentCriteria->delete();

            Log::logActivity(
                action: 'Deleted the criteria',
                description: $currentCriteria->description,
                module: 1,
                projectId: $this->currentProject->id_project
            );

            $this->toast(message: $this->translate('deleted'), type: 'success');
            $this->resetPaperEvaluations();
            $this->updateCriterias();

        } catch (\Exception $e) {
            $this->toast(message: $e->getMessage(), type: 'error');
        } finally {
            $this->resetFields();
        }
    }

    // -----------------------------------------------------------------------
    // Regras e pré-seleção
    // -----------------------------------------------------------------------

    /**
     * Alterna o status de pré-seleção de um critério e atualiza
     * automaticamente a regra correspondente.
     *
     * @param string $id
     * @param string $type
     * @return void
     */
    public function changePreSelected($id, $type)
    {
        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        $preselected = CriteriaModel::where('id_criteria', $id)->first()->pre_selected == 1 ? 0 : 1;
        CriteriaModel::where('id_criteria', $id)->update(['pre_selected' => $preselected]);

        $allCriterias    = CriteriaModel::where([
            'id_project' => $this->currentProject->id_project,
            'type'       => $type,
        ])->get();

        $preselecteds    = $allCriterias->where('pre_selected', 1)->count();
        $countCriterias  = $allCriterias->count();

        $ruleValue = match (true) {
            $preselecteds > 0 && $preselecteds < $countCriterias => 'AT_LEAST',
            $preselecteds == 0                                    => 'ANY',
            $preselecteds == $countCriterias                      => 'ALL',
            default                                               => 'ALL',
        };

        switch ($type) {
            case 'Inclusion':
                $this->inclusion_rule['value'] = $ruleValue;
                CriteriaModel::where([
                    'id_project' => $this->currentProject->id_project,
                    'type'       => 'Inclusion',
                ])->update(['rule' => $ruleValue]);
                break;
            case 'Exclusion':
                $this->exclusion_rule['value'] = $ruleValue;
                CriteriaModel::where([
                    'id_project' => $this->currentProject->id_project,
                    'type'       => 'Exclusion',
                ])->update(['rule' => $ruleValue]);
                break;
        }

        $this->updateCriterias();
    }

    /**
     * Define uma regra específica para um tipo de critério e atualiza
     * automaticamente o status de pré-seleção dos critérios conforme a regra.
     *
     * Nota: selectRule é chamado internamente após salvar um critério,
     * por isso não exige confirmação — o modal já foi exibido no submit/delete.
     *
     * @param string $rule
     * @param string $type
     * @return void
     */
    public function selectRule($rule, $type)
    {
        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            $this->inclusion_rule['value'] = CriteriaModel::where(
                'id_project', $this->currentProject->id_project
            )->where('type', 'Inclusion')->first()->rule ?? 'ALL';

            $this->exclusion_rule['value'] = CriteriaModel::where(
                'id_project', $this->currentProject->id_project
            )->where('type', 'Exclusion')->first()->rule ?? 'ANY';

            return;
        }

        $where = [
            'id_project' => $this->currentProject->id_project,
            'rule'       => $rule,
            'type'       => $type,
        ];

        CriteriaModel::where([
            'id_project' => $this->currentProject->id_project,
            'type'       => $type,
        ])->update(['rule' => $rule]);

        switch ($rule) {
            case 'ALL':
                CriteriaModel::where($where)->update(['pre_selected' => 1]);
                break;
            case 'ANY':
                CriteriaModel::where($where)->update(['pre_selected' => 0]);
                break;
            case 'AT_LEAST':
                $projectCriterias = CriteriaModel::where([
                    'id_project' => $this->currentProject->id_project,
                    'type'       => $type,
                ])->count();

                if ($projectCriterias === 0) {
                    $this->toast(
                        message: __('project/planning.criteria.livewire.toasts.no_criteria'),
                        type: 'error'
                    );
                    return;
                }

                $selectedCount = CriteriaModel::where([
                    'id_project'   => $this->currentProject->id_project,
                    'pre_selected' => 1,
                    'type'         => $type,
                    'rule'         => $rule,
                ])->count();

                if ($selectedCount === 0) {
                    CriteriaModel::where($where)->first()->update(['pre_selected' => 1]);
                }
                break;
        }

        $this->updateCriterias();
    }

    /**
     * Atualiza as regras de critérios de inclusão ou exclusão no banco de dados.
     *
     * @param string $type
     * @return void
     */
    public function updateCriteriaRule($type)
    {
        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        CriteriaModel::where([
            'id_project' => $this->currentProject->id_project,
            'type'       => 'Exclusion',
        ])->update(['rule' => $this->exclusion_rule['value']]);

        CriteriaModel::where([
            'id_project' => $this->currentProject->id_project,
            'type'       => 'Inclusion',
        ])->update(['rule' => $this->inclusion_rule['value']]);

        $this->toast(
            message: $this->translate($type === 'Inclusion' ? 'updated-inclusion' : 'updated-exclusion'),
            type: 'success'
        );

        $this->updateCriterias();
    }

    // -----------------------------------------------------------------------
    // Edição
    // -----------------------------------------------------------------------

    /**
     * Preenche os campos do formulário com os dados do critério para edição.
     *
     * @param string $criteriaId
     * @return void
     */
    public function edit(string $criteriaId)
    {
        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        $this->currentCriteria   = CriteriaModel::findOrFail($criteriaId);
        $this->criteriaId        = $this->currentCriteria->id;
        $this->description       = $this->currentCriteria->description;
        $this->type['value']     = $this->currentCriteria->type;
        $this->form['isEditing'] = true;
    }

    // -----------------------------------------------------------------------
    // Render
    // -----------------------------------------------------------------------

    /**
     * Renderiza o componente Livewire.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.planning.criteria.criteria')->extends('layouts.app');
    }
}
