<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FetchReferencesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // ou usar auth()->check() se necessário
    }

    public function rules(): array
    {
        return [
            'q' => ['required', 'string', 'min:4'],
        ];
    }

    public function messages(): array
    {
        return [
            'q.required' => __('snowballing.validation.required'),
        ];
    }
}
