<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();

        // Check if a user already exists with the given email
        $existingUser = User::where('email', $googleUser->email)->first();

        if ($existingUser) {
            // Login the existing user
            auth()->login($existingUser, true);
        } else {
            // Create a new user account
            $newUser = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'password' => Hash::make('random_generated_password'), // You can generate a random password here
            ]);

            auth()->login($newUser, true);
        }

        return redirect()->route('home');
    }

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        $facebookUser = Socialite::driver('facebook')->user();

        $existingUser = User::where('email', $facebookUser->email)->first();

        if ($existingUser) {
            auth()->login($existingUser, true);
        } else {
            $newUser = User::create([
                'name' => $facebookUser->name,
                'email' => $facebookUser->email,
                'password' => Hash::make('random_generated_password'),
            ]);

            auth()->login($newUser, true);
        }

        return redirect()->route('home');
    }

    public function redirectToApple()
    {
        return Socialite::driver('apple')->redirect();
    }

    public function handleAppleCallback()
    {
        $appleUser = Socialite::driver('apple')->user();

        $existingUser = User::where('email', $appleUser->email)->first();

        if ($existingUser) {
            auth()->login($existingUser, true);
        } else {
            $newUser = User::create([
                'name' => $appleUser->name,
                'email' => $appleUser->email,
                'password' => Hash::make('random_generated_password'),
            ]);

            auth()->login($newUser, true);
        }

        return redirect()->route('home');
    }
}
