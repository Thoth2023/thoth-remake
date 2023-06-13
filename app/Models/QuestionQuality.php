<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionQuality extends Model
{
    use HasFactory;

    protected $table = 'question_quality';

    protected $primaryKey = 'id_qa';

    public $timestamps = false;

    protected $fillable = [
        'description',
        'id',
        'id_project',
        'weight'
    ];

    public function scoreQualities() {
        return $this->hasMany(ScoreQuality::class, 'id_qa');
    }
}
