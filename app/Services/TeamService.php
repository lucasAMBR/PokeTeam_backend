<?php
namespace App\Services;

use App\Models\Team;
use App\Repositories\TeamRepository;

class TeamService
{
    protected $repository;

    public function __construct(TeamRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createTeam(array $data, int $userId): Team
    {
        $team = $this->repository->createTeam($data, $userId);

        if (!empty($data['pokemons'])) {
            $this->repository->addPokemonsToTeam($team, $data['pokemons']);
        }

        return $team->load('pokemons');
    }

    public function updatePokemons(int $teamId, int $userId, array $pokemons): array
    {
        $team = $this->repository->findByIdAndUser($teamId, $userId);

        $this->repository->deleteAllPokemonsFromTeam($team);
        $this->repository->addPokemonsToTeam($team, $pokemons);

        return [
            'message' => 'Pokémons atualizados com sucesso.',
            'team_id' => $team->id,
            'pokemons' => $team->pokemons
        ];
}

}
