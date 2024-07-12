<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;

class UserManagerController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('pages.user-management', compact('users'));
    }

    public function edit(User $user)
    {
        $roles = [
            'SUPER_USER' => __('pages/user-manager.Administrator'),
            'USER' => __('pages/user-manager.Viewer'),
            'RESEARCHER' => __('pages/user-manager.Researcher'),
            'REVISER' => __('pages/user-manager.Reviser'),
        ];
        return view('pages.user-edit', compact('user', 'roles'));
    }

    public function create()
    {
        return view('pages.user-create');
    }

    public function deactivate(User $user)
    {
        if($user->active == true){
            $user->active = false;
            $user->save();

            return redirect()->route('user-manager')->with('success', __('pages/user-manager.deactivated'));
        } else {
            $user->active = true;
            $user->save();

            return redirect()->route('user-manager')->with('success', __('pages/user-manager.activated'));
        }
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'username' => 'required|string|max:255|min:2',
            'firstname' => 'nullable|string|max:255',
            'lastname' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'institution' => 'nullable|string|max:255',
            'function' => 'required|string',
        ]);

        $rolesMapping = [
            __('pages/user-manager.Administrator') => 'SUPER_USER',
            __('pages/user-manager.Viewer') => 'USER',
            __('pages/user-manager.Researcher') => 'RESEARCHER',
            __('pages/user-manager.Reviser') => 'REVISER',
        ];

        $role = $request->input('function');
        $role = $rolesMapping[$role] ?? 'USER';        

        $user->update([
            'username' => $request->username,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'occupation' => $request->occupation,
            'email' => $request->get('email') ,
            'institution' => $request->institution,
            'role' => $role,
        ]);

        return redirect()->route('user-manager')->with('success', __('pages/user-management.updated'));
    }

    public function store()
    {
        $attributes = request()->validate([
            'username' => 'required|max:255|min:2',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:5|max:255',
        ]);
        $user = User::create($attributes);

        return redirect()->route('user-manager')->with('success', __('pages/user-management.created'));
    }
}