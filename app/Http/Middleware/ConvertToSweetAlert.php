<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ConvertToSweetAlert
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Si la respuesta es un redirect, convertir mensajes de sesión a SweetAlert
        if ($response instanceof \Illuminate\Http\RedirectResponse) {
            $session = $request->session();
            
            // Mapeo de tipos de alerta
            $alertTypes = ['success', 'error', 'warning', 'info', 'status'];
            
            foreach ($alertTypes as $type) {
                if ($session->has($type)) {
                    $message = $session->get($type);
                    
                    // Determinar el tipo de SweetAlert
                    $swlType = $type === 'status' ? 'info' : $type;
                    
                    // Guardar para SweetAlert usando put() para que persista
                    $session->put('swal_type', $swlType);
                    $session->put('swal_message', $message);
                    
                    // Olvidar el mensaje original
                    $session->forget($type);
                    
                    break;
                }
            }
        }

        return $response;
    }
}
