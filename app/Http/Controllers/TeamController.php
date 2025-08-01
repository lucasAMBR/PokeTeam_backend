<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TeamService;

use App\Http\Requests\UpdateTeamPokemonsRequest;

class TeamController extends Controller
{
    protected $teamService;

    public function __construct(TeamService $teamService)
    {
        $this->teamService = $teamService;
    }

    public function index(Request $request)
    {
        $userId = $request->user()->id;

        $teams = $this->teamService->getTeamsByUser($userId);

        return response()->json($teams);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'pokemons' => 'sometimes|array',
            'pokemons.*.name' => 'required|string',
            'pokemons.*.image_url' => 'required|url',
            'pokemons.*.types' => 'required|array',
        ]);

        $userId = $request->user()->id;

        $team = $this->teamService->createTeam($validated, $userId);

        return response()->json($team, 201);
    }

    public function updatePokemons(UpdateTeamPokemonsRequest $request, $teamId)
    {
        $userId = $request->user()->id;

        $data = $this->teamService->updatePokemons($teamId, $userId, $request->validated()['pokemons']);

        return response()->json($data);
    }

    public function destroy(Request $request, $teamId)
    {
        $userId = $request->user()->id;

        $this->teamService->deleteTeam($teamId, $userId);

        return response()->json(['message' => 'Equipe deletada com sucesso.']);
    }
}
