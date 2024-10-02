<?php

namespace App\Models;

use App\Models\Project\Conducting\Papers;
use Illuminate\Database\Eloquent\Model;

class ProjectDatabases extends Model
{
    protected $table = 'project_databases';

    protected $primaryKey = 'id_project_database';

    protected $fillable = ['id_project', 'id_database', 'search_string'];

    public function project()
    {
        return $this->belongsTo(Project::class, 'id_project', 'id_project');
    }
    public function database()
    {
        return $this->belongsTo(Database::class, 'id_database', 'id_database');
    }
    public function papers()
    {
        return $this->hasMany(Papers::class, 'data_base', 'id_database');
    }

}
