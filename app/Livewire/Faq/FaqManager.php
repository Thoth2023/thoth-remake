<?php
namespace App\Livewire\Faq;

use Livewire\Component;
use App\Models\Faq;
use App\Models\PageVersion;
use App\Models\FaqHistory; 

class FaqManager extends Component
{
    public $faq = [];
    public $faqId;
    public $question;
    public $response;
    public $isEditMode = false;
    public $showCreateModal = false;
    public $showHistoryModal = false;
    public $showFullText = []; 
    public $pageVersions = [];

    protected $listeners = [
        'restoreVersion' => 'restoreVersion',
        'deleteVersion' => 'deleteVersion',
    ];

    public function mount()
    {
        $this->faq = $this->fetchFaq();
        $this->pageVersions = $this->fetchPageVersions();
    }
    
    public function fetchFaq()
    {
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
                'response' => $this->response,
            ]);
        } else {
           
            Faq::create([
                'question' => $this->question,
                'response' => $this->response,
            ]);
        }

        $this->resetForm();
        $this->faq = $this->fetchFaq();
    }

    public function delete($id)
    {
        $faq = Faq::find($id);

        if ($faq) {
            FaqHistory::create([
                'faq_id' => $faq->id,
                'question' => $faq->question,
                'response' => $faq->response,
            ]);

            $faq->delete();
        }

        $this->faq = $this->fetchFaq();
    }

    public function openHistoryModal()
    {
        $this->showHistoryModal = true;
    }

    public function closeHistoryModal()
    {
        $this->showHistoryModal = false;
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
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->faqId = null;
        $this->question = '';
        $this->response = '';
    }

    public function fetchPageVersions()
    {
       
        return PageVersion::where('page_id', 'faq')->orderByDesc('created_at')->get();
    }
    
    public function restoreVersion($versionId)
    {
        $faqHistory = FaqHistory::withTrashed()->find($versionId);
    
        
        $faqExists = Faq::where('question', $faqHistory->question)
                        ->where('response', $faqHistory->response)
                        ->exists();
    
        if (!$faqExists) {
          
            Faq::create([
                'question' => $faqHistory->question,
                'response' => $faqHistory->response,
            ]);
    
            $faqHistory->restore();
    
            $this->faq = $this->fetchFaq();
        }   
    }

    public function deleteVersion($versionId)
    {
        $faqHistory = FaqHistory::find($versionId);

        if ($faqHistory) {
            $faqHistory->delete();
            
            $this->faqHistories = FaqHistory::orderBy('created_at', 'desc')->get();
        }
    }

   
    public function toggleFullText($faqId)
    {
        if (isset($this->showFullText[$faqId])) {
            $this->showFullText[$faqId] = !$this->showFullText[$faqId];
        } else {
            $this->showFullText[$faqId] = true;
        }
    }

    public function render()
    {
        return view('livewire.faq.faq-manager', [
            'faqHistories' => FaqHistory::orderBy('created_at', 'desc')->get()
        ]);
    }
}
