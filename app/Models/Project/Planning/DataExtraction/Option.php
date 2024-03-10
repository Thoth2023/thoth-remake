<?php

namespace App\Models\Project\Planning\DataExtraction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    // since the table was named in the singular and not plural,
    // we need to specify the table name
    // TODO change the db to have the table named as keywords
    protected $table = 'options_extraction';

    // since the primary key was not named as id, we need to specify it
    // if the primary key was named as id, we would not need to specify it
    // because laravel would automatically know that the primary key is id
    // and would automatically set it
    // TODO change the db to have the primary key named as id

    protected $primaryKey = 'id_option';
    public $timestamps = false;

    use HasFactory;

    protected $fillable = [
        'id_de',
        'description',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class, 'id_de');
    }
}
