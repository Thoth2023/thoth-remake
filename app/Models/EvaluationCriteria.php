<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationCriteria extends Model
{
    use HasFactory;

    protected $table = 'evaluation_criteria';

    protected $fillable = [
        'id_paper',
        'id_criteria',
        'id_member',
    ];

    public $timestamps = false;


    public function criteria() {
        return $this->belongsTo(Criteria::class, 'id_criteria', 'id');
    }
}
