<?php
/**
 * File: LanguageUpdateRequest.php
 * Author: Auri Gabriel
 *
 * Description: This file contains the LanguageUpdateRequest class.
 * This class is responsible for validating the request to update a language.
 *
 * Date: 2024-03-09
 *
 * @see Related Class/Method
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LanguageUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id_project' => 'required|string',
            'id_language' => 'required|string',
        ];
    }
}
