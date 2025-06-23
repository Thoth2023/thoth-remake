<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidBibFile implements Rule
{
    public function passes($attribute, $value)
    {
        if (!$value) {
            return false;
        }

        $mimeType = $value->getMimeType();
        $extension = $value->getClientOriginalExtension();

        // Verifica se é um arquivo de texto e tem extensão .bib ou .csv
        return (str_starts_with($mimeType, 'text/') || $mimeType === 'application/csv') &&
               in_array($extension, ['bib', 'csv', 'CSV']);
    }

    public function message()
    {
        return 'Apenas arquivos .bib e .csv são permitidos.';
    }
}
