<?php

namespace App\Livewire\Planning\Overall;

use App\Utils\ToastHelper;
use Livewire\Component;
use App\Models\Project as ProjectModel;
use App\Utils\ActivityLogHelper as Log;
use App\Traits\ProjectPermissions;

/**
 * Componente Livewire responsável pelo gerenciamento das datas de início e fim
 * de um projeto de revisão sistemática da literatura.
 * 
 * Este componente faz parte da fase de planejamento geral da revisão sistemática,
 * permitindo que os pesquisadores definam o cronograma temporal do projeto.
 * As datas são fundamentais para o controle e acompanhamento do progresso
 * da revisão bibliográfica.
 */
class Dates extends Component
{
    use ProjectPermissions;
    
    /**
     * Caminho base para as traduções específicas deste componente.
     * Utilizado para internacionalização (PT/BR e EN).
     * 
     * @var string
     */
    private $translationPath = 'project/planning.overall.dates.livewire';
    
    /**
     * Caminho para as mensagens de toast específicas deste componente.
     * Utilizado para feedback visual ao usuário após operações.
     * 
     * @var string
     */
    private $toastMessages = 'project/planning.overall.dates.livewire.toasts';

    /**
     * Instância do projeto atual sendo editado.
     * Contém todos os dados do projeto de revisão sistemática.
     * 
     * @var ProjectModel
     */
    public $currentProject;

    /**
     * Fields to be filled by the form.
     */
    
    /**
     * Data de início do projeto de revisão sistemática.
     * Define quando o projeto começou ou deve começar.
     * 
     * @var string|null
     */
    public $startDate;
    
    /**
     * Data de fim do projeto de revisão sistemática.
     * Define quando o projeto terminou ou deve terminar.
     * Deve ser posterior à data de início.
     * 
     * @var string|null
     */
    public $endDate;

    /**
     * Validation rules.
     */
    protected $rules = [
        'currentProject' => 'required',
        'startDate' => 'required|date',
        'endDate' => 'required|date|after:startDate',
    ];

    /**
     * Custom error messages for the validation rules.
     */
    protected function messages()
    {
        return [
            'startDate.required' => __($this->translationPath . '.start_date.required'),
            'startDate.date' => __($this->translationPath . '.date.invalid'),
            'endDate.date' => __($this->translationPath . '.date.invalid'),
            'endDate.required' => __($this->translationPath . '.end_date.required'),
            'endDate.after' => __($this->translationPath . '.end_date.after'),
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
        
        // Pré-popula os campos com as datas existentes do projeto
        $this->startDate = $this->currentProject->start_date;
        $this->endDate = $this->currentProject->end_date;
    }

    /**
     * Dispatch a toast message to the view.
     */
    public function toast(string $message, string $type)
    {
        $this->dispatch('dates', ToastHelper::dispatch($type, $message));
    }

    /**
     * Submit the form. It also validates the input fields.
     */
    public function submit()
    {

        if (!$this->checkEditPermission($this->toastMessages . '.denied')) {
            return;
        }

        // Valida os dados do formulário conforme as regras definidas
        $this->validate();

        // Verifica se já existem datas cadastradas para determinar se é criação ou atualização
        $dates = ProjectModel::first(['start_date', 'end_date'])
            ->where('id_project', $this->currentProject->id);

        // Atualiza as datas do projeto utilizando o método específico do modelo
        $this->currentProject->addDate(
            startDate: $this->startDate,
            endDate: $this->endDate
        );

        // Registra a atividade no log do sistema para auditoria
        // Diferencia entre adição e atualização de datas
        Log::logActivity(
            action: $dates === null ? 'Added project dates: ' : 'Updated project dates: ',
            description: $this->startDate . ' - ' . $this->endDate,
            projectId: $this->currentProject->id_project,
        );

        // Exibe mensagem de sucesso para o usuário
        $this->toast(
            message: __($this->toastMessages . '.updated'),
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
            'livewire.planning.overall.dates',
            compact(
                'project',
            )
        )->extends('layouts.app');
    }
}
