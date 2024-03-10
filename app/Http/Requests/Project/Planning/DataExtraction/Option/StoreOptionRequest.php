<?php

namespace App\Http\Requests\Project\Planning\DataExtraction\Option;

use Illuminate\Foundation\Http\FormRequest;

class StoreOptionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Adjust authorization logic based on your requirements
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id_de' => 'required|string',
            'description' => 'required|string',
        ];
    }
}
