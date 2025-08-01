<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class PokemonService
{
    public function getPokemonListByGeneration(int $generation): array
    {
        $cacheKey = "generation_{$generation}";
        $ttlMinutes = 1440;

        return Cache::remember($cacheKey, $ttlMinutes, function () use ($generation) {
            $response = Http::get("https://pokeapi.co/api/v2/generation/{$generation}");

            if (!$response->successful()) {
                throw new \Exception("Erro ao buscar dados da PokeAPI");
            }

            $speciesList = $response->json()['pokemon_species'];
            $names = collect($speciesList)->pluck('name')->all();

            $responses = Http::pool(fn ($pool) =>
                array_map(fn ($name) =>
                    $pool->get("https://pokeapi.co/api/v2/pokemon/{$name}"), $names
                )
            );

            $pokemonList = [];

            foreach ($responses as $index => $res) {
                $name = $names[$index];
                $species = $speciesList[$index];

                $cached = Cache::get("pokemon_details_{$name}");

                if ($cached) {
                    $data = $cached;
                } elseif ($res->successful()) {
                    $data = $res->json();
                    Cache::put("pokemon_details_{$name}", $data, 1440);
                } else {
                    continue;
                }

                $types = array_map(fn($t) => $t['type']['name'], $data['types'] ?? []);

                preg_match('/\/pokemon-species\/(\d+)\//', $species['url'], $matches);
                $id = $matches[1] ?? null;

                if ($id) {
                    $pokemonList[] = [
                        'id' => (int) $id,
                        'name' => $name,
                        'sprite' => "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/{$id}.png",
                        'types' => $types,
                    ];
                }
            }

            usort($pokemonList, fn ($a, $b) => $a['id'] <=> $b['id']);

            return $pokemonList;
        });
    }
}
