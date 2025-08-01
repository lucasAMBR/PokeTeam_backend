<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTeamPokemonsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'pokemons' => ['required', 'array', 'max:5'],
            'pokemons.*.name' => ['required', 'string'],
            'pokemons.*.image_url' => ['required', 'url'],
            'pokemons.*.types' => ['required', 'array', 'min:1'],
            'pokemons.*.types.*' => ['string']
        ];
    }

    public function messages()
    {
        return [
            'pokemons.required' => 'A lista de pokémons é obrigatória.',
            'pokemons.array' => 'A lista de pokémons deve ser um array.',
            'pokemons.max' => 'Cada equipe pode ter no máximo 5 pokémons.',
            'pokemons.*.name.required' => 'O nome do pokémon é obrigatório.',
            'pokemons.*.image_url.required' => 'A URL da imagem é obrigatória.',
            'pokemons.*.image_url.url' => 'A URL da imagem deve ser válida.',
            'pokemons.*.types.required' => 'Os tipos do pokémon são obrigatórios.',
            'pokemons.*.types.array' => 'Os tipos devem estar em formato de array.',
        ];
    }
}
