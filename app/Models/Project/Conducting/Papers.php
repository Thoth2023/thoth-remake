<?php

namespace App\Models\Project\Conducting;

use App\Models\BibUpload;
use App\Models\Database;
use App\Models\Project\Conducting\StudySelection\PaperDecisionConflict;
use App\Models\ProjectDatabases;
use App\Models\StatusQualityAssessment;
use App\Models\StatusSelection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Papers extends Model
{
    use HasFactory;

    protected $table = 'papers';
    protected $primaryKey = 'id_paper';
    public $timestamps = false;

    protected $fillable = [
        'id_bib',
        'title',
        'author',
        'book_title',
        'volume',
        'pages',
        'num_pages',
        'abstract',
        'keywords',
        'doi',
        'journal',
        'issn',
        'location',
        'isbn',
        'address',
        'type',
        'bib_key',
        'url',
        'publisher',
        'year',
        'added_at',
        'update_at',
        'data_base',
        'id',
        'status_selection',
        'check_status_selection',
        'status_qa',
        'id_gen_score',
        'check_qa',
        'score',
        'status_extraction',
        'note',
    ];

    public function database()
    {
        return $this->belongsTo(Database::class, 'data_base', 'id_database');
    }

    public function status_selection()
    {
        return $this->belongsTo(StatusSelection::class, 'status_selection', 'id_status');
    }

    public function status_qa()
    {
        return $this->belongsTo(StatusQualityAssessment::class, 'status_qa', 'id_status');
    }

    public function bibUpload()
    {
        return $this->belongsTo(BibUpload::class, 'id_bib', 'id_bib');
    }

    public static function isDuplicate($title, $id)
    {
        return self::where('title', $title)->where('id_paper', '!=', $id)->exists();
    }
    public function paperDecisionConflicts()
    {
        return $this->hasMany(PaperDecisionConflict::class, 'id_paper', 'id_paper');
    }

    public function ScopeFindPapersByIdProject($query, $projectId)
    {
        $idsDatabase = ProjectDatabases::where('id_project', $projectId)->pluck('id_project_database');

        $idsBib = [];

        if (count($idsDatabase) > 0) {
            $idsBib = BibUpload::whereIn('id_project_database', $idsDatabase)->pluck('id_bib')->toArray();
        }

        return $query->whereIn('id_bib', $idsBib)->get();
    }
}
