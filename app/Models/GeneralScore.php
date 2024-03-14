<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
