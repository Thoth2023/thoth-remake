<?php

namespace App\Models\Project\Conducting\StudySelection;
use App\Models\Member;
use App\Models\Project\Conducting\Papers;
use App\Models\StatusSelection;
use Illuminate\Database\Eloquent\Model;

class PapersSelection extends Model
{
    // Define o nome da tabela explicitamente, já que o padrão seria 'papers_selections'
    protected $table = 'papers_selection';

    // Desabilitar timestamps se a tabela não tiver created_at e updated_at
    public $timestamps = false;

    // Define a chave primária da tabela
    protected $primaryKey = 'id_paper_sel';

    // Define os atributos que podem ser preenchidos em massa
    protected $fillable = [
        'id_member',
        'id_paper',
        'id_status',
        'note',
    ];

    /**
     * Relacionamento com o model Member (Usuário).
     */
    public function member()
    {
        return $this->belongsTo(Member::class, 'id_member', 'id_members');
    }

    /**
     * Relacionamento com o model Papers.
     */
    public function paper()
    {
        return $this->belongsTo(Papers::class, 'id_paper', 'id_paper');
    }

    /**
     * Relacionamento com o model StatusSelection.
     */
    public function status()
    {
        return $this->belongsTo(StatusSelection::class, 'id_status', 'id_status');
    }
}
