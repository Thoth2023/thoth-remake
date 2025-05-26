<?php

namespace App\Livewire\Planning\SearchStrategy;

use Livewire\Component;
use App\Models\Project as ProjectModel;
use App\Models\SearchStrategy as SearchStrategyModel;
use App\Utils\ActivityLogHelper as Log;
use App\Utils\ToastHelper;
use App\Traits\ProjectPermissions;

class Strategy extends Component
{
    use ProjectPermissions;

    public $projectId;
    public $currentProject;
    public $searchStrategy;
    public $currentDescription;

    private $toastMessages = 'project/planning.search-strategy';


    protected $rules = [
        'currentDescription' => [
            'required',
            'string',
        ],
    ];
    
    protected $messages = [
        'currentDescription.required' => 'O campo descrição é obrigatório.',
        'currentDescription.regex' => 'A descrição deve conter pelo menos uma letra e não pode conter apenas caracteres especiais ou números.',
    ];

    public function mount()
    {
        $projectId = request()->segment(2);
        $this->projectId = $projectId;
        $this->currentProject = ProjectModel::findOrFail($this->projectId);
        $this->searchStrategy = SearchStrategyModel::where('id_project', $this->projectId)->firstOrNew([]);
        $this->currentDescription = $this->searchStrategy->description;
    }

    /**
     * Dispatch a toast message to the view.
     */
    public function toast(string $message, string $type)
    {
        $this->dispatch('search-strategy', ToastHelper::dispatch($type, $message));
    }

    public function submit()
    {
        $this->validate([
            'currentDescription' => 'required|string',
        ]);

        if (!$this->isValidDescription($this->currentDescription)) {
            $this->addError('currentDescription', 'A descrição deve conter pelo menos uma letra e não pode conter apenas caracteres especiais ou números.');
            return;
        }

        try {
            $project = ProjectModel::findOrFail($this->projectId);
            $project->searchStrategy()
                ->updateOrCreate([], ['description' => $this->currentDescription]);

            Log::logActivity(
                action: 'Updated the search strategy',
                description: $this->currentDescription,
                projectId: $this->projectId
            );

            $this->toast(
                message: __('project/planning.search-strategy.success'),
                type: 'success'
            );
        } catch (\Exception $e) {
            $this->toast(
                message: $e->getMessage(),
                type: 'error'
            );
        }
    }

    private function isValidDescription(string $description): bool
    {
        $trimmedDescription = trim($description);

        // Verifica se contém pelo menos uma letra
        if (!preg_match('/[a-zA-ZÀ-ÿ]/', $trimmedDescription)) {
            return false;
        }

        // Verifica se é composta apenas por números e/ou caracteres especiais
        if (preg_match('/^[\d\W]+$/', $trimmedDescription)) {
            return false;
        }
    
        return true;
    }

    public function render()
    {
        return view('livewire.planning.search-strategy.strategy');
    }
}
