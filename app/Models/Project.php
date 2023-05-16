<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    // since the table was named in the singular and not plural,
    // we need to specify the table name
    protected $table = 'project';

    public $timestamps = false;

    use HasFactory;

    protected $fillable = [
        'id_user',
        'title', 
        'description', 
        'objectives',
        //'copy_planning',
    ];

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
