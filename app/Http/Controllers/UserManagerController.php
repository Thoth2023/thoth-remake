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
        // Middleware executado antes de cada método: verifica se o usuário tem permissão para gerenciar usuários
        $this->middleware(function ($request, $next) {
            // Se o usuário NÃO tiver permissão ('manage-users'), redireciona para o dashboard com erro
            if (Gate::denies('manage-users')) {
                return redirect()->route('dashboard')->with('error', 'Você não tem permissão para acessar o Gerenciamento de Usuários.');
            }
            // Se tiver permissão, segue para o próximo middleware ou método
            return $next($request);
        });
    }

    public function index()
    {
        // Busca todos os usuários no banco
        $users = User::all();

        // Retorna a view com todos os usuários listados
        return view('pages.user-management', compact('users'));
    }

    public function edit(User $user)
    {
        // Mapeia os tipos de papel disponíveis para exibir no formulário (ex: SUPER_USER, USER)
        $roles = [
            'SUPER_USER' => __('pages/user-manager.super_user'),
            'USER' => __('pages/user-manager.user'),
        ];

        // Retorna a view de edição de usuário com os dados do usuário e os papéis disponíveis
        return view('pages.user-edit', compact('user', 'roles'));
    }

    public function create()
    {
        // Retorna a view de criação de usuário
        return view('pages.user-create');
    }

    public function deactivate(User $user)
    {
        // Se o usuário estiver ativo, desativa
        if ($user->active == true) {
            $user->active = false;
            $user->save();

            return redirect()->route('user-manager')->with('success', __('pages/user-manager.deactivated'));
        } else {
            // Caso contrário, ativa o usuário
            $user->active = true;
            $user->save();

            return redirect()->route('user-manager')->with('success', __('pages/user-manager.activated'));
        }
    }

    public function update(Request $request, User $user)
    {
        // Valida os dados recebidos do formulário de edição
        $request->validate([
            'username' => 'required|string|max:255|min:2',
            'firstname' => 'nullable|string|max:255',
            'lastname' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'institution' => 'nullable|string|max:255',
            'function' => 'required|string', // função = papel (role)
        ]);

        // Mapeamento da string visível para a constante do sistema
        $rolesMapping = [
            __('pages/user-manager.super_user') => 'SUPER_USER',
            __('pages/user-manager.user') => 'USER',
        ];

        // Recupera o papel selecionado no formulário e converte para a constante usada no sistema
        $role = $request->input('function');
        $role = $rolesMapping[$role] ?? 'USER'; // se não encontrar, define como 'USER'

        // Atualiza os dados do usuário no banco
        $user->update([
            'username' => $request->username,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'occupation' => $request->occupation,
            'email' => $request->get('email'),
            'institution' => $request->institution,
            'role' => $role,
        ]);

        // Redireciona para a listagem de usuários com uma mensagem de sucesso
        return redirect()->route('user-manager')->with('success', __('pages/user-management.updated'));
    }

    public function store()
    {
        // Valida os dados do formulário de criação de usuário
        $attributes = request()->validate([
            'username' => 'required|max:255|min:2',
            'email' => 'required|email|max:255|unique:users,email', // não pode ter e-mails duplicados
            'password' => 'required|min:5|max:255',
        ]);

        // Cria o usuário no banco de dados com os dados validados
        $user = User::create($attributes);

        // Redireciona para a lista com mensagem de sucesso
        return redirect()->route('user-manager')->with('success', __('pages/user-management.created'));
    }
}
