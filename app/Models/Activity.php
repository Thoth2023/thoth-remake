<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{

    use HasFactory;
    protected $table = 'activity_log';
    protected $primaryKey = 'id_log';
    public $timestamps = true;

    protected $fillable = [
        'activity',
        'id_module',
        'id_project',
        'id_user'
    ];

    public function user() {

        return $this->belongsTo(User::class, 'id_user');
    }
    public function project() {
        return $this->belongsTo(Project::class, 'id_project');
    }
}
