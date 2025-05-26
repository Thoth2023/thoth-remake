namespace App\Livewire\Projetos;

use Livewire\Component;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class CriarProjeto extends Component
{
    public $title, $description, $objectives;
    public $has_peer_review = false;
    public $has_reviewer = false;
    public $is_public = false;
    public $projects;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'objectives' => 'nullable|string',
        'has_peer_review' => 'boolean',
        'has_reviewer' => 'boolean',
        'is_public' => 'boolean',
    ];

    public function mount()
    {
        $this->projects = Auth::user()->projects;
    }

    public function save()
    {
        $this->validate();

        $user = Auth::user();
        $project = Project::create([
            'id_user' => $user->id,
            'title' => $this->title,
            'description' => $this->description,
            'objectives' => $this->objectives,
            'created_by' => $user->username,
            'has_peer_review' => $this->has_peer_review,
            'has_reviewer' => $this->has_reviewer,
            'is_public' => $this->is_public,
        ]);

        $project->users()->attach($user->id, [
            'level' => 1,
        ]);

        session()->flash('success', 'Projeto criado com sucesso!');
        return redirect()->route('projects.index');
    }

    public function render()
    {
        return view('livewire.projetos.criar-projeto');
    }
}
