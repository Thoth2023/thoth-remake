<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class ProjectAddMemberRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'email_member' => 'required|email|exists:users,email',
            'level_member' => 'required|integer|between:2,4',
        ];
    }

    public function messages(): array
    {
        return [
            'email_member.required' => 'Email cannot be empty!',
            'email_member.email' => 'Email has to be valid!',
            'email_member.exists:users,email' => 'Email entered does not exist!',
            'level_member.required' => 'Level cannot be empty!',
        ];
    }
}
