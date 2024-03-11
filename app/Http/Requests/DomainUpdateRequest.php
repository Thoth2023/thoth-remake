<?php
/**
 * File: DomainUpdateRequest.php
 * Author: Auri Gabriel
 *
 * Description: This file contains the DomainUpdateRequest,
 * which is responsible for validating the request when updating a domain.
 *
 * Date: 2024-03-09
 *
 * @see Domain, DomainController
 */
namespace App\Http\Requests;

use App\Http\Controllers\Project\Planning\Overall\DomainController;
use Illuminate\Foundation\Http\FormRequest;

class DomainUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'description' => 'required|string',
        ];
    }
}
