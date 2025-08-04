<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:6', 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome e obrigatório.',
            'name.string' => 'O nome deve ser uma string.',
            'name.max' => 'O nome deve ter no máximo 100 caracteres.',

            'email.required' => 'O e-mail e obrigatório.',
            'email.email' => 'O e-mail informado não e válido.',
            'email.unique' => 'Este e-mail ja esta em uso.',

            'password.required' => 'A senha é obrigatória.',
            'password.min' => 'A senha deve ter no minimo 6 caracteres.',
            'password.confirmed' => 'A confirmação da senha não corresponde.',
        ];
    }
}
