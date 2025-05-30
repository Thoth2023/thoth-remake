namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class SnowballingLookup extends Component
{
    public $doi;
    public $references = [];
    public $citations = [];

    public function search()
    {
        $doi = trim($this->doi);
        $apiUrl = "https://api.semanticscholar.org/graph/v1/paper/DOI:$doi";
        $fields = "title,references.title,references.authors,references.year,citations.title,citations.authors,citations.year";

        $response = Http::get($apiUrl, ['fields' => $fields]);

        if ($response->successful()) {
            $data = $response->json();
            $this->references = $data['references'] ?? [];
            $this->citations = $data['citations'] ?? [];
        } else {
            $this->addError('doi', 'Erro ao consultar API. Verifique o DOI.');
        }
    }

    public function render()
    {
        return view('livewire.snowballing-lookup');
    }
}
