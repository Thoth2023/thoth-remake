<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Term;
use App\Models\SearchStrategy;
use App\Models\SearchString;
use App\Models\ProjectDatabases;
use Illuminate\Support\Collection;


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
        'created_by',
    ];

    public function users() {
        return $this->belongsToMany(User::class, 'members', 'id_project', 'id_user')
                    ->withPivot('level')
                    ->join('levels', 'members.level', '=', 'levels.id_level')
                    ->select('users.*', 'levels.level as level_name');
    }

    public function databases() {
        return $this->belongsToMany(DataBase::class, 'project_databases', 'id_project', 'id_database');
    }

    public function questionExtractions() {
        return $this->hasMany(QuestionExtraction::class, 'id_project');
    }

    public function searchStrategy()
    {
        return $this->hasOne(SearchStrategy::class, 'id_project');
    }

    public function setUserLevel(User $user)
    {
        $this->user_level = $this->users()
            ->where('users.id', $user->id)
            ->first()
            ->pivot
            ->level;
    }

    public function terms()
    {
        return $this->hasMany(Term::class, 'id_project');
    }

    public function synonyms()
    {
        return $this->hasManyThrough(Synonym::class, Term::class, 'id_project', 'id_term');
    }

    public function termsAndSynonyms($id_project): array
    {
        $project = Project::findOrFail($id_project);
        $terms = $project->terms;
        $data = array();
        
        foreach($terms as $term) {
            $termData = array(
                'term' => $term->description,
                'synonyms' => $term->synonyms->pluck('description')->toArray(),
            );
            array_push($data, $termData);
        }
        return $data;
    }

    public function addDate($startDate, $endDate)
    {
        $this->start_date = $startDate;
        $this->end_date = $endDate;
        $this->save();
    }
}
