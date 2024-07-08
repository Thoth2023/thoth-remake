namespace App\Http\Livewire;

use App\Models\Paper;
use Livewire\Component;

class StudyEvaluation extends Component
{
    public $paper;
    public $criteria_inclusion;
    public $criteria_exclusion;
    public $notes;

    public function mount($paper)
    {
        $this->paper = $paper;
        $this->criteria_inclusion = $paper->criteria_inclusion;
        $this->criteria_exclusion = $paper->criteria_exclusion;
        $this->notes = $paper->notes;
    }

    public function save()
    {
        $this->paper->criteria_inclusion = $this->criteria_inclusion;
        $this->paper->criteria_exclusion = $this->criteria_exclusion;
        $this->paper->notes = $this->notes;
        $this->paper->save();

        session()->flash('message', 'Avaliação salva com sucesso.');
    }

    public function render()
    {
        return view('livewire.study-evaluation');
    }
}
