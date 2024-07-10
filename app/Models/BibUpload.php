<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BibUpload extends Model
{
    protected $table = 'bib_upload';
    protected $primaryKey = 'id_bib';
    public $timestamps = false;

    public function studies()
    {
        return $this->hasMany(Study::class, 'id_bib', 'id_bib');
    }

    public function projectDatabase()
    {
        return $this->belongsTo(ProjectDatabases::class, 'id_project_database', 'id_project_database');
    }
}
