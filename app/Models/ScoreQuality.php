<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScoreQuality extends Model
{
    use HasFactory;

    protected $table = 'score_quality';

    protected $primaryKey = 'id_score';

    public $timestamps = false;

    protected $fillable = [
        'description',
        'id_qa',
        'score',
        'score_rule'
    ];
}
