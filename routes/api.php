<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TesteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PokemonController;
use App\Http\Controllers\TeamController;

Route::get('/teste', [TesteController::class, 'index']);

//Teste de rota autenticada
Route::middleware('auth:sanctum')->get('/perfil', function (Request $request) {
    return response()->json([
        'usuario' => $request->user()
    ]);
});

//Rotas para autenticação do usuario
Route::post('/users', [UserController::class, 'store']);
Route::post('/login', [AuthController::class, 'login']);

//Rota para buscar lista de pokemons
Route::get('/pokemons/geracao/{id}', [PokemonController::class, 'getPokemonByGeneration']);

//Criação de equipe (se pokemons forem enviados eles jão sao adicionados automaticamente)
Route::middleware('auth:sanctum')->post('/teams', [TeamController::class, 'store']);
// Se a equipe estiver vazia adiciona pokemons, se estiver cheia substitui os pokemons dela pelos novos
Route::middleware('auth:sanctum')->put('/teams/{team}/pokemons', [TeamController::class, 'updatePokemons']);