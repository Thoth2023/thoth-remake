<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except(['logout', 'acceptLgpd']);
    }

    //LOGIN TRADICIONAL (Email + Senha)
    /**
     * Exibir página de login
     */
    public function show()
    {
        return view('auth.login');
    }

    /**
     * Fazer login com email e senha (do LoginController original)
     */
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

            // 2. VERIFICAÇÃO DE USUÁRIO ATIVO
            if (!$user->active) {
                Auth::logout();
                $request->session()->invalidate();
                return back()->withErrors(['email' => __('auth/login.inactive')]);
            }

            $request->session()->regenerate();

            // 3. Verificação de IP (apenas para login tradicional)
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
            session(['user_ip' => $request->ip()]);

            // 4. Fluxo LGPD/Termos
            if (!$user->terms_and_lgpd) {
                $request->session()->flash('show_lgpd_modal', true);
            }

            Log::info('User logged in traditionally', ['user_id' => $user->id]);

            // Redirecionar para /projects (corrigido de 'about')
            return redirect()->intended('/projects');
        }

        // Falha na senha ou e-mail
        return back()->withErrors(['password' => __('auth/login.failed')]);
    }

    //LOGOUT E LGPD

    /**
     * Fazer logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Aceitar termos LGPD
     */
    public function acceptLgpd(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            $user->update(['terms_and_lgpd' => true]);
            Log::info('User accepted LGPD', ['user_id' => $user->id]);
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 401);
    }

    protected function _registerOrLoginUser($data)
    {
        $user = User::where('email', $data->email)->first();

        if (!$user) {
            $user = new User();
            $user->name = $data->name;
            $user->email = $data->email;
            $user->provider_id = $data->id;
            $user->avatar = $data->avatar;
            $user->save();
        }

        Auth::login($user);
    }

}
