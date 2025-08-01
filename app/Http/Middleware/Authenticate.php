<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        // Se for uma API, não redireciona, apenas retorna 401
        if (!$request->expectsJson()) {
            return route('login');
        }

        return null;
    }
}
