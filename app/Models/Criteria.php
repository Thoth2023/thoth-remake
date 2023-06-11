<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    // since the table was named in the singular and not plural,
    // we need to specify the table name
    // TODO change the db to have the table named as research_questions
    protected $table = 'criteria';

    protected $primaryKey = 'id_criteria';
    public $timestamps = false;

    use HasFactory;

    protected $fillable = [
        'id_project',
        'description',
        'id',
        'type',
        'pre_selected',
    ];
}
