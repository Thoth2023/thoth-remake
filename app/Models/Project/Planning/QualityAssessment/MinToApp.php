<?php

namespace App\Models\Project\Planning\QualityAssessment;

use App\Models\Project;
use App\Models\Project\Planning\QualityAssessment\GeneralScore;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MinToApp extends Model
{
    use HasFactory;

    protected $table = 'min_to_app';
    protected $primaryKey = 'id_min_to_app';
    public $timestamps = false;

    protected $fillable = [
        'id_project',
        'id_general_score',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'id_project');
    }

    public function generalScore(): BelongsTo
    {
        return $this->belongsTo(GeneralScore::class, 'id_general_score');
    }

}
