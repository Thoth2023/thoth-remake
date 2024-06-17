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

    public function mount()
    {
        $this->faq = $this->fetchFaq();

    }

    public function fetchFaq(){
        return Faq::all();
    }
    public function editFaq($id)
    {
        $faq = Faq::findOrFail($id);
        $this->faqId = $faq->id;
        $this->question = $faq->question;
        $this->response = $faq->response;
    }

    public function updateFaq()
    {
        $this->validate([
            'question' => 'required|string',
            'response' => 'required|string',
        ]);

        if ($this->faqId) {
            $faq = Faq::find($this->faqId);
            $faq->update([
                'question' => $this->question,
                'response' => $this->response,
            ]);
        }

        $this->fetchFaq();
    }

    public function deleteFaq($id)
    {
        Faq::find($id)->delete();
        $this->fetchFaq();
    }

    public function render()//['faqs' => $this->faqs]
    {
       return view('livewire.faq.faq-manager',);
    }
}

?>