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

/**
 * Modelo que representa um Usuário do sistema.
 *
 * Gerencia autenticação, relacionamentos com projetos, níveis de acesso,
 * anonimização de dados e outras operações relacionadas ao usuário.
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * Nome do campo do token de "lembrar de mim".
     * @var string
     */
    protected $rememberTokenName = 'remember_token';

    /**
     * Atributos que podem ser preenchidos em massa.
     * @var array
     */
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

    /**
     * Atributos ocultos para arrays.
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Atributos com valores padrão.
     * @var array
     */
    protected $attributes = [
        'role' => 'USER',
    ];

    /**
     * Conversão de tipos de atributos.
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relacionamento N:N com projetos através da tabela `members`.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'members', 'id_user', 'id_project')
            ->withPivot('level', 'status', 'invitation_token');
    }

    /**
     * Relacionamento N:N com projetos, incluindo o nível de acesso (campo `level`).
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function projectsWithLevels()
    {
        return $this->belongsToMany(Project::class, 'members', 'id_user', 'id_project')
            ->withPivot('level')
            ->withTimestamps();
    }

    /**
     * Relacionamento N:N com o modelo `Level` através da tabela `user_levels`.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function levels()
    {
        return $this->belongsToMany(Level::class, 'user_levels', 'user_id', 'level_id')
            ->withTimestamps();
    }

    /**
     * Verifica se o usuário tem acesso a um projeto específico.
     * @param Project $project
     * @return bool
     */
    public function hasProjectAccess(Project $project): bool
    {
        return $this->projects()->where('id_project', $project->id)->exists();
    }

    /**
     * Verifica se o usuário é administrador de um projeto específico.
     * @param Project $project
     * @return bool
     */
    public function isProjectAdmin(Project $project): bool
    {
        return $this->projectsWithLevels()
            ->where('id_project', $project->id)
            ->wherePivot('level', 'administrator')
            ->exists();
    }

    /**
     * Define automaticamente o hash da senha ao atribuir o valor.
     * @param string $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * Relacionamento de perfil do usuário (caso utilizado).
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function profile()
    {
        return $this->belongsTo(Profile::class, 'profile_id');
    }

    public function notifications()
    {
        return $this->hasMany(ProjectNotification::class, 'user_id')->latest();
    }

    public function projectNotifications()
    {
        return $this->hasMany(ProjectNotification::class, 'user_id')
            ->orderBy('created_at', 'desc');
    }


    /**
     * Anonimiza os dados do usuário, tornando-os irreconhecíveis e desativando a conta.
     * @return void
     */
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
