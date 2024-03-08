<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Project;

class Term extends Model
{
    use HasFactory;
    protected $table = 'term';
    protected $primaryKey = 'id_term';
    public $timestamps = false;
    protected $fillable = [
        'description',
        'project_id',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function synonyms()
    {
        return $this->hasMany(Synonym::class, 'id_term');
    }
}
