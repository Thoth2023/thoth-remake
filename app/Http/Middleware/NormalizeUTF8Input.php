<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class NormalizeUTF8Input
{
    public function handle($request, Closure $next)
    {
        try {
            $input = $request->all();

            // Log the problematic input for debugging
            Log::info('Request input before normalization', [
                'input' => $this->sanitizeForLogging($input)
            ]);

            $normalizedInput = $this->normalizeArray($input);
            $request->merge($normalizedInput);

            return $next($request);
        } catch (\Exception $e) {
            // Log the exception
            Log::error('UTF-8 normalization error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // For critical paths, you might want to continue despite errors
            // Otherwise, re-throw the exception
            return $next($request);
        }
    }

    // Sanitize data for logging to prevent log corruption
    protected function sanitizeForLogging($data)
    {
        if (is_array($data)) {
            $result = [];
            foreach ($data as $key => $value) {
                $result[$key] = $this->sanitizeForLogging($value);
            }
            return $result;
        }

        if (is_string($data)) {
            // Convert to hex representation for debugging
            if (!mb_check_encoding($data, 'UTF-8')) {
                return '[INVALID UTF-8: ' . bin2hex($data) . ']';
            }
        }

        return $data;
    }

    protected function normalizeArray($input)
    {
        if (is_array($input)) {
            $normalized = [];
            foreach ($input as $key => $value) {
                $normalized[$key] = $this->normalizeArray($value);
            }
            return $normalized;
        }

        if (is_string($input)) {
            return $this->normalize($input);
        }

        return $input;
    }

    protected function normalize($string)
    {
        // Handle empty strings
        if ($string === '') {
            return '';
        }

        // Fix invalid UTF-8 sequences
        $fixed = @iconv('UTF-8', 'UTF-8//IGNORE', $string);

        // If iconv failed completely, try a more aggressive approach
        if ($fixed === false) {
            // Remove all non-printable characters
            $fixed = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $string);

            // If that still fails, encode as base64 as last resort
            if ($fixed === null) {
                Log::warning('Found unfixable string, encoding as base64', [
                    'original' => bin2hex($string)
                ]);
                return base64_encode($string);
            }
        }

        return $fixed;
    }
}
