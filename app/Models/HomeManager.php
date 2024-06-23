<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeManager extends Model
{
    use HasFactory;

    protected $table = 'home_manager';
     
    protected $fillable = [
        'title',
        'description'
    ];
}
