<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ChangePassword extends Controller
{

    protected $user;

    public function __construct()
    {
        Auth::logout();

        $id = intval(request()->id);
        $this->user = User::find($id);
    }

    public function show()
    {
        return view('auth.change-password');
    }

    public function update(Request $request)
    {
        $attributes = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:5'],
            'confirm-password' => ['same:password'],
        ]);

        if ($this->user && $this->user->email === $attributes['email']) {
            // Apenas atribui a nova senha sem `Hash::make`, pois o model já cuida do hashing
            $this->user->password = $attributes['password'];

            if ($this->user->save()) {
                return redirect('login')->with('success', __('auth/change-password.messages.success'));
            } else {
                return back()->with('error', __('auth/change-password.messages.error'));
            }
        } else {
            return back()->with('error', __('auth/change-password.messages.error'));
        }
    }
}


