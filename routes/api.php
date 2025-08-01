<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TesteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PokemonController;

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
