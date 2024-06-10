<?php

namespace App\Http\Controllers;

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
     * @return Renderable
     */
    public function show()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
    
    $user = User::where('email', $request->email)->first();
    
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();


            return redirect()->intended('about');
        } else  { return back()->withErrors([
            'password' => __('auth.failed'),
        ]);
    }
    
        return back()->withErrors([
            
        ]);
        

    }

    public function logout(Request $request)
    {
        $user_email = Auth::user()->email;
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $request->session()->put('user_email',$user_email);

        return redirect('/');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->stateless()->user();
        } catch (\Exception $e) {
            return redirect('/login');
        }
    
        $existingUser = User::where('email', $user->getEmail())->first();
    
        if ($existingUser) {
            Auth::login($existingUser, true);
        } else {
            $newUser = new User;
            $newUser->name = $user->getName();
            $newUser->email = $user->getEmail();
            $newUser->google_id = $user->getId();
            $newUser->avatar = $user->getAvatar();
            $newUser->save();
    
            Auth::login($newUser, true);
        }
    
        return redirect()->intended('/about');
    }
    

}
