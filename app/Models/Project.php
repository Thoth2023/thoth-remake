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

    public function users()
    {
        return $this->belongsToMany(User::class, 'members', 'id_project', 'id_user')
                    ->withPivot('level')
                    ->join('levels', 'members.level', '=', 'levels.id_level')
                    ->select('users.*', 'levels.level as level_name');
    }

    public function databases()
    {
        return $this->belongsToMany(Database::class, 'project_databases', 'id_project', 'id_database')
            ->using(ProjectDatabase::class)
            ->withPivot('id_project_database');
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class, 'project_languages', 'id_project', 'id_language')
            ->using(ProjectLanguage::class)
            ->withPivot('id_project_lang');
    }

    public function studyTypes()
    {
        return $this->belongsToMany(StudyType::class, 'project_study_types', 'id_project', 'id_study_type')
            ->using(ProjectStudyType::class)
            ->withPivot('id_project_study_types');
    }

    public function questionExtractions()
    {
        return $this->hasMany(QuestionExtraction::class, 'id_project');
    }

    public function criterias()
    {
        return $this->hasMany(Criteria::class, 'id_project');
    }

    public function inclusionCriterias()
    {
        return $this->hasMany(Criteria::class, 'id_project')->where('Type', 'Inclusion');
    }

    public function exclusionCriterias()
    {
        return $this->hasMany(Criteria::class, 'id_project')->where('Type', 'Exclusion');
    }

    public function researchQuestions()
    {
        return $this->hasMany(ResearchQuestion::class, 'id_project');
    }

    public function searchStrategy()
    {
        return $this->hasOne(SearchStrategy::class, 'id_project');
    }

    public function terms()
    {
        // Insert logic for inclusion_rule table
        return $this->hasMany(Term::class, 'id_project');
    }

    public function synonyms()
    {
        // Insert logic for exclusion_rule table
        return $this->hasManyThrough(Synonym::class, Term::class, 'id_project', 'id_term');
    }

    public function termsAndSynonyms($id_project): array
    {
        // Insert logic for members table
        $project = Project::findOrFail($id_project);
        $terms = $project->terms;
        $data = array();

        foreach ($terms as $term) {
            $termData = array(
                'term' => $term->description,
                'synonyms' => $term->synonyms->pluck('description')->toArray(),
            );
            array_push($data, $termData);
        }
        return $data;
    }

    public function setUserLevel(User $user)
    {
        $this->user_level = $this->users()
            ->where('users.id', $user->id)
            ->first();
    }

    private function insertSearchStringGenerics($idProject)
    {
        // Insert logic for search_string_generics table
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

    public function addDate($startDate, $endDate)
    {
        $this->start_date = $startDate;
        $this->end_date = $endDate;
        $this->save();
    }
}
