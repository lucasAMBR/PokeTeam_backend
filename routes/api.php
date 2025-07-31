<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TesteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/teste', [TesteController::class, 'index']);

//Registra um usuario
Route::post('/users', [UserController::class, 'store']);
//Login do usuario
Route::post('/login', [AuthController::class, 'login']);

//Teste de rota autenticada
Route::middleware('auth:sanctum')->get('/perfil', function (Request $request) {
    return response()->json([
        'usuario' => $request->user()
    ]);
});
