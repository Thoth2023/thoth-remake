<?php

namespace App\Models\Project\Conducting;

use App\Models\BibUpload;
use App\Models\Database;
use App\Models\Project\Conducting\StudySelection\PaperDecisionConflict;
use App\Models\ProjectDatabases;
use App\Models\StatusSelection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Papers extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['title'];

    public function database()
    {
        return $this->belongsTo(Database::class, 'data_base', 'id_database');
    }

    public function status_selection()
    {
        return $this->belongsTo(StatusSelection::class, 'status_selection', 'id_status');
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
