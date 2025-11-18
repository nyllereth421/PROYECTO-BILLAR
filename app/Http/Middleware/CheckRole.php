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
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Si no está autenticado, redirigir a login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Verificar si el rol del usuario está en la lista permitida
        if (!in_array($user->tipo, $roles)) {
            // Si es empleado y no tiene permiso, mostrar acceso denegado
            return response()->view('errors.403', [], 403);
        }

        return $next($request);
    }
}
