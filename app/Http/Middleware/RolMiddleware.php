<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RolMiddleware
{
    public function handle(Request $request, Closure $next, $rol)
    {
        if (Auth::check() && Auth::login()->id_rol == $rol) {
            return $next($request);
        }

        abort(403, 'Acceso no autorizado.');
    }
}
