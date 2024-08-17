<?php

namespace App\Livewire\Planning\SearchStrategy;

use Livewire\Component;
use App\Models\Project as ProjectModel;
use App\Models\SearchStrategy as SearchStrategyModel;
use App\Utils\ActivityLogHelper as Log;
use App\Utils\ToastHelper;

class Strategy extends Component
{
    public $projectId;
    public $searchStrategy;
    public $currentDescription;


    protected $rules = [
        'currentDescription' => 'required|string',
    ];

    public function mount()
    {
        $projectId = request()->segment(2);
        $this->projectId = $projectId;
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
        $this->validate();

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

    public function render()
    {
        return view('livewire.planning.search-strategy.strategy');
    }
}
