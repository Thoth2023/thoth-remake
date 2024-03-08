<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataBase extends Model
{
    // since the table was named in the singular and not plural,
    // we need to specify the table name
    // TODO change the db to have the table named as keywords
    // TODO change the db to have the table named as data_bases
    protected $table = 'data_base';

    // since the primary key was not named as id, we need to specify it
    // if the primary key was named as id, we would not need to specify it
    // because laravel would automatically know that the primary key is id
    // and would automatically set it
    // TODO change the db to have the primary key named as id

    protected $primaryKey = 'id_database';
    public $timestamps = false;

    use HasFactory;

    protected $fillable = [
        'link',
        'name'
    ];

    public function searchString()
        {
            return $this->belongsTo(SearchString::class);
        }

}


