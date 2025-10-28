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
            // O erro ocorre nesta linha (comunicação backend)
            $googleUser = Socialite::driver('google')->user();

            // Se esta linha for alcançada, o login está OK
            $this->_registerOrLoginUser($googleUser);
            session()->regenerate();

            return redirect()->intended($this->redirectTo);

        } catch (\Exception $e) {
            // ESTE BLOCO VAI PEGAR A CAUSA REAL
            Log::error('ERRO CRÍTICO NO SOCIALITE: ' . $e->getMessage());
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
