<?php

namespace App\Models\Project\Planning\QualityAssessment;



use App\Models\Project;
use App\Models\Project\Conducting\Papers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GeneralScore extends Model
{
    use HasFactory;

    protected $table = 'general_score';
    protected $primaryKey = 'id_general_score';
    public $timestamps = false;

    protected $fillable = [
        'start',
        'end',
        'description',
        'id_project',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'id_project');
    }

    public function papers()
    {
        return $this->hasMany(Papers::class, 'id_gen_score', 'id_general_score');
    }
}
