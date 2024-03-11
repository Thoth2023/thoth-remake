<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchStringGeneric extends Model
{
    use HasFactory;
    protected $table = 'search_string_generics';
    protected $primaryKey = 'id_search_string_generics';
    public $timestamps = false;

    protected $fillable = [
        'description',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'id_project');
    }
}
