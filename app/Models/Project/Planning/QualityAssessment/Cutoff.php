<?php

namespace App\Models\Project\Planning\QualityAssessment;

use App\Models\Project;
use App\Models\Project\Planning\QualityAssessment\GeneralScore;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cutoff extends Model
{
    use HasFactory;

    protected $table = 'qa_cutoff';
    protected $primaryKey = 'id_cutoff';
    public $timestamps = false;

    protected $fillable = [
        'id_project',
        'id_general_score',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'id_project');
    }
}
