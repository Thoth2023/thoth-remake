<?php



namespace App\Http\Livewire\Faq;

use Livewire\Component;
use App\Models\Faq; 
use App\Models\PageVersion;

class FaqManagerComponent extends Component
{
    public $faq = [];
    public $faqId;
    public $question;
    public $response;
    public $isEditMode = false;
    public $showCreateModal = false;
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
            // Update existing FAQ
            $faq = Faq::findOrFail($this->faqId);
            $faq->update([
                'question' => $this->question,
                'response' => $this->response,
            ]);
        } else {
            // Create new FAQ
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
        Faq::find($id)->delete();
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
        // Fetch all page versions (could be filtered by 'faq' page_id if needed)
        return PageVersion::where('page_id', 'faq')->orderByDesc('created_at')->get();
    }

    public function restoreVersion($versionId)
    {
        $version = PageVersion::find($versionId);
        if ($version) {
            // Create or update FAQ based on version data
            $faq = Faq::findOrNew($version->page_id);
            $faq->question = $version->title;
            $faq->response = $version->content;
            $faq->save();
            
            // Optionally, delete the version after restoration
            $version->delete();

            // Refresh data
            $this->faq = $this->fetchFaq();
            $this->pageVersions = $this->fetchPageVersions();
        }
    }

    public function deleteVersion($versionId)
    {
        $version = PageVersion::find($versionId);
        if ($version) {
            $version->delete();
            // Refresh data
            $this->pageVersions = $this->fetchPageVersions();
        }
    }

    public function render()
    {
        return view('livewire.faq.faq-manager-component');
    }
}

