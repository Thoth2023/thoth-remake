<?php

namespace App\Providers;

use App\Models\Member;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Gate para verificar se o usuário tem acesso a um projeto específico
        Gate::define('access-project', function (User $user, Project $project) {
            return Member::where('id_user', $user->id)
                ->where('id_project', $project->id_project)
                ->exists();
        });

        // Gate para verificar se o usuário pode gerenciar o projeto
        Gate::define('manage-project', function (User $user, Project $project) {
            return Member::where('id_user', $user->id)
                ->where('id_project', $project->id)
                ->where('level', 'administrator') // Define que o nível precisa ser "administrator"
                ->exists();
        });
        // Define a gate para gerenciamento de usuários (apenas SUPER_USER pode acessar)
        Gate::define('manage-users', function ($user) {
            return $user->role === 'SUPER_USER';
        });
    }
}
