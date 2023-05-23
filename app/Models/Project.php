<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        // 'id_member',
        //'copy_planning',
    ];

    public function users() { /* Faz a relação com os usuários*/
        return $this->belongsToMany(User::class);//->withPivot('email', 'level');
        //return $this->belongsToMany(Project::class, 'project_user', 'user_id', 'project_id');
    }

    public function add_member($email, $level, $idProject)
    {
        $id_level = null;
		$this->db->select('id_level');
		$this->db->from('levels');
		$this->db->where('level', $level);
		$query = $this->db->get();

		foreach ($query->result() as $row) {
			$id_level = $row->id_level;
		}

		$id_user = $this->get_id_name_user($email);

		$data = array(
			'id_user' => $id_user[0],
			'id_project' => $id_project,
			'level' => $id_level
		);
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
