<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Password;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Display login page.
     *
     */
    public function show(): View
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Verifica se o usuário existe
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => __('auth/login.user_not_found')]);
        }

        // Verifica se o usuário está ativo
        if (!$user->active) {
            return back()->withErrors(['email' => __('auth/login.inactive')]);
        }

        // Verifica as credenciais
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('about');
        }

        // Retorna erro se a senha estiver incorreta
        return back()->withErrors([
            'password' => __('auth/login.failed'),
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
