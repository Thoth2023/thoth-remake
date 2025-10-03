<?php

namespace App\Models;

use App\Models\Project\Planning\DataExtraction\Question as DataExtractionQuestion;
use App\Models\Project\Planning\QualityAssessment\GeneralScore;
use App\Models\Project\Planning\QualityAssessment\Question as QualityAssessmentQuestion;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

/**
 * Modelo que representa um Projeto no sistema.
 *
 * Gerencia os relacionamentos, regras de negócio e operações relacionadas a projetos,
 * incluindo usuários, bancos de dados, idiomas, tipos de estudo, critérios, perguntas de pesquisa, etc.
 */
class Project extends Model
{
    // como a tabela foi nomeada no singular e não no plural,
    // precisamos especificar o nome da tabela
    // TODO alterar o banco de dados para ter a tabela nomeada como projects
    /**
     * Nome da tabela associada ao modelo.
     * @var string
     */
    protected $table = 'project';

    // como a chave primária não foi nomeada como id, precisamos especificá-la
    // se a chave primária fosse nomeada como id, não precisaríamos especificar
    // porque o laravel saberia automaticamente que a chave primária é id
    // e a definiria automaticamente
    // TODO alterar o banco de dados para ter a chave primária nomeada como id
    /**
     * Chave primária da tabela.
     * @var string
     */
    protected $primaryKey = 'id_project';

    /**
     * Indica se o modelo deve gerenciar timestamps.
     * @var bool
     */
    public $timestamps = true;

    use HasFactory;

    /**
     * Atributos que podem ser preenchidos em massa.
     * @var array
     */
    protected $fillable = [
        'id_user',
        'title',
        'description',
        'objectives',
        'created_by',
        'is_finished',
        'feature_review',
        'generic_search_string',
        'is_public',
    ];

    protected $casts = [
        'is_public' => 'boolean',
    ];

