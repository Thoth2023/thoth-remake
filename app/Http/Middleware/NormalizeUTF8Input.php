<?php

namespace App\Http\Middleware;

use Closure;
use App\Utils\NormalizeUTF8;

class NormalizeUTF8Input
{
    public function handle($request, Closure $next)
    {
        $input = $request->all();
        $normalizedInput = NormalizeUTF8::normalizeArray($input);
        $request->merge($normalizedInput);

        return $next($request);
    }
}
