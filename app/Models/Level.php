<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model{
    use HasFactory;
    protected $table = 'levels';
    

    protected $fillable = [
        'level',
        'description',
    ];

    protected $primaryKey = 'id_level';
    public $incrementing = true; 
    protected $keyType = 'int';
    public $timestamps = true;
}