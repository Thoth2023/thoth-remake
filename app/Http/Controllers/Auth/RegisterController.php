<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Http\Requests\RegisterRequest; // Certifique-se de que RegisterRequest exista ou crie um novo Validator se não houver
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    // Método para exibir o formulário de registro
    public function create()
    {
        return view('auth.register');
    }

    // Método para registro com formulário básico
    public function store(RegisterRequest $request)
    {
        $attributes = $request->validated();

        $user = User::create($attributes);
        auth()->login($user);

        // Define uma sessão para mostrar o modal LGPD após o registro
        $request->session()->flash('show_lgpd_modal', true);

        return redirect('/projects');
    }

    // Validação para registro de formulário básico, se necessário
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['same:password'],
        ]);
    }

    // Registro e login via Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Procurar o usuário pelo e-mail
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // Se o usuário já estiver registrado, faça o login e redirecione para /about
                Auth::login($user);

                // Verificar se o usuário já aceitou os termos e exibir modal se não aceitou
                if (!$user->terms_and_lgpd) {
                    // Define uma sessão para mostrar o modal LGPD após o login
                    $request->session()->flash('show_lgpd_modal', true);
                }

                return redirect()->route('about');
            } else {
                // Se o usuário não estiver registrado, crie o cadastro e redirecione para /projects
                $nameParts = explode(' ', $googleUser->name);
                $firstname = $nameParts[0];
                $lastname = isset($nameParts[1]) ? $nameParts[1] : '';

                $username = strtolower($firstname . $lastname);

                $newUser = User::create([
                    'username' => $username,
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'email' => $googleUser->getEmail(),
                    'password' => Hash::make('random_generated_password'), // Gere uma senha aleatória
                    'country' => $googleUser->user['locale'] ?? null,
                ]);

                Auth::login($newUser);
                // Define uma sessão para mostrar o modal LGPD após o login
                $request->session()->flash('show_lgpd_modal', true);
                return redirect('/projects');
            }
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors('Erro ao autenticar com o Google.');
        }
    }


    // Registro e login via Facebook
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        $facebookUser = Socialite::driver('facebook')->stateless()->user();
        $this->_registerOrLoginUser($facebookUser);
        return redirect($this->redirectTo);
    }

    // Registro e login via Apple
    public function redirectToApple()
    {
        return Socialite::driver('apple')->redirect();
    }

    public function handleAppleCallback()
    {
        $appleUser = Socialite::driver('apple')->stateless()->user();
        $this->_registerOrLoginUser($appleUser);
        return redirect($this->redirectTo);
    }

    // Método privado para registro/login de usuário via autenticação social
    protected function _registerOrLoginUser($socialUser)
    {
        $existingUser = User::where('email', $socialUser->email)->first();

        if ($existingUser) {
            Auth::login($existingUser, true);
        } else {
            // Extrair o nome completo do usuário e separar em firstname e lastname
            $nameParts = explode(' ', $socialUser->name);
            $firstname = $nameParts[0];
            $lastname = isset($nameParts[1]) ? $nameParts[1] : '';

            // Criar o username concatenando firstname e lastname
            $username = strtolower($firstname . $lastname);

            // Capturar o país, se estiver disponível
            $country = $socialUser->user['locale'] ?? null; // Locale às vezes fornece o país/idioma

            // Criar um novo usuário com os dados recebidos
            $newUser = User::create([
                'username' => $username,
                'firstname' => $firstname,
                'lastname' => $lastname,
                'email' => $socialUser->email,
                'password' => Hash::make('random_generated_password'), // Gere uma senha aleatória
                'country' => $country,
            ]);

            Auth::login($newUser, true);
        }
    }
}
