<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProjectLanguage extends Pivot
{
    protected $table = 'project_languages';

    // since the primary key was not named as id, we need to specify it
    // if the primary key was named as id, we would not need to specify it
    // because laravel would automatically know that the primary key is id
    // and would automatically set it
    // TODO change the db to have the primary key named as id

    protected $primaryKey = 'id_project_lang';
    public $timestamps = false;

    use HasFactory;

    protected $fillable = [
        'id_project',
        'id_language',
    ];
}
