<?php

namespace App\Models;

use App\Models\Project\Conducting\Papers;
use App\Models\Project\Planning\QualityAssessment\QualityScore;
use App\Models\Project\Planning\QualityAssessment\Question;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationQa extends Model
{
    use HasFactory;

    // Nome da tabela associada a este modelo
    protected $table = 'evaluation_qa';

    // Definindo a chave primária
    protected $primaryKey = 'id_ev_qa';

    // Se a chave primária não for auto-incrementada (como integer), defina a propriedade $incrementing como false.
    public $incrementing = true;

    // Definindo o tipo da chave primária, se for diferente do padrão (integer)
    protected $keyType = 'integer';

    // Desabilitando os timestamps automáticos (created_at, updated_at)
    public $timestamps = false;

    // Definindo os campos que podem ser atribuídos em massa
    protected $fillable = [
        'id_qa',
        'id_member',
        'id_score_qa',
        'score_partial',
        'id_paper',
    ];

    // Definindo as relações, se aplicável
    public function question()
    {
        return $this->belongsTo(Question::class, 'id_qa');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'id_member');
    }

    public function score()
    {
        return $this->belongsTo(QualityScore::class, 'id_score_qa');
    }

    public function paper()
    {
        return $this->belongsTo(Papers::class, 'id_paper');
    }
    public function scoresForQuestion()
    {
        return $this->question->hasMany(QualityScore::class, 'id_qa', 'id_qa');
    }
}
