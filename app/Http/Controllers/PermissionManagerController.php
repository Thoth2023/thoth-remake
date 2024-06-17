<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;

class PermissionManagerController extends Controller
{
    public function index()
    {
        $users = User::with('profile')->get();
        return view('pages.permissions-manager', compact('users'));
    }

    public function create()
    {
        return view('permission.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        Profile::create($request->all());

        return redirect()->route('permissions.index')->with('success', 'Permission created successfully.');
    }

    public function edit(Profile $profile)
    {
        return view('permissions.edit', compact('profile'));
    }

    public function update(Request $request, Profile $profile)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        $profile->update($request->all());

        return redirect()->route('permissions.index')->with('success', 'Permission updated successfully.');
    }

    public function destroy(Profile $profile)
    {
        $profile->delete();

        return redirect()->route('permissions.index')->with('success', 'Permission deleted successfully.');
    }
}
