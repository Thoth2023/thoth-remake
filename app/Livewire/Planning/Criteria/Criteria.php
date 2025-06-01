<?php

namespace App\Livewire\Planning\Criteria;

use Illuminate\Validation\Rule;
use Livewire\Component;
use App\Models\Project as ProjectModel;
use App\Models\Criteria as CriteriaModel;
use App\Utils\ActivityLogHelper as Log;
use App\Utils\ToastHelper;

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

    /**
     * Define as regras de validação para os campos do formulário.
     * 
     * @return array Array contendo as regras de validação
     */
    protected function rules()
    {
        return [
            'currentProject' => 'required',
            'criteriaId' => 'required|string|max:20|regex:/^[a-zA-Z0-9]+$/',
            'description' => 'required|string|max:255',
            'type' => 'required|array',
            'type.*.value' => 'string'
        ];
    }

    /**
     * Define mensagens personalizadas para as regras de validação.
     * 
     * @return array Array contendo as mensagens de erro personalizadas
     */
    protected function messages()
    {
        $tpath = 'project/planning.criteria.livewire';

        return [
            'description.required' => __($tpath . '.description.required'),
            'criteriaId.required' => __($tpath . '.criteriaId.required'),
            'criteriaId.regex' => __($tpath . '.criteriaId.regex'),
            'type.required' => __($tpath . '.type.required'),
        ];
    }

    /**
     * Inicializa o componente quando é montado.
     * 
     * Recupera o projeto atual da URL, carrega todos os critérios associados
     * e define os valores padrão para as regras de inclusão e exclusão.
     * 
     * @return void
     */
    public function mount()
    {
        $projectId = request()->segment(2);
        $this->currentProject = ProjectModel::findOrFail($projectId);
        $this->currentCriteria = null;
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
    }

    /**
     * Reseta todos os campos do formulário para seus valores padrão.
     * 
     * @return void
     */
    public function resetFields()
    {
        $this->criteriaId = '';
        $this->description = '';
        $this->type['value'] = null;
        $this->currentCriteria = null;
        $this->form['isEditing'] = false;
    }

    /**
     * Alterna o status de pré-seleção de um critério e atualiza automaticamente
     * as regras correspondentes baseado na quantidade de critérios selecionados.
     * 
     * @param string $id ID do critério a ser alternado
     * @param string $type Tipo do critério (Inclusion/Exclusion)
     * @return void
     */
    public function changePreSelected($id, $type)
    {
        $preselected = CriteriaModel::where('id_criteria', $id)->first()->pre_selected == 1 ? 0 : 1;
        CriteriaModel::where('id_criteria', $id)->update(['pre_selected' => $preselected]);

        $allCriterias = CriteriaModel::where([
            'id_project' => $this->currentProject->id_project,
            'type' => $type,
        ])->get();

        $preselecteds = $allCriterias->where('pre_selected', 1)->count();
        $countCriterias = $allCriterias->count();

        $ruleValue = match (true) {
            $preselecteds > 0 && $preselecteds < $countCriterias => 'AT_LEAST',
            $preselecteds == 0 => 'ANY',
            $preselecteds == $countCriterias => 'ALL',
            default => 'ALL'
        };

        switch ($type) {
            case 'Inclusion':
                $this->inclusion_rule['value'] = $ruleValue;
                CriteriaModel::where([
                    'id_project' => $this->currentProject->id_project,
                    'type' => 'Inclusion'
                ])->update(['rule' => $this->inclusion_rule['value']]);
                break;
            case 'Exclusion':
                $this->exclusion_rule['value'] = $ruleValue;
                CriteriaModel::where([
                    'id_project' => $this->currentProject->id_project,
                    'type' => 'Exclusion'
                ])->update(['rule' => $this->exclusion_rule['value']]);
                break;
        }

        $this->updateCriterias();
    }

    /**
     * Define uma regra específica para um tipo de critério e atualiza
     * automaticamente o status de pré-seleção dos critérios conforme a regra.
     * 
     * @param string $rule Regra a ser aplicada (ALL, ANY, AT_LEAST)
     * @param string $type Tipo do critério (Inclusion/Exclusion)
     * @return void
     */
    public function selectRule($rule, $type)
    {
        $where = [
            'id_project' => $this->currentProject->id_project,
            'rule' => $rule,
            'type' => $type,
        ];

        CriteriaModel::where([
            'id_project' => $this->currentProject->id_project,
            'type' => $type,
        ])->update(['rule' => $rule]);

        switch ($rule) {
            case 'ALL':
                CriteriaModel::where($where)->update(['pre_selected' => 1]);
                break;
            case 'ANY':
                CriteriaModel::where($where)->update(['pre_selected' => 0]);
                break;
            case 'AT_LEAST':
                $selectedCount = CriteriaModel::where([
                    'id_project' => $this->currentProject->id_project,
                    'pre_selected' => 1,
                    'type' => $type,
                    'rule' => $rule,
                ])->count();

                if ($selectedCount === 0) {
                    CriteriaModel::where($where)
                        ->first()->update(['pre_selected' => 1]);
                }
                break;
        }
        $this->updateCriterias();
    }

    /**
     * Atualiza a lista de critérios e as regras de inclusão/exclusão
     * a partir do banco de dados.
     * 
     * @return void
     */
    public function updateCriterias()
    {
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
            $this->currentProject->id_project,
        )->where('type', 'Exclusion')->first()->rule ?? 'ANY';
    }

    /**
     * Envia uma mensagem toast para a view.
     * 
     * @param string $message Mensagem a ser exibida
     * @param string $type Tipo da mensagem (success, error, info, warning)
     * @return void
     */
    public function toast(string $message, string $type)
    {
        $this->dispatch('criteria', ToastHelper::dispatch($type, $message));
    }

    /**
     * Traduz mensagens baseado na chave fornecida.
     * 
     * @param string $key Chave da tradução
     * @return string Mensagem traduzida
     */
    public function translate($key)
    {
        return __($this->toastMessages . '.' . $key);
    }

    /**
     * Processa o envio do formulário, validando os dados e criando
     * ou atualizando um critério.
     * 
     * Realiza validações personalizadas, verifica duplicidade de IDs,
     * salva o critério no banco de dados e registra a atividade no log.
     * 
     * @return void
     */
    public function submit()
    {
        $this->validate();

        if (strcmp($this->type['value'], 'NONE') === 0) {
            $this->toast(
                message: $this->translate('type.required'),
                type: 'info'
            );
            return;
        }

        $updateIf = [
            'id_criteria' => $this->currentCriteria?->id_criteria,
        ];

        try {
            $value = $this->form['isEditing'] ? 'Updated the criteria' : 'Added a criteria';

            $toastMessage = $this->translate($this->form['isEditing'] ? 'updated' : 'added');

            if (!$this->form['isEditing'] && $this->currentProject->criterias->contains('id', $this->criteriaId)) {
                $this->toast(
                    message: $this->translate('unique-id'),
                    type: 'error'
                );
                return;
            }

            if (
                $this->form['isEditing']
                && $this->currentCriteria->id != $this->criteriaId
                && $this->currentProject->criterias->contains('id', $this->criteriaId)
            ) {
                $this->toast(
                    message: $this->translate('unique-id'),
                    type: 'error'
                );
                return;
            }

            $updatedOrCreated = CriteriaModel::updateOrCreate($updateIf, [
                'id_project' => $this->currentProject->id_project,
                'id' => $this->criteriaId,
                'description' => $this->description,
                'type' => $this->type['value'],
                'rule' => $this->type['value'] == 'Inclusion' ?
                    $this->inclusion_rule['value'] : $this->exclusion_rule['value'],
            ]);

            Log::logActivity(
                action: $value,
                description: $updatedOrCreated->description,
                projectId: $this->currentProject->id_project
            );

            $this->selectRule($updatedOrCreated->rule, $this->type['value']);
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
     * Preenche os campos do formulário com os dados do critério
     * especificado para edição.
     * 
     * @param string $criteriaId ID do critério a ser editado
     * @return void
     */
    public function edit(string $criteriaId)
    {
        $this->currentCriteria = CriteriaModel::findOrFail($criteriaId);
        $this->criteriaId = $this->currentCriteria->id;
        $this->description = $this->currentCriteria->description;
        $this->type['value'] = $this->currentCriteria->type;
        $this->form['isEditing'] = true;
    }

    /**
     * Exclui um critério do banco de dados.
     * 
     * Remove o critério especificado, registra a atividade no log
     * e atualiza a lista de critérios.
     * 
     * @param string $criteriaId ID do critério a ser excluído
     * @return void
     */
    public function delete(string $criteriaId)
    {
        try {
            $currentCriteria = CriteriaModel::findOrFail($criteriaId);
            $currentCriteria->delete();
            Log::logActivity(
                action: 'Deleted the criteria',
                description: $currentCriteria->description,
                projectId: $this->currentProject->id_project
            );

            $this->toast(
                message: $this->translate('deleted'),
                type: 'success'
            );
            $this->updateCriterias();
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
     * Atualiza as regras de critérios de inclusão ou exclusão no banco de dados.
     * 
     * @param string $type Tipo do critério para determinar a mensagem de sucesso
     * @return void
     */
    public function updateCriteriaRule($type)
    {
        $this->exclusion_rule['value'] = CriteriaModel::where([
            'id_project' => $this->currentProject->id_project,
            'type' => 'Exclusion'
        ])->update(['rule' => $this->exclusion_rule['value']]);

        $this->inclusion_rule['value'] = CriteriaModel::where([
            'id_project' => $this->currentProject->id_project,
            'type' => 'Inclusion'
        ])->update(['rule' => $this->inclusion_rule['value']]);

        if ($type == 'Inclusion') {
            $this->toast(
                message: $this->translate('updated-inclusion'),
                type: 'success'
            );
        }

        if ($type == 'Exclusion') {
            $this->toast(
                message: $this->translate('updated-exclusion'),
                type: 'success'
            );
        }

        $this->updateCriterias();
    }

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
