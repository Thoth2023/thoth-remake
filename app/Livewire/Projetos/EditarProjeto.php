namespace App\Livewire;

use Livewire\Component;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class EditarProjeto extends Component
{
    public $project;
    public $title, $description, $objectives;
    public $has_peer_review, $has_reviewer, $is_public;

    public function mount(Project $project)
    {
        $this->project = $project;
        $this->title = $project->title;
        $this->description = $project->description;
        $this->objectives = $project->objectives;
        $this->has_peer_review = $project->has_peer_review;
        $this->has_reviewer = $project->has_reviewer;
        $this->is_public = $project->is_public;
    }

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'objectives' => 'nullable|string',
        'has_peer_review' => 'boolean',
        'has_reviewer' => 'boolean',
        'is_public' => 'boolean',
    ];

    public function update()
    {
        $this->validate();

        $this->project->update([
            'title' => $this->title,
            'description' => $this->description,
            'objectives' => $this->objectives,
            'has_peer_review' => $this->has_peer_review,
            'has_reviewer' => $this->has_reviewer,
            'is_public' => $this->is_public,
        ]);

        session()->flash('success', 'Projeto atualizado com sucesso!');
        return redirect()->route('projects.index');
    }

    public function render()
    {
        return view('livewire.editar-projeto');
    }
}
