<?php

namespace App\Models\Project\Conducting;

use App\Models\Database;
use App\Models\ProjectDatabases;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Papers extends Model
{
    use HasFactory;


    public function database()
    {
        return $this->belongsTo(Database::class, 'data_base', 'id_database');
    }
}
