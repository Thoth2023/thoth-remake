<?php

namespace App\Models\Project\Planning\QualityAssessment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Project;

class Question extends Model
{
    protected $table = 'question_quality';
    protected $primaryKey = 'id_qa';
    public $timestamps = false;

    use HasFactory;

    protected $fillable = [
        'id',
        'description',
        'weight',
        'min_to_app',
        'id_project',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'id_project');
    }

    public function qualityScores()
    {
        return $this->hasMany(QualityScore::class, 'id_qa');
    }
    public function getMinScoreValueAttribute()
    {
        return $this->qualityScores->firstWhere('id_score', $this->min_to_app)?->score;
    }
}
