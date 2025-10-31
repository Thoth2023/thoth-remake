<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\CompleteInviteRequest;

class InviteController extends Controller
{
    public function form($token)
    {
        $invitation = DB::table('members')->where('invitation_token', $token)->first();

        if (!$invitation) {
            return redirect('/login')->with('error', 'Invitation expired or invalid.');
        }

        return view('auth.complete-invite', [
            'token' => $token
        ]);
    }

    public function save(CompleteInviteRequest $request, $token)
    {
        $request->validate([
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'password' => 'required|string|min:6|confirmed'
        ]);

        $invitation = DB::table('members')->where('invitation_token', $token)->first();

        if (!$invitation) {
            return redirect('/login')->with('error', 'Invalid or expired invitation.');
        }

        $user = User::find($invitation->id_user);
        $user->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'password' => Hash::make($request->password),
            'invited' => false,
        ]);

        DB::table('members')
            ->where('invitation_token', $token)
            ->update([
                'status' => 'accepted',
                'invitation_token' => null
            ]);

        Auth::login($user);

        return redirect('/projects')->with('success', 'Welcome to the project!');
    }
}
