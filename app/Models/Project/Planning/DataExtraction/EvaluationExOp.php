<?php

namespace App\Models\Project\Planning\DataExtraction;
use App\Models\Paper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationExOp extends Model
{
    use HasFactory;

    // Definir o nome da tabela
    protected $table = 'evaluation_ex_op';

    // Definir a chave primária
    protected $primaryKey = 'ev_ex_op';

    // Definir se a chave primária não é auto-incrementada (caso utilize outro tipo de chave)
    public $incrementing = true;

    // Desativar timestamps se não existir no banco de dados
    public $timestamps = false;

    // Definir os campos que podem ser preenchidos em massa
    protected $fillable = ['id_paper', 'id_qe', 'id_option'];

    // Relacionamento com o modelo de Paper (caso haja um modelo para os papers)
    public function paper()
    {
        return $this->belongsTo(Paper::class, 'id_paper');
    }

    // Relacionamento com a questão (question_extraction)
    public function question()
    {
        return $this->belongsTo(Question::class, 'id_qe');
    }

    // Relacionamento com a opção (options_extraction)
    public function option()
    {
        return $this->belongsTo(Option::class, 'id_option');
    }
}
