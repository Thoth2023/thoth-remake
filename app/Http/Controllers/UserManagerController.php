<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UserManagerController extends Controller
{
    public function __construct()
    {
        // Aplica a verificação de autorização para todos os métodos
        $this->middleware(function ($request, $next) {
            if (Gate::denies('manage-users')) {
                return redirect()->route('dashboard')->with('error', 'Você não tem permissão para acessar o Gerenciamento de Usuários.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $users = User::all();
        return view('pages.user-management', compact('users'));
    }

    public function edit(User $user)
    {
        $roles = [
            'SUPER_USER' => __('pages/user-manager.super_user'),
            'USER' => __('pages/user-manager.user'),
        ];
        return view('pages.user-edit', compact('user', 'roles'));
    }

    public function create()
    {
        return view('pages.user-create');
    }

    public function deactivate(User $user)
    {
        if($user->active == true){
            $user->active = false;
            $user->save();

            return redirect()->route('user-manager')->with('success', __('pages/user-manager.deactivated'));
        } else {
            $user->active = true;
            $user->save();

            return redirect()->route('user-manager')->with('success', __('pages/user-manager.activated'));
        }
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'username' => 'required|string|max:255|min:2',
            'firstname' => 'nullable|string|max:255',
            'lastname' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'institution' => 'nullable|string|max:255',
            'function' => 'required|string',
        ]);

        $rolesMapping = [
            __('pages/user-manager.super_user') => 'SUPER_USER',
            __('pages/user-manager.user') => 'USER',
        ];

        $role = $request->input('function');
        $role = $rolesMapping[$role] ?? 'USER';

        $user->update([
            'username' => $request->username,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'occupation' => $request->occupation,
            'email' => $request->get('email'),
            'institution' => $request->institution,
            'role' => $role,
        ]);

        return redirect()->route('user-manager')->with('success', __('pages/user-management.updated'));
    }

    public function store()
    {
        $attributes = request()->validate([
            'username' => 'required|max:255|min:2',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:5|max:255',
        ]);
        $user = User::create($attributes);

        return redirect()->route('user-manager')->with('success', __('pages/user-management.created'));
    }
}
