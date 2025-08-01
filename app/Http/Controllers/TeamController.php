<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TeamService;

use App\Http\Requests\UpdateTeamPokemonsRequest;
use App\Http\Requests\StoreTeamRequest;

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

    public function store(StoreTeamRequest $request)
    {
        $userId = $request->user()->id;

        $team = $this->teamService->createTeam($request->validated(), $userId);

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
