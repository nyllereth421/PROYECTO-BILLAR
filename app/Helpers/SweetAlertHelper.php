<?php

namespace App\Helpers;

use Illuminate\Http\RedirectResponse;

class SweetAlertHelper
{
    /**
     * Mostrar alerta de éxito
     */
    public static function success($route, $message = null): RedirectResponse
    {
        $message = $message ?? self::getMessage('success');
        return redirect($route)
            ->with('swal_type', 'success')
            ->with('swal_message', $message);
    }

    /**
     * Mostrar alerta de error
     */
    public static function error($route, $message = null): RedirectResponse
    {
        $message = $message ?? self::getMessage('error');
        return redirect($route)
            ->with('swal_type', 'error')
            ->with('swal_message', $message);
    }

    /**
     * Mostrar alerta de advertencia
     */
    public static function warning($route, $message = null): RedirectResponse
    {
        $message = $message ?? self::getMessage('warning');
        return redirect($route)
            ->with('swal_type', 'warning')
            ->with('swal_message', $message);
    }

    /**
     * Mostrar alerta de información
     */
    public static function info($route, $message = null): RedirectResponse
    {
        $message = $message ?? self::getMessage('info');
        return redirect($route)
            ->with('swal_type', 'info')
            ->with('swal_message', $message);
    }

    /**
     * Obtener mensaje predefinido
     */
    public static function getMessage($key)
    {
        $messages = [
            'success' => '¡Operación completada exitosamente!',
            'error' => 'Ocurrió un error al procesar la solicitud.',
            'warning' => 'Por favor revisa los datos ingresados.',
            'info' => 'Información importante.',
            'created' => '¡Registro creado exitosamente!',
            'updated' => '¡Registro actualizado exitosamente!',
            'deleted' => '¡Registro eliminado exitosamente!',
            'not_found' => 'El registro no fue encontrado.',
            'unauthorized' => 'No tienes permiso para realizar esta acción.',
            'validation_error' => 'Por favor revisa los errores en el formulario.',
        ];

        return $messages[$key] ?? $messages['success'];
    }

    /**
     * Generar script de SweetAlert2 para la sesión
     */
    public static function showAlert()
    {
        $type = session('swal_type');
        $message = session('swal_message');

        if (!$type || !$message) {
            return '';
        }

        $icon = [
            'success' => 'success',
            'error' => 'error',
            'warning' => 'warning',
            'info' => 'info',
        ][$type] ?? 'info';

        $title = [
            'success' => '¡Éxito!',
            'error' => '¡Error!',
            'warning' => '¡Advertencia!',
            'info' => 'Información',
        ][$type] ?? 'Información';

        return <<<SCRIPT
        <script>
            Swal.fire({
                icon: '$icon',
                title: '$title',
                text: '$message',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: true,
                confirmButtonColor: '#3085d6'
            });
        </script>
        SCRIPT;
    }
}
