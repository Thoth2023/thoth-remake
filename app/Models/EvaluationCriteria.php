<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationCriteria extends Model
{
    use HasFactory;

    private $table = 'evaluation_criteria';


    public function criteria() {
        return $this->belongsTo(Criteria::class, 'id_criteria', 'id');
    }
}
