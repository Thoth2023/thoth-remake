<?php

namespace App\Models\Project\Conducting;

use App\Models\BibUpload;
use App\Models\Database;
use App\Models\ProjectDatabases;
use App\Models\StatusSelection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Papers extends Model
{
    use HasFactory;

    public $timestamps = false;


    public function database()
    {
        return $this->belongsTo(Database::class, 'data_base', 'id_database');
    }

    public function status_selection()
    {
        return $this->belongsTo(StatusSelection::class, 'status_selection', 'id_status_selection');
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
