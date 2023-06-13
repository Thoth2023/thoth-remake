<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SearchStrategy extends Model
{
    protected $table = 'search_strategy';
    protected $primaryKey = 'id_search_strategy';
    public $timestamps = false;

    protected $fillable = ['description'];

}
