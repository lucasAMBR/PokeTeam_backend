<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\LoginRequest;
use App\Services\AuthService;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

     public function login(LoginRequest $request)
    {
        \Log::info('Test log - should appear now');

        $data = $this->authService->login(
            $request->input('email'),
            $request->input('password')
        );

        return response()->json($data);
    }
}
