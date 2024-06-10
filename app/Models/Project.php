<?php

namespace App\Models;

use App\Models\Project\Planning\DataExtraction\Question as DataExtractionQuestion;
use App\Models\Project\Planning\QualityAssessment\GeneralScore;
use App\Models\Project\Planning\QualityAssessment\Question as QualityAssessmentQuestion;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'feature_review',
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

    public function dataExtractionQuestions()
    {
        return $this->hasMany(DataExtractionQuestion::class, 'id_project');
    }

    public function qualityAssessmentQuestions()
    {
        return $this->hasMany(QualityAssessmentQuestion::class, 'id_project');
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
    public function keywords()
    {
        return $this->hasMany(Keyword::class, 'id_project');
    }

    public function domains()
    {
        return $this->hasMany(Domain::class, 'id_project');
    }

    public function generalScores()
    {
        return $this->hasMany(GeneralScore::class, 'id_project');
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

    /*
     * Add the start and end date to the project
     *
     * @param $startDate
     * @param $endDate
     * @return void
     *
     */
    public function addDate($startDate, $endDate): void
    {
        $this->start_date = $startDate;
        $this->end_date = $endDate;
        $this->save();
    }

    public function copyPlanningFrom(Project $sourceProject)
    {
        $this->start_date = $sourceProject->start_date;
        $this->end_date = $sourceProject->end_date;

        $this->save();

        $this->databases()->attach($sourceProject->databases->pluck('id_database')->toArray());
        $this->languages()->attach($sourceProject->languages->pluck('id_language')->toArray());
        $this->studyTypes()->attach($sourceProject->studyTypes->pluck('id_study_type')->toArray());

        foreach ($sourceProject->dataExtractionQuestions as $question) {
            $this->dataExtractionQuestions()->create($question->toArray());
        }

        foreach ($sourceProject->qualityAssessmentQuestions as $question) {
            $this->qualityAssessmentQuestions()->create($question->toArray());
        }

        foreach ($sourceProject->criterias as $criteria) {
            $this->criterias()->create($criteria->toArray());
        }

        foreach ($sourceProject->researchQuestions as $question) {
            $this->researchQuestions()->create($question->toArray());
        }

        if ($sourceProject->searchStrategy) {
            $this->searchStrategy()->create($sourceProject->searchStrategy->toArray());
        }

        foreach ($sourceProject->terms as $term) {
            $newTerm = $this->terms()->create($term->toArray());
            foreach ($term->synonyms as $synonym) {
                $newTerm->synonyms()->create($synonym->toArray());
            }
        }

        foreach ($sourceProject->generalScores as $score) {
            $this->generalScores()->create($score->toArray());
        }

        foreach ($sourceProject->keywords as $keyword) {
            $this->keywords()->create($keyword->toArray());
        }

        foreach ($sourceProject->domains as $domain) {
            $this->domains()->create($domain->toArray());
        }
        
        $this->save();
    }
}
