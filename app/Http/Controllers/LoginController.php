<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Anhskohbo\NoCaptcha\NoCaptcha;

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


        if (Session::get('show_captcha')) {
            $validator = Validator::make($request->all(), [
                'g-recaptcha-response' => 'required|captcha',
            ]);

            if ($validator->fails()) {
                return back()->withErrors(['captcha' => 'Por favor, confirme que você não é um robô.']);
            }
        }

        if (Auth::attempt($credentials)) {
            Session::forget('login_attempts');
            Session::forget('show_captcha');
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        $attempts = Session::get('login_attempts', 0) + 1;
        Session::put('login_attempts', $attempts);

        if ($attempts >= 3) {
            Session::put('show_captcha', true);
        }




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

            // Verificar se o usuário já aceitou os termos e exibir modal se não aceitou
            if (!$user->terms_and_lgpd) {
                // Define uma sessão para mostrar o modal LGPD após o login
                $request->session()->flash('show_lgpd_modal', true);
            }
            return redirect()->intended('about');
        }

        // Retorna erro se a senha estiver incorreta
        return back()->withErrors([
            'password' => __('auth/login.failed'),
        ]);
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
