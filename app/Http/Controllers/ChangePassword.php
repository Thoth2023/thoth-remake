<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ChangePassword extends Controller
{
    /**
     * Exibe a tela para alteração de senha.
     */
    public function show()
    {
        return view('auth.change-password');
    }

    /**
     * Atualiza a senha do usuário com base no e-mail informado.
     *
     * Última modificação por Luiza Velasque.
     * - Corrigida validação de campos.
     * - Adicionado hash da senha antes de salvar.
     * - Removido logout no construtor.
     * - Corrigida busca segura de usuário.
     */
    public function update(Request $request)
    {
        $attributes = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:5'],
            'confirm_password' => ['same:password'], // Corrigido o nome do campo
        ]);

        // Busca o usuário pelo e-mail fornecido
        $user = User::where('email', $attributes['email'])->first();

        if ($user) {
            try {
                // Garante o hash da nova senha antes de salvar
                $user->password = Hash::make($attributes['password']);

                $user->save();

                return redirect('login')->with(
                    'success',
                    __('auth/change-password.messages.success')
                );
            } catch (\Throwable $e) {
                Log::error("Erro ao atualizar senha: " . $e->getMessage());
                return back()->with(
                    'error',
                    __('auth/change-password.messages.error')
                );
            }
        }

        return back()->with(
            'error',
            __('auth/change-password.messages.error')
        );
    }
}
