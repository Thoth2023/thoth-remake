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
        // Validação
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 1. Tentar Autenticar
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // 2. VERIFICAÇÃO DE USUÁRIO ATIVO (Reintegrado da versão antiga)
            if (!$user->active) {
                Auth::logout(); // Desloga imediatamente
                $request->session()->invalidate();
                return back()->withErrors(['email' => __('auth/login.inactive')]);
            }

            $request->session()->regenerate();

            // Ignorar verificação de IP para login via Google OAuth
            if (!$request->has('code') && !$request->has('state')) {

                $userIp = session('user_ip');
                $currentIp = $request->ip();

                if ($userIp && $userIp !== $currentIp) {
                    Auth::logout();
                    $request->session()->invalidate();
                    return redirect()->route('login')->with('error', 'Sessão expirada devido a mudança de IP.');
                }

                session(['user_ip' => $currentIp]);
            }

            // Armazena o IP na sessão
            session(['user_ip' => $currentIp]);

            // 4. Fluxo LGPD/Termos
            if (!$user->terms_and_lgpd) {
                $request->session()->flash('show_lgpd_modal', true);
            }

            return redirect()->intended('about');
        }

        // Falha na senha ou e-mail (usar erro genérico é melhor)
        return back()->withErrors(['password' => __('auth/login.failed')]);
    }

    public function acceptLgpd(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            $user->update(['terms_and_lgpd' => true]);
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 401);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
