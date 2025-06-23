<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Symfony\Component\HttpKernel\Profiler\Profile;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

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
        'terms_and_lgpd',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $attributes = [
        'role' => 'USER',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relacionamento com projetos através da tabela `members`
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'members', 'id_user', 'id_project')
            ->withPivot('level', 'status', 'invitation_token');
    }

    // Relacionamento com projetos com nível de acesso específico (usando o campo `level`)
    public function projectsWithLevels()
    {
        return $this->belongsToMany(Project::class, 'members', 'id_user', 'id_project')
            ->withPivot('level')
            ->withTimestamps();
    }

    // Relacionamento com o modelo `Level`, caso necessário
    public function levels()
    {
        return $this->belongsToMany(Level::class, 'user_levels', 'user_id', 'level_id')
            ->withTimestamps();
    }

    // Verificar se o usuário tem acesso a um projeto específico
    public function hasProjectAccess(Project $project): bool
    {
        return $this->projects()->where('id_project', $project->id)->exists();
    }

    // Verificar se o usuário é administrador de um projeto específico
    public function isProjectAdmin(Project $project): bool
    {
        return $this->projectsWithLevels()
            ->where('id_project', $project->id)
            ->wherePivot('level', 'administrator')
            ->exists();
    }

    // Hash automático para a senha
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    // Relacionamento de perfil (caso necessário)
    public function profile()
    {
        return $this->belongsTo(Profile::class, 'profile_id');
    }

    public function deleteUserData()
    {
        // Anonimiza os dados do usuário
        $this->update([
            'username' => 'anonimo_' . Str::random(8),
            'firstname' => 'Anônimo',
            'lastname' => 'Anônimo',
            'email' => 'deleted' . $this->id . '@example.com',
            'address' => null,
            'city' => null,
            'country' => null,
            'postal' => null,
            'institution' => null,
            'occupation' => null,
            'lattes_link' => null,
            'about' => null,
            'active' => false, // Desativa a conta
        ]);
    }

}
