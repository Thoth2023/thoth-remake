<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ContentSecurityPolicy
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $isLocal = app()->environment('local');

        // Bases
        $scriptSrc = [
            "'self'",
            "'unsafe-inline'",
            "'unsafe-eval'",
            "data:",
            "blob:",
            "https://cdn.jsdelivr.net",
            "https://cdnjs.cloudflare.com",
            "https://code.jquery.com",
            "https://buttons.github.io",
            "https://maps.googleapis.com",
            "https://code.highcharts.com",
        ];
        $scriptSrcElem = $scriptSrc; // igual
        $scriptSrcAttr = ["'self'", "'unsafe-inline'"];

        $styleSrc = [
            "'self'",
            "'unsafe-inline'",
            "https://fonts.googleapis.com",
            "https://cdn.jsdelivr.net",
            "data:",
        ];
        $styleSrcElem = [
            "'self'",
            "'unsafe-inline'",
            "https://fonts.googleapis.com",
            "https://cdn.jsdelivr.net",
        ];

        $fontSrc = [
            "'self'",
            "https://fonts.gstatic.com",
            "https://cdn.jsdelivr.net",
            "data:",
        ];

        $imgSrc = [
            "'self'",
            "data:",
            "blob:",
            "https://maps.gstatic.com",
            "https://maps.googleapis.com",
            "https://cdn.jsdelivr.net",
            "https://gravatar.com",
            "https://www.gravatar.com",
            "https://secure.gravatar.com",
        ];

        $connectSrc = [
            "'self'",
            "https://*",
        ];

        // ⚙️ Relaxa para Vite (somente LOCAL)
        if ($isLocal) {
            // pode sobrescrever via config('app.vite_host') se quiser
            $viteHost = config('app.vite_host', '127.0.0.1:5173');
            $viteHttp = "http://{$viteHost}";
            $viteWs   = "ws://{$viteHost}";

            $scriptSrc[]     = $viteHttp;
            $scriptSrcElem[] = $viteHttp;

            $styleSrc[]      = $viteHttp;
            $styleSrcElem[]  = $viteHttp;

            $connectSrc[]    = $viteHttp;
            $connectSrc[]    = $viteWs;
        }

        // Monta diretivas
        $directives = [
            "default-src 'self'",
            'script-src '      . implode(' ', $scriptSrc),
            'script-src-elem ' . implode(' ', $scriptSrcElem),
            'script-src-attr ' . implode(' ', $scriptSrcAttr),
            'style-src '       . implode(' ', $styleSrc),
            'style-src-elem '  . implode(' ', $styleSrcElem),
            'font-src '        . implode(' ', $fontSrc),
            'img-src '         . implode(' ', $imgSrc),
            'connect-src '     . implode(' ', $connectSrc),
            "object-src 'none'",
            "base-uri 'self'",
            "frame-ancestors 'self'",
            // Se quiser capturar violações, descomente a rota abaixo e esta linha:
            // "report-uri /csp-report",
        ];

        $policy = implode('; ', $directives) . ';';

        // Produção: aplica CSP
        // Local: aplica CSP já com Vite permitido
        $response->headers->set('Content-Security-Policy', $policy);

        return $response;
    }
}
