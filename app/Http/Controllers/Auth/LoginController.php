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
            // Remova o ->stateless() daqui
            $googleUser = Socialite::driver('google')->user();

            // Use a variável $googleUser para evitar confusão com o model $user
            $this->_registerOrLoginUser($googleUser);

            // Redireciona para a home ou para a página que o usuário tentava acessar
            return redirect()->intended($this->redirectTo);

        } catch (\Exception $e) {
            // É uma boa prática adicionar um bloco try-catch para depurar erros
            // que podem vir do Google (ex: permissão negada pelo usuário)
            Log::error('Erro no callback do Google: ' . $e->getMessage());
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
