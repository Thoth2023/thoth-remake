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

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            // Aqui o Socialite tenta pegar o token do Google
            $googleUser = Socialite::driver('google')->user();

            // Se chegou aqui, o login funcionou normalmente
            $this->_registerOrLoginUser($googleUser);
            session()->regenerate();

            return redirect()->intended($this->redirectTo);

        } catch (\Exception $e) {
            // Log COMPLETO para identificar o problema real
            Log::error('ERRO CRÍTICO NO SOCIALITE', [
                'mensagem' => $e->getMessage(),
                'arquivo'  => $e->getFile(),
                'linha'    => $e->getLine(),
                'trace'    => $e->getTraceAsString(),
                'code'     => $e->getCode(),
                'url_atual' => request()->fullUrl(),
            ]);

            // Opcional: mostra uma mensagem amigável na tela de login
            return redirect('/login')->with('error', __('auth.google_failed'));
        }
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
