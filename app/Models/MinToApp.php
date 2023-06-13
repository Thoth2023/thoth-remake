<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MinToApp extends Model
{
    use HasFactory;

    protected $table = 'min_to_app';

    protected $primaryKey = 'id_min_to_app';

    public $timestamps = false;

    protected $fillable = [
        'id_general_score',
        'id_project'
    ];
}
