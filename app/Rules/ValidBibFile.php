<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidBibFile implements Rule
{
    public function passes($attribute, $value)
    {
        $extension = $value->getClientOriginalExtension();
        return in_array($extension, ['bib', 'csv', 'txt']);
    }

    public function message()
    {
        return 'The file must be a type of: bib, csv, txt.';
    }
}
