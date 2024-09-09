<?php

namespace App\Models\Project\Conducting\DataExtraction;

use App\Models\Project\Conducting\Papers;
use App\Models\Project\Planning\DataExtraction\Question;
use Illuminate\Database\Eloquent\Model;

class EvaluationExTxt extends Model
{
    // Defina o nome da tabela
    protected $table = 'evaluation_ex_txt';

    // Defina a chave primária, que não segue a convenção padrão (id)
    protected $primaryKey = 'id_ev_txt';

    // Desativar auto-incremento se não for padrão no banco de dados
    public $incrementing = true;

    // Defina o tipo da chave primária, se necessário
    protected $keyType = 'int';

    // Definir timestamps como false, já que não existem no migration
    public $timestamps = false;

    // Defina os campos que podem ser preenchidos (mass assignable)
    protected $fillable = ['id_paper', 'id_qe', 'text'];

    // Relacionamento com outros modelos (se necessário)
    public function paper()
    {
        return $this->belongsTo(Papers::class, 'id_paper');
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'id_qe');
    }
}
