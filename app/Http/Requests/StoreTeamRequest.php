<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeamRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'pokemons' => ['sometimes', 'array', 'max:6'],
            'pokemons.*.name' => ['required', 'string'],
            'pokemons.*.image_url' => ['required', 'url'],
            'pokemons.*.types' => ['required', 'array', 'min:1'],
            'pokemons.*.types.*' => ['string'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome do time é obrigatório.',
            'name.string' => 'O nome do time deve ser uma string.',
            'name.max' => 'O nome do time deve ter no máximo 255 caracteres.',

            'pokemons.array' => 'Os pokémons devem estar em formato de array.',
            'pokemons.max' => 'O time pode ter no máximo 6 pokémons.',

            'pokemons.*.name.required' => 'O nome do pokémon é obrigatório.',
            'pokemons.*.name.string' => 'O nome do pokémon deve ser uma string.',

            'pokemons.*.image_url.required' => 'A URL da imagem do pokémon é obrigatória.',
            'pokemons.*.image_url.url' => 'A URL da imagem do pokémon deve ser válida.',

            'pokemons.*.types.required' => 'Os tipos do pokémon são obrigatórios.',
            'pokemons.*.types.array' => 'Os tipos do pokémon devem estar em formato de array.',
            'pokemons.*.types.min' => 'Cada pokémon deve ter pelo menos um tipo.',
            'pokemons.*.types.*.string' => 'Cada tipo deve ser uma string.',
        ];
    }
}
