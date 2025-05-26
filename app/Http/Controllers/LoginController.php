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
     * Construtor para aplicar o middleware de limitação de taxa (throttle).
     */
    public function __construct()
    {
        $this->middleware('throttle:5,1')->only('login');
    }

    /**
     * Exibe a página de login.
     *
     */
    public function show(): View
    {
        return view('auth.login');
    }

    /**
     * Realiza o login do usuário.
     *
     */
    public function login(Request $request)
    {
        // Validação das credenciais
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Verifica as credenciais e autentica o usuário
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();  // Regenera a sessão para evitar sequestro

            $user = Auth::user(); // Obtém o usuário autenticado diretamente

            // Verifica se o IP armazenado na sessão corresponde ao IP atual
            $userIp = session('user_ip');
            $currentIp = $request->ip();

            // Se o IP mudar, desloga o usuário e limpa a sessão
            if ($userIp && $userIp !== $currentIp) {
                Auth::logout();  // Faz logout
                $request->session()->invalidate();  // Invalida a sessão
                return redirect()->route('login')->with('error', 'Sessão expirada devido a mudança de IP.');
            }

            // Armazena o IP na sessão se não estiver já armazenado
            session(['user_ip' => $currentIp]);

            // Verifica se o usuário aceitou os termos e exibe o modal LGPD se necessário
            if (!$user->terms_and_lgpd) {
                $request->session()->flash('show_lgpd_modal', true);
            }

            // Redireciona para a página desejada
            return redirect()->intended('about');
        }

        // Retorna erro se a senha estiver incorreta
        return back()->withErrors([
            'password' => __('auth/login.failed'),
        ]);
    }

    /**
     * Aceita os termos de uso e a LGPD.
     *
     */
    public function acceptLgpd(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            $user->update(['terms_and_lgpd' => true]);
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 401);
    }

    /**
     * Realiza o logout do usuário.
     *
     */
    public function logout(Request $request)
    {
        Auth::logout();  // Realiza o logout do usuário

        $request->session()->invalidate();  // Invalidar a sessão
        $request->session()->regenerateToken();  // Regenera o token CSRF

        return redirect('/');  // Redireciona para a página inicial
    }
}
