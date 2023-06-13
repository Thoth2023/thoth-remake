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
        'description',
        'start',
        'end',
        'id_project',
    ];
}
