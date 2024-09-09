<?php

namespace App\Models\Project\Conducting\DataExtraction;

use App\Models\Project\Conducting\Papers;
use App\Models\Project\Planning\DataExtraction\Option;
use App\Models\Project\Planning\DataExtraction\Question;
use Illuminate\Database\Eloquent\Model;

class EvaluationExOp extends Model
{
    // Defina o nome da tabela
    protected $table = 'evaluation_ex_op';

    // Defina a chave primária
    protected $primaryKey = 'ev_ex_op';

    // Desativar auto-incremento se não for padrão no banco de dados
    public $incrementing = true;

    // Defina o tipo da chave primária, se necessário
    protected $keyType = 'int';

    // Desativar timestamps já que a tabela não possui campos de timestamp
    public $timestamps = false;

    // Definir os campos que podem ser preenchidos
    protected $fillable = ['id_paper', 'id_qe', 'id_option'];

    // Relacionamento com outros modelos (se necessário)
    public function paper()
    {
        return $this->belongsTo(Papers::class, 'id_paper');
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'id_qe');
    }

    public function option()
    {
        return $this->belongsTo(Option::class, 'id_option');
    }
}
