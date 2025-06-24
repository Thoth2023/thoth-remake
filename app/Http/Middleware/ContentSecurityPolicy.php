<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ContentSecurityPolicy
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $policy = implode(' ', [
            "default-src 'self';",

            // Scripts externos permitidos (incluindo Highcharts)
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' " .
            "https://cdn.jsdelivr.net " .
            "https://cdnjs.cloudflare.com " .
            "https://code.jquery.com " .
            "https://buttons.github.io " .
            "https://maps.googleapis.com " .
            "https://code.highcharts.com;",

            // Mesma política para <script src="...">
            "script-src-elem 'self' 'unsafe-inline' 'unsafe-eval' " .
            "https://cdn.jsdelivr.net " .
            "https://cdnjs.cloudflare.com " .
            "https://code.jquery.com " .
            "https://buttons.github.io " .
            "https://maps.googleapis.com " .
            "https://code.highcharts.com;",

            // Permitir atributos inline como onclick=""
            "script-src-attr 'self' 'unsafe-inline';",

            // Estilos e fontes
            "style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://fonts.googleapis.com;",
            "font-src 'self' https://fonts.gstatic.com data:;",

            // Imagens e conexões
            "img-src 'self' data: https://maps.gstatic.com;",
            "connect-src 'self';",
            "object-src 'none';",
        ]);

        $response->headers->set('Content-Security-Policy', $policy);

        return $response;
    }
}
