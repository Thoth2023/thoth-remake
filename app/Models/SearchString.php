<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public function getIdProjectDatabase($database, $id_project)
    {
        $id_database = DB::table('data_base')
                        ->where('name', $database)
                        ->value('id_database');

        if ($id_database) {
            $id_project_database = DB::table('project_databases')
                                    ->where('id_project', $id_project)
                                    ->where('id_database', $id_database)
                                    ->value('id_project_database');

            return $id_project_database;
        }
        return null;
    }

    public function generateString($string, $id_project_database)
    {
        DB::table('search_string')
            ->where('id_project_database', $id_project_database)
            ->update(['description' => $string]);
    }

    public function generateStringGeneric($string, $id_project)
    {
        DB::table('search_string_generics')
            ->where('id_project', $id_project)
            ->update(['description' => $string]);
    }

}
