<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserProfileController extends Controller
{
    // Show the user profile view
    public function show()
    {
        return view('pages.user-profile');
    }

    // Update the user profile
    public function update(Request $request)
    {
        // Validate the request data
        $attributes = $request->validate([
            'username' => ['required','max:255', 'min:2'],
            'firstname' => ['max:100'],
            'lastname' => ['max:100'],
            'email' => ['required', 'email', 'max:255',  Rule::unique('users')->ignore(auth()->user()->id)],
            'address' => ['max:100'],
            'city' => ['max:100'],
            'country' => ['max:100'],
            'postal' => ['max:100'],
            'about' => ['max:255'],
            'intitution' => ['max:255'],
            'lattes_link' => ['max:255'],
        ]);
        // Update the authenticated user's profile with the validated data
        auth()->user()->update([
            'username' => $request->get('username'),
            'firstname' => $request->get('firstname'),
            'lastname' => $request->get('lastname'),
            'email' => $request->get('email') ,
            'address' => $request->get('address'),
            'city' => $request->get('city'),
            'country' => $request->get('country'),
            'postal' => $request->get('postal'),
            'about' => $request->get('about'),
            'institution' => $request->get('institution'),
            'lattes_link' => $request->get('lattes_link'),
        ]);
        // Redirect back to the previous page with a success message
        return back()->with('succes', 'Profile succesfully updated');
    }
}
