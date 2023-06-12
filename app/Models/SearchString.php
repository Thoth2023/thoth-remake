<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchString extends Model
{
    use HasFactory;
    protected $table = 'search_string';

    // we have to set the primary key because we're dealing with a legacy
    // databasee with a defined key, in the future we could adapt the to be the
    // laravel way
    // TODO change the primary key to follow the best practices
    protected $primaryKey = 'id_search_string';
    public $timestamps = false;

    protected $fillable = [
        'description',
    ];

    public function databases() {
        return $this->belongsToMany(DataBase::class, 'project_databases', 'id_project', 'id_database');
    }
}