    /**
     * Relacionamento N:N com usuários (membros do projeto).
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'members', 'id_project', 'id_user')
            ->withPivot('level')
            ->join('levels', 'members.level', '=', 'levels.id_level')
            ->select('users.*', 'levels.level as level_name');
    }

    /**
     * Relacionamento N:N com bancos de dados do projeto.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function databases()
    {
        return $this->belongsToMany(Database::class, 'project_databases', 'id_project', 'id_database')
            ->using(ProjectDatabase::class)
            ->withPivot('id_project_database');
    }

    /**
     * Relacionamento N:N com idiomas do projeto.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function languages()
    {
        return $this->belongsToMany(Language::class, 'project_languages', 'id_project', 'id_language')
            ->using(ProjectLanguage::class)
            ->withPivot('id_project_lang');
    }

    /**
     * Relacionamento N:N com tipos de estudo do projeto.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function studyTypes()
    {
        return $this->belongsToMany(StudyType::class, 'project_study_types', 'id_project', 'id_study_type')
            ->using(ProjectStudyType::class)
            ->withPivot('id_project_study_types');
    }

    /**
     * Relacionamento 1:N com perguntas de extração de dados.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dataExtractionQuestions()
    {
        return $this->hasMany(DataExtractionQuestion::class, 'id_project');
    }

    /**
     * Relacionamento 1:N com perguntas de avaliação de qualidade.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function qualityAssessmentQuestions()
    {
        return $this->hasMany(QualityAssessmentQuestion::class, 'id_project');
    }

    /**
     * Relacionamento 1:N com critérios do projeto.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function criterias()
    {
        return $this->hasMany(Criteria::class, 'id_project');
    }

    /**
     * Retorna critérios de inclusão do projeto.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function inclusionCriterias()
    {
        return $this->hasMany(Criteria::class, 'id_project')->where('Type', 'Inclusion');
    }

    /**
     * Retorna critérios de exclusão do projeto.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function exclusionCriterias()
    {
        return $this->hasMany(Criteria::class, 'id_project')->where('Type', 'Exclusion');
    }

    /**
     * Relacionamento 1:N com perguntas de pesquisa.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function researchQuestions()
    {
        return $this->hasMany(ResearchQuestion::class, 'id_project');
    }

    /**
     * Relacionamento 1:1 com a estratégia de busca do projeto.
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function searchStrategy()
    {
        return $this->hasOne(SearchStrategy::class, 'id_project');
    }

    /**
     * Relacionamento 1:N com termos do projeto.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function terms()
    {
        // Inserir lógica para tabela inclusion_rule
        return $this->hasMany(Term::class, 'id_project');
    }

    /**
     * Relacionamento 1:N com sinônimos dos termos do projeto.
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function synonyms()
    {
        // Inserir lógica para tabela exclusion_rule
        return $this->hasManyThrough(Synonym::class, Term::class, 'id_project', 'id_term');
    }

    /**
     * Retorna um array com termos e seus respectivos sinônimos para o projeto.
     * @param int $id_project
     * @return array
     */
    public function termsAndSynonyms($id_project): array
    {
        // Inserir lógica para tabela members
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

    /**
     * Relacionamento 1:N com palavras-chave do projeto.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function keywords()
    {
        return $this->hasMany(Keyword::class, 'id_project');
    }

    /**
     * Relacionamento 1:N com domínios do projeto.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function domains()
    {
        return $this->hasMany(Domain::class, 'id_project');
    }

    /**
     * Relacionamento 1:N com pontuações gerais de avaliação de qualidade.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function generalScores()
    {
        return $this->hasMany(GeneralScore::class, 'id_project');
    }

    /**
     * Define o nível do usuário no projeto, atribuindo à propriedade user_level.
     * @param User $user
     * @return void
     */
    public function setUserLevel(User $user)
    {
        $member = $this->users()
            ->where('users.id', $user->id)
            ->first();

        if ($member) {
            $status = $member->pivot->status ?? null;
            if ($status === 'accepted' || $status === null) {
                $this->user_level = $member;
            } else {
                $this->user_level = null;
            }
        } else {
            $this->user_level = null;
        }
    }

    private function insertSearchStringGenerics($idProject)
    {
        // Inserir lógica para tabela search_string_generics
    }

    private function insertInclusionRule($idProject)
    {
        // Inserir lógica para tabela inclusion_rule
    }

    private function insertExclusionRule($idProject)
    {
        // Inserir lógica para tabela exclusion_rule
    }

    private function insertMembers($idProject, $createdBy, $name)
    {
        // Inserir lógica para tabela members
    }

    /**
     * Adiciona datas de início e fim ao projeto.
     * @param string $startDate
     * @param string $endDate
     * @return void
     */
    public function addDate($startDate, $endDate): void
    {
        $this->start_date = $startDate;
        $this->end_date = $endDate;
        $this->save();
    }

    /**
     * Copia o planejamento de outro projeto para este projeto.
     * Inclui bancos de dados, idiomas, tipos de estudo, perguntas, critérios, domínios, etc.
     * @param Project $sourceProject
     * @return void
     */
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

    /**
     * Verifica se o usuário possui determinado nível no projeto.
     * @param User $user
     * @param string $level
     * @return bool
     */
    public function userHasLevel(User $user, string $level): bool
    {
        $member = $this->users()
            ->wherePivot('id_user', $user->id)
            ->wherePivot('level', $level)
            ->first();

        if (!$member) {
            return false;
        }

        $status = $member->pivot->status ?? null;
        return $status === 'accepted' || $status === null;
    }

    /**
     * Marca o projeto como finalizado.
     * @return void
     */
    public  function markAsFinished()
    {
        $this->is_finished = true;
        $this->save();
    }

    /**
     * Verifica se o projeto está finalizado.
     * @return bool
     */
    public function isFinished(): bool
    {
        $idproject = $this->id_project; // Atribui o valor de id_project para $idproject
        if (!$this->validateAll($idproject)) {
            $this->finished = true;
            $this->save();
        }
        return $this->finished;
    }

    /**
     * Conta o número de projetos finalizados.
     * @return int
     */
    public static function countFinishedProjects()
    {
        return self::where('is_finished', 1)->count();
    }

    /**
     * Conta o número de projetos em andamento.
     * @return int
     */
    public static function countOngoingProjects()
    {
        return self::where('is_finished', 0)->count();
    }

    /**
     * Valida se o planejamento do projeto está completo.
     * @param int $id_project
     * @return bool
     */
    public static  function validatePlanning($id_project):bool
    {
        $domain = DB::table('domain')->where('id_project', $id_project)->first();
        $question_extraction = DB::table('question_extraction')->where('id_project', $id_project)->first();
        if ($domain == null && $question_extraction == null){
            return false;
        }

        return true;
    }

    /**
     * Valida se a etapa de condução do projeto está completa.
     * @param int $id_project
     * @return bool
     */
    public static function validateConducting($id_project): bool
    {
        $question_quality = DB::table('question_quality')->where('id_project', $id_project)->first();

        if ($question_quality == null){
            return false;
        }

        return true;
    }

    /**
     * Valida se todas as etapas principais do projeto estão completas.
     * @param int $id_project
     * @return bool
     */
    public static function validateAll($id_project):bool
    {
        $planning = Project::validatePlanning($id_project);
        $conducting = Project::validateConducting($id_project);
        if ($planning && $conducting) {
            return true;
        }
        return false;
    }

    /**
     * Retorna o usuário proprietário do projeto.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userByProject()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }


}
