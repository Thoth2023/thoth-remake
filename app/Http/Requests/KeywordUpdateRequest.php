<?php

/**
 * File: KeywordUpdateRequest.php
 * Author: Auri Gabriel
 *
 * Description: This
 *
 * Date: 2024-03-09
 *
 * @see KeywordControlle
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KeywordUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'description' => 'required|string',
        ];
    }
}

