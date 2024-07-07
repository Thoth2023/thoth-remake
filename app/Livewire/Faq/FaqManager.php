<?php

namespace App\Livewire\Faq;

use Livewire\Component;
use App\Models\Faq;

class FaqManager extends Component
{
    public $faq = [];
    public $faqId;
    public $question;
    public $response;
    public $isEditMode = false;
    public $showCreateModal = false;

    public function mount()
    {
        $this->faq = $this->fetchFaq();
        $this->listeners = [
            'faqDeleted' => 'fetchFaq'
        ];
    }

    public function fetchFaq(){
        return Faq::all();
    }

    public function store()
    {
        $this->validate([
            'question' => 'required|string',
            'response' => 'required|string',
        ]);
    
        if ($this->faqId) {
            
            $faq = Faq::findOrFail($this->faqId);
            $faq->update([
                'question' => $this->question,
                'response' => $this->response
            ]);
        } else {
            Faq::create([
                'question' => $this->question,
                'response' => $this->response
            ]);
        }
        $this->resetForm();
        $this->faq = $this->fetchFaq();
        
        
    }

    public function delete($id)
    {
        Faq::find($id)->delete();
        $this->fetchFaq();
        $this->faq = $this->fetchFaq();
    }

    public function openCreateModal($id = null)
    {

        if ($id) {
            $this->faqId = $id;
            $faq = Faq::find($id);
            $this->question = $faq->question;
            $this->response = $faq->response;
        }

        $this->isEditMode = true;
    }

    public function closeCreateModal()
    {
        $this->isEditMode = false;
    }
    private function resetForm()
    {
        $this->faqId = null;
        $this->question = '';
        $this->response = '';
    }

    public function render()
    {
       return view('livewire.faq.faq-manager');
    }
}

?>