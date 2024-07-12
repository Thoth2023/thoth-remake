<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Permission;
use App\Models\User;

class Level extends Model{
    use HasFactory;
    protected $table = 'levels';
    

    protected $fillable = [
        'level',
        'description', 
        'permissions',
    ]; 

    protected $primaryKey = 'id_level';
    public $incrementing = true; 
    protected $keyType = 'int';
    public $timestamps = true;

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_levels')
                    ->withTimestamps();
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_user')
                    ->withPivot('level_id')
                    ->withTimestamps();
    }
}