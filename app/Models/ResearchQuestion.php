<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResearchQuestion extends Model
{
    // since the table was named in the singular and not plural,
    // we need to specify the table name
    // TODO change the db to have the table named as research_questions
    protected $table = 'research_question';

    protected $primaryKey = 'id_research_question';
    public $timestamps = false;

    use HasFactory;

    protected $fillable = [
        'id_project',
        'description',
        'id',
    ];

    public function project() {
        return $this->belongsTo(Project::class, 'id_project', 'id_project');
    }
}
