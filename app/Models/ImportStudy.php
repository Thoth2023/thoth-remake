<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportStudy extends Model
{
  use HasFactory;

  protected $table = 'import_study';

  protected $primaryKey = 'id_import_study';
  public $timestamps = true;

  protected $fillable = [
    'id_project',
    'id_database',
    'file',
    'description',
    'imported_studies_count',
    'failed_imports_count',
  ];

  public function project()
  {
    return $this->belongsTo(Project::class, 'id_project', 'id_project');
  }

  public function database()
  {
    return $this->belongsTo(Database::class, 'id_database', 'id_database');
  }
}
