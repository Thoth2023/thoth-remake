<?php
namespace App\Http\Middleware;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use Illuminate\Support\Facades\Log;

class VerifyCsrfToken extends Middleware
{
    protected $except = [
        'auth/google/callback',
        'auth/facebook/callback',
        'auth/apple/callback',
    ];

    public function handle($request, $next)
    {
        $path = $request->path();
        $inExcept = in_array($path, $this->except);

        Log::info('VerifyCsrfToken::handle - DEBUG', [
            'path' => $path,
            'path_length' => strlen($path),
            'path_bytes' => bin2hex($path), // Ver bytes para encontrar caracteres ocultos
            'in_except' => $inExcept,
            'except_array' => $this->except,
        ]);

        if ($inExcept) {
            Log::info('VerifyCsrfToken - PASSOU NA EXCEÇÃO, pulando verificação');
            return $next($request);
        }

        try {
            $response = parent::handle($request, $next);
            Log::info('VerifyCsrfToken::handle - passou com sucesso');
            return $response;
        } catch (\Exception $e) {
            Log::error('VerifyCsrfToken::handle - ERRO CSRF', [
                'error' => $e->getMessage(),
                'path' => $request->path(),
            ]);
            throw $e;
        }
    }
}
