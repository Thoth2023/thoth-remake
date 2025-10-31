<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class CompleteInviteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'firstname' => 'required|max:255|min:2',
            'lastname'  => 'required|max:255|min:2',

            // Senha com forte validação igual ao RegisterRequest
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'firstname.required' => __('auth/invite.firstname_required'),
            'lastname.required'  => __('auth/invite.lastname_required'),

            'password.required' => __('auth/invite.password_required'),
            'password.confirmed' => __('auth/invite.password_not_match'),
            'password.min' => __('auth/invite.password_min'),
        ];
    }
}
