<?php

namespace App\Models\Project\Conducting\QualityAssessment;

use App\Models\Member;
use App\Models\Paper;
use App\Models\StatusQualityAssessment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PapersQA extends Model
{
    use HasFactory;

    // Nome da tabela associada a este modelo
    protected $table = 'papers_qa';

    // Nome da chave primária
    protected $primaryKey = 'id_paper_qa';

    // A chave primária é auto-incrementada
    public $incrementing = true;

    // Tipo da chave primária
    protected $keyType = 'integer';

    // Desabilitando timestamps automáticos (created_at, updated_at)
    public $timestamps = false;

    // Definindo os campos que podem ser atribuídos em massa
    protected $fillable = [
        'id_paper',
        'id_member',
        'id_gen_score',
        'id_status',
        'note',
        'score',
    ];

    // Definindo os relacionamentos, se aplicável
    public function paper()
    {
        return $this->belongsTo(Paper::class, 'id_paper');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'id_member');
    }

    public function generalScore()
    {
        return $this->belongsTo(GeneralScore::class, 'id_gen_score');
    }

    public function status_qa()
    {
        return $this->belongsTo(StatusQualityAssessment::class, 'id_status');
    }



}
