<?php

namespace App\Http\Middleware;

use Closure;

class ApiAuthenticate
{
    public function handle($request, Closure $next)
    {
        if (auth('api')->guest()) {
            return response()->json(['code' => '401', 'message' => 'Unauthenticated.'], 401);
        }
        return $next($request);
    }
}
