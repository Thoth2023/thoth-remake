<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Http;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'firstname' => 'required|max:255|min:2',
            'lastname' => 'required|max:255|min:2',
            'institution' => 'required|max:255|min:2',
            'email' => 'required|email|max:255|unique:users,email',
            'username' => 'required|max:255|min:2',
            'password' => 'required|min:5|max:255',
            'terms' => 'required',
            'g-recaptcha-response' => 'required', // Campo do reCAPTCHA
        ];
    }

    public function messages(): array
    {
        return [
            'g-recaptcha-response.required' => 'A verificação de reCAPTCHA é necessária.',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!$this->validateRecaptcha()) {
                $validator->errors()->add('g-recaptcha-response', 'Falha na verificação do reCAPTCHA. Tente novamente.');
            }
        });
    }

    private function validateRecaptcha(): bool
    {
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret_key'),
            'response' => $this->input('g-recaptcha-response'),
            'remoteip' => $this->ip(), // Para obter o IP do usuário
        ]);

        return $response->json('success') && $response->json('score') >= 0.5; // Exige uma pontuação mínima de 0.5
    }
}
