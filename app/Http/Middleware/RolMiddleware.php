<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RolMiddleware
{
    public function handle($request, Closure $next, $rol)
    {
        if (Auth::check() && Auth::user()->id_rol == $rol) {
            return $next($request);
        }

        abort(403, 'Acceso no autorizado');
    }
}