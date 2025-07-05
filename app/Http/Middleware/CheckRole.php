<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string ...$roles Los roles permitidos para la ruta.
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Si el usuario no está logueado o no tiene el rol requerido, abortar.
        if (!Auth::check() || !in_array(Auth::user()->role, $roles)) {
            abort(403, 'Acceso no autorizado.');
        }

        return $next($request);
    }
}