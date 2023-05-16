<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    // since the table was named in the singular and not plural,
    // we need to specify the table name
    protected $table = 'project';

    use HasFactory;
}
