<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;

class AuthAdmin extends Authenticate
{
    protected function authenticate($request, array $guards)
    {
        $user = auth()->user();

        if ($user->isAdmin == 0) {
            $this->unauthenticated($request, $guards);
        }

        if (empty($guards)) {
            $guards = [null];
        }

        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                return $this->auth->shouldUse($guard);
            }
        }

        $this->unauthenticated($request, $guards);
    }

    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }
}

