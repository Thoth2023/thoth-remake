<?php

namespace App\Livewire\Planning;

use Livewire\Component;
use App\Models\Project;

class PublicProtocol extends Component
{
    public $project;
    public $showModal = false;
    public $activeTab = 'protocol';

    protected $listeners = ['showPublicProtocol'];

    public function mount(Project $project)
    {
        $this->project = $project;
    }

    public function showPublicProtocol()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        return view('livewire.planning.public-protocol', [
            'project' => $this->project,
        ]);
    }
}
