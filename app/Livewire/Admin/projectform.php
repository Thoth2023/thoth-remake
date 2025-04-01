namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Projeto;

class ProjectForm extends Component
{
    public $projeto_id;
    public $titulo = '';
    public $descricao = '';
    public $avaliacao_pares = false;
    public $revisor = false;
    public $publico = false;
    public $descricao = '';


    public function mount($projeto = null)
    {
        if ($projeto) {
            $this->projeto_id = $projeto->id;
            $this->titulo = $projeto->titulo;
            $this->descricao = $projeto->descricao;
            $this->avaliacao_pares = $projeto->avaliacao_pares;
            $this->revisor = $projeto->revisor;
            $this->publico = $projeto->publico;
        }
    }

    public function save()
    {
        $this->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
        ]);

        Projeto::updateOrCreate(
            ['id' => $this->projeto_id],
            [
                'titulo' => $this->titulo,
                'descricao' => $this->descricao,
                'avaliacao_pares' => $this->avaliacao_pares,
                'revisor' => $this->revisor,
                'publico' => $this->publico,
            ]
        );

        session()->flash('message', 'Projeto salvo com sucesso!');
    }

    public function render()
    {
        return view('livewire.admin.project-form');
    }
}
