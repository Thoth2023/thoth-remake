<?php

namespace App\Models\Project\Planning\QualityAssessment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Project\Planning\QualityAssessment\Question as QuestionsModel;

class QualityScore extends Model
{
    protected $table = 'score_quality';
    protected $primaryKey = 'id_score';
    public $timestamps = false;

    use HasFactory;

    protected $fillable = [
        'score_rule',
        'description',
        'score',
        'id_qa',
    ];

    public function question()
    {
        return $this->belongsTo(QuestionsModel::class, 'id_qa');
    }
}

