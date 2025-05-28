<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            // 'g-recaptcha-response' => 'required', // Campo do reCAPTCHA desativado
        ];
    }

    public function messages(): array
    {
        return [
            // 'g-recaptcha-response.required' => 'A verificação de reCAPTCHA é necessária.', // Mensagem desativada
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Validação do reCAPTCHA desativada
            // if (!$this->validateRecaptcha()) {
            //     $validator->errors()->add('g-recaptcha-response', 'Falha na verificação do reCAPTCHA. Tente novamente.');
            // }
        });
    }

    // Método de validação do reCAPTCHA desativado
    // private function validateRecaptcha(): bool
    // {
    //     $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
    //         'secret' => config('services.recaptcha.secret_key'),
    //         'response' => $this->input('g-recaptcha-response'),
    //         'remoteip' => $this->ip(),
    //     ]);

    //     $result = $response->json();

    //     if (!($result['success'] ?? false) || ($result['score'] ?? 0) < 0.3) {
    //         Log::error('reCAPTCHA falhou', ['response' => $result]); // Log de erro detalhado
    //         return false;
    //     }

    //     return true;
    // }
}
