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

        /**
         * ---------------------------------------------------------------
         * BASE CONFIGURATION
         * ---------------------------------------------------------------
         * - CSP (Content-Security-Policy) para produção e local
         * - Libera domínios confiáveis (CDNs, Google, Highcharts, etc.)
         * - Inclui permissões necessárias para Vite e Livewire
         * ---------------------------------------------------------------
         */

        // Diretivas principais de script
        $scriptSrc = [
            "'self'",
            "'unsafe-inline'",   // necessário p/ Livewire, Alpine, Highcharts
            "'unsafe-eval'",     // necessário p/ Highcharts + Livewire dynamic eval
            "data:",
            "blob:",
            // CDNs
            "https://cdn.jsdelivr.net",
            "https://cdnjs.cloudflare.com",
            "https://code.jquery.com",
            "https://buttons.github.io",
            "https://maps.googleapis.com",
            "https://code.highcharts.com",
            // Google OAuth e APIs
            "https://accounts.google.com",
            "https://accounts.google.com/gsi",
            "https://accounts.google.com/gsi/*",
            "https://apis.google.com",
            "https://www.googleapis.com",
            "https://content.googleapis.com",
            "https://ssl.gstatic.com",
            "https://*.googleusercontent.com",
            "https://oauth2.googleapis.com",
        ];

        // Garante consistência entre todas as diretivas de script
        $scriptSrcElem = $scriptSrc;
        $scriptSrcAttr = $scriptSrc;

        // Estilos (Tailwind, Google Fonts, CDNs)
        $styleSrc = [
            "'self'",
            "'unsafe-inline'",
            "https://fonts.googleapis.com",
            "https://cdn.jsdelivr.net",
            "data:",
        ];
        $styleSrcElem = $styleSrc;

        // Fontes
        $fontSrc = [
            "'self'",
            "https://fonts.gstatic.com",
            "https://cdn.jsdelivr.net",
            "data:",
        ];

        // Imagens (suporte p/ avatars, mapas, Google login, etc.)
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
            "https://lh3.googleusercontent.com",
            "https://ssl.gstatic.com",              // ícones e recursos Google
            "https://*.googleusercontent.com",      // avatares e logos
            "https://oauth2.googleapis.com",
        ];

        // Iframes e frames externos
        $frameSrc = [
            "'self'",
            "https://accounts.google.com",
            "https://accounts.google.com/gsi",
            "https://accounts.google.com/gsi/*",
            "https://apis.google.com",
            "https://content.googleapis.com",
            "https://ssl.gstatic.com",
            "https://*.googleusercontent.com",
            "https://oauth2.googleapis.com",
        ];

        // Conexões (Livewire, APIs externas, etc.)
        $connectSrc = [
            "'self'",
            "https://*",
            "wss://*",
            // Google
            "https://accounts.google.com",
            "https://apis.google.com",
            "https://content.googleapis.com",
            "https://*.gstatic.com",
            "https://*.googleusercontent.com",
            "https://oauth2.googleapis.com",
        ];

        /**
         * ---------------------------------------------------------------
         * LOCAL ENVIRONMENT RELAXATION
         * ---------------------------------------------------------------
         * Permite conexão com o Vite dev server e scripts inline
         * ---------------------------------------------------------------
         */
        if ($isLocal) {
            $viteHost = config('app.vite_host', '127.0.0.1:5173');
            $viteHttp = "http://{$viteHost}";
            $viteWs   = "ws://{$viteHost}";

            // Libera Vite (JS, CSS, HMR)
            foreach ([$viteHttp, $viteWs] as $vite) {
                $scriptSrc[]     = $vite;
                $scriptSrcElem[] = $vite;
                $styleSrc[]      = $vite;
                $styleSrcElem[]  = $vite;
                $connectSrc[]    = $vite;
            }

            // Reforça inline/eval (essenciais pro modo dev)
            $scriptSrc[]     = "'unsafe-inline'";
            $scriptSrc[]     = "'unsafe-eval'";
            $scriptSrcElem[] = "'unsafe-inline'";
            $scriptSrcElem[] = "'unsafe-eval'";
        }

        /**
         * ---------------------------------------------------------------
         * FINAL POLICY BUILD
         * ---------------------------------------------------------------
         */
        $directives = [
            "default-src 'self'",
            'script-src '      . implode(' ', array_unique($scriptSrc)),
            'script-src-elem ' . implode(' ', array_unique($scriptSrcElem)),
            'script-src-attr ' . implode(' ', array_unique($scriptSrcAttr)),
            'style-src '       . implode(' ', array_unique($styleSrc)),
            'style-src-elem '  . implode(' ', array_unique($styleSrcElem)),
            'font-src '        . implode(' ', array_unique($fontSrc)),
            'img-src '         . implode(' ', array_unique($imgSrc)),
            'connect-src '     . implode(' ', array_unique($connectSrc)),
            'frame-src '       . implode(' ', array_unique($frameSrc)),
            "object-src 'none'",
            "base-uri 'self'",
            "frame-ancestors 'self'",
            // Para reportar violações (opcional):
            // "report-uri /csp-report",
        ];

        $policy = implode('; ', $directives) . ';';
        $response->headers->set('Content-Security-Policy', $policy);

        return $response;
    }
}
