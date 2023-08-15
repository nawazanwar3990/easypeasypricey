<?php

namespace App\Http\Middleware;

use App\Enum\SessionEnum;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class Localization
{
    public function handle(Request $request, Closure $next)
    {
        App::setLocale(session(SessionEnum::LANGUAGE));

        return $next($request);
    }
}
