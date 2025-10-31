<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\mesas;
use App\Models\Productos;
use App\Models\MesasConsumos;
use Carbon\Carbon;

class MesasVentasController extends Controller
{
    // ✅ Muestra todas las mesas
    public function index()
    {
        $mesas = Mesas::all();
        $productos = Productos::all();
        $mesas_consumos = MesasConsumos::all();

        return view('mesasventas.index', compact('mesas', 'productos', 'mesas_consumos'));
    }

    // ✅ Inicia el tiempo de una mesa
    public function iniciarTiempo($idmesa)
    {
        $mesa = Mesas::findOrFail($idmesa);

        if ($mesa->horainicio) {
            $mesa->fechainicio = Carbon::now();
            $mesa->save();
        }

        return redirect()->back()->with('success', 'Tiempo iniciado correctamente.');
    }

    // ✅ Finaliza el tiempo de una mesa
    public function finalizarTiempo($idmesa)
    {
        $mesa = Mesas::findOrFail($idmesa);

        if ($mesa->horainicio && !$mesa->horafin) {
            $mesa->fechafin = Carbon::now();
            $mesa->total = Carbon::parse($mesa->horainicio)->diffInMinutes(Carbon::now());
            $mesa->save();
        }

        return redirect()->back()->with('success', 'Tiempo finalizado correctamente.');
    }
}
