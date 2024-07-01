<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;

class User extends Model implements AuthenticatableContract
{
    use Authenticatable;
    use HasRoles, HasPermissions;
    use HasApiTokens, HasFactory, Notifiable;

    protected $rememberTokenName = 'remember_token';

    protected $fillable = [
        'username',
        'firstname',
        'lastname',
        'email',
        'password',
        'address',
        'city',
        'country',
        'postal',
        'about',
        'institution',
        'occupation',
        'lattes_link',
        'role',
        'active',
    ];

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'members', 'id_user', 'id_project');
    }
    
    public function profile()
    {
        return $this->belongsTo(Profile::class, 'profile_id');
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $roles = [
        'user' => 'USER',
        'super_user' => 'SUPER_USER',
    ];

    protected $attributes = [
        'role' => 'USER',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function level()
    {
        return $this->belongsToMany(Level::class);
    }
    
    public function hasLevel($level)
    {
        return $this->levels()->where('name', $level)->exists();
    }
    
    public function hasPermission($permission)
    {
        foreach ($this->levels as $level) {
            if ($level->permissions()->where('name', $permission)->exists()) {
                return true;
            }
        }
        return false;
    }
}
