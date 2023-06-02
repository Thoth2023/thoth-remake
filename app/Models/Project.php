<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SearchStrategy;


class Project extends Model
{
    // since the table was named in the singular and not plural,
    // we need to specify the table name
    // TODO change the db to have the table named as projects
    protected $table = 'project';

    // since the primary key was not named as id, we need to specify it
    // if the primary key was named as id, we would not need to specify it
    // because laravel would automatically know that the primary key is id
    // and would automatically set it
    // TODO change the db to have the primary key named as id
    protected $primaryKey = 'id_project';
    public $timestamps = false;

    use HasFactory;

    protected $fillable = [
        'id_user',
        'title',
        'description',
        'objectives',
        //'copy_planning',
    ];

    public function users() {
        return $this->belongsToMany(User::class, 'members', 'id_project', 'id_user');
    }

    public function searchStrategy()
    {
        return $this->hasOne(SearchStrategy::class, 'id_project');
    }

    private function insertSearchStringGenerics($idProject)
    {
        // Insert logic for search_string_generics table
    }

    private function insertSearchStrategy($idProject)
    {
        // Insert logic for search_strategy table
    }

    private function insertInclusionRule($idProject)
    {
        // Insert logic for inclusion_rule table
    }

    private function insertExclusionRule($idProject)
    {
        // Insert logic for exclusion_rule table
    }

    private function insertMembers($idProject, $createdBy, $name)
    {
        // Insert logic for members table
    }
}
