<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SearchStrategy extends Model
{
    protected $table = 'search_strategy';
    protected $primaryKey = 'id_search_strategy';
    public $timestamps = false;

    use HasFactory;

    protected $fillable = ['description'];

}
