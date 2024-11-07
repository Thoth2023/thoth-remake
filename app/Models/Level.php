<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Permission;
use App\Models\User;
use Spatie\Permission\Models\Role as SpatieRole;
use Spatie\Permission\Traits\HasRoles;

class Level extends Model{
    use HasFactory, HasRoles;
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
        // Aqui, usaremos a tabela 'permissions' do Spatie com relação N:N
        return $this->belongsToMany(Permission::class, 'level_permission', 'level_id', 'permission_id');
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
