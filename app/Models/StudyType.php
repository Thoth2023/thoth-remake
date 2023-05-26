<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyType extends Model
{
     // since the table was named in the singular and not plural,
    // we need to specify the table name
    // TODO change the db to have the table named as study_types
    protected $table = 'study_type';

    // since the primary key was not named as id, we need to specify it
    // if the primary key was named as id, we would not need to specify it
    // because laravel would automatically know that the primary key is id
    // and would automatically set it
    // TODO change the db to have the primary key named as id

    protected $primaryKey = 'id_study_type';
    public $timestamps = false;

    use HasFactory;

    protected $fillable = [
        'description',
    ];
}
