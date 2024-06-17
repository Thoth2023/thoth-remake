<?php

namespace App\Http\Controllers;

// use App\Http\Requests\RegisterRequest;
use App\Models\User;

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store()
    {
        $attributes = request()->validate([
            'firstname' => 'required|max:255|min:2',
            'lastname' => 'required|max:255|min:2',
            'institution' => 'required|max:255|min:2',
            'email' => 'required|email|max:255|unique:users,email',
            'username' => 'required|max:255|min:2',
            'password' => 'required|min:5|max:255',
            'terms' => 'required'
        ]);
        $user = User::create($attributes);
        auth()->login($user);

        return redirect('/projects');
    }
}
