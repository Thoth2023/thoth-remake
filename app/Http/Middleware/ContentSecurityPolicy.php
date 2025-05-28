<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ContentSecurityPolicy
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $response->headers->set(
            'Content-Security-Policy',
            "default-src 'self'; 
    script-src 'self' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://code.jquery.com;
    style-src 'self' https://cdn.jsdelivr.net https://fonts.googleapis.com;
    font-src 'self' https://fonts.gstatic.com data:;
    img-src 'self' data:;
    connect-src 'self';
    object-src 'none';"
        );


        return $response;
    }
}
