<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(RegisterRequest $request)
    {
        $attributes = $request->validated();

        $user = User::create($attributes);
        auth()->login($user);

        return redirect('/projects');
    }
}
