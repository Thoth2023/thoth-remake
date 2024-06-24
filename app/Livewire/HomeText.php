<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\HomeManager;

class HomeText extends Component
{
    public $homeObjs;
    public $title;
    public $description;
    public $icon;
    public $textId;
    public $showEditModal = false;
    public $isEditMode = false;

    public function mount()
    {
        $this->homeObjs = $this->fetchHomeManager();
    }

    public function fetchHomeManager(){
        return HomeManager::all();
    }

    public function store()
    {
        $this->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'icon' => 'required|string'
        ]);
    
        if ($this->textId) {
            
            $homeObjs = HomeManager::findOrFail($this->textId);
            $homeObjs->update([
                'title' => $this->title,
                'description' => $this->description,
                'icon'=>$this->icon
            ]);
        } else {
            HomeManager::create([
                'title' => $this->title,
                'description' => $this->description,
                'icon'=>$this->icon
            ]);
        }
        $this->resetForm();
        $this->homeObjs = $this->fetchHomeManager();
        
    }

    public function delete($id)
    {
        HomeManager::find($id)->delete();
        $this->homeObjs = $this->fetchHomeManager();
    }

    public function openCreateModal()
    {
        $this->isEditMode = false;
        $this->showEditModal = true;
        $this->resetForm();
    }
    public function openEditModal($id)
    {
        $this->resetForm();
        $this->isEditMode = true;

        $this->textId = $id;
        $item = HomeManager::findOrFail($id);
        $this->title = $item->title;
        $this->description = $item->description;
        $this->icon = $item->icon;
        
        $this->showEditModal = true;
        
    }

    public function closeCreateModal()
    {
        $this->showEditModal = false;
    }
    private function resetForm()
    {
        $this->textId = null;
        $this->title = '';
        $this->description = '';
        $this->icon = '';
    }


    public function render()
    {
        return view('livewire.home-text');
    }
}
