<?php

namespace App\Models\Project\Planning\DataExtraction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Project\Planning\DataExtraction\QuestionTypes;
use App\Models\Project\Planning\DataExtraction\Option;
use App\Models\Project;

class Question extends Model
{
    // since the table was named in the singular and not plural,
    // we need to specify the table name
    // TODO change the db to have the table named as keywords
    protected $table = 'question_extraction';

    // since the primary key was not named as id, we need to specify it
    // if the primary key was named as id, we would not need to specify it
    // because laravel would automatically know that the primary key is id
    // and would automatically set it
    // TODO change the db to have the primary key named as id

    protected $primaryKey = 'id_de';
    public $timestamps = false;

    use HasFactory;

    protected $fillable = [
        'description',
        'id',
        'id_project',
        'type',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'id_project');
    }

    public function question_type()
    {
        return $this->belongsTo(QuestionTypes::class, 'type');
    }

    public function options()
    {
        return $this->hasMany(Option::class, 'id_de');
    }
}
