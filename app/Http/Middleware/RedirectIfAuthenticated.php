<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        Log::info('RedirectIfAuthenticated::handle - checando rota', [
            'path' => $request->path(),
            'method' => $request->method(),
        ]);

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                Log::info('RedirectIfAuthenticated - usuário autenticado, redirecionando');
                return redirect(RouteServiceProvider::HOME);
            }
        }

        Log::info('RedirectIfAuthenticated - passando para próximo middleware');
        return $next($request);
    }
}
