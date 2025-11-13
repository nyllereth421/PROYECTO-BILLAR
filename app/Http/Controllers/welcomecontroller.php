<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WelcomeController extends Controller
{
    public function index()
    {
        // Fecha de hoy en formato YYYY-MM-DD y zona horaria correcta
        $hoy = Carbon::now('America/Bogota')->format('Y-m-d');

        // Ventas del día
        $ingresoDia = DB::table('mesasventas')
            ->whereDate('fechainicio', $hoy)
            ->sum('total');

        // Día actual en español
        $dias = ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'];
        $nombreDia = $dias[date('w')]; // 0=domingo, 1=lunes...

        // Ventas semana actual
        $inicioSemana = Carbon::now('America/Bogota')->startOfWeek(); // Lunes
        $ventasSemana = [];
        $labelsSemana = [];

        for ($i = 0; $i < 7; $i++) {
            $fecha = $inicioSemana->copy()->addDays($i);
            $ventasSemana[] = DB::table('mesasventas')
                ->whereDate('fechainicio', $fecha)
                ->sum('total');
            $labelsSemana[] = $dias[$fecha->dayOfWeek];
        }

        // Enviar datos a la vista
        return view('welcome', compact(
            'ingresoDia',
            'nombreDia',
            'ventasSemana',
            'labelsSemana'
        ));
    }
}
