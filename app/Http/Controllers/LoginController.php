<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Password;

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


        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            $request->session()->regenerate();


            return redirect()->intended('about');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
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
}
