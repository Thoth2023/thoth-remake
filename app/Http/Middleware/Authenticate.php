<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        Log::info('Authenticate middleware - checking', [
            'path' => $request->path(),
            'authenticated' => auth()->check(),
            'user_id' => auth()->id(),
            'session_id' => session()->getId(),
        ]);

        if ($request->expectsJson()) {
            return null;
        }

        Log::info('Authenticate middleware - redirecting to login', [
            'path' => $request->path(),
        ]);

        return route('login');
    }
}
