<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeamRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Garante que o usuário está autenticado
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'pokemons' => 'sometimes|array|max:6',
            'pokemons.*.name' => 'required|string',
            'pokemons.*.image_url' => 'required|url',
            'pokemons.*.types' => 'required|array',
        ];
    }
}

