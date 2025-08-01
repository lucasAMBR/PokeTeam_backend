<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\PokemonService;

class PokemonController extends Controller
{
    protected PokemonService $pokemonService;

    public function __construct(PokemonService $pokemonService)
    {
        $this->pokemonService = $pokemonService;
    }

    public function getPokemonByGeneration($generation)
    {
        try
        {
            $data = $this->pokemonService->getPokemonListByGeneration($generation);
            return response()->json($data);
        }catch(\Exception $e){
            return response()->json(['erro' => $e->getMessage()], 500);
        }
    }
}
