<?php
namespace App\Repositories;

use App\Models\Team;
use App\Models\Pokemon;

class TeamRepository
{
    public function getTeamsByUserId(int $userId)
    {
        return Team::with('pokemons')
            ->where('user_id', $userId)
            ->get();
    }

    public function createTeam(array $data, int $userId): Team
    {
        return Team::create([
            'name' => $data['name'],
            'user_id' => $userId,
        ]);
    }

    public function findByIdAndUser(int $id, int $userId): Team
    {
        return Team::where('id', $id)
            ->where('user_id', $userId)
            ->firstOrFail();
    }

    public function deleteAllPokemonsFromTeam(Team $team): void
    {
        $team->pokemons()->delete();
    }

    public function addPokemonsToTeam(Team $team, array $pokemons): void
    {
        foreach ($pokemons as $pokemon) {
            $team->pokemons()->create([
                'name' => $pokemon['name'],
                'image_url' => $pokemon['image_url'],
                'types' => json_encode($pokemon['types']),
            ]);
        }
    }

    // TeamRepository.php

    public function deleteTeam(Team $team): void
    {
        // Garante que pokémons relacionados sejam deletados (se não estiver usando onDelete('cascade'))
        $team->pokemons()->delete();

        $team->delete();
    }

}
