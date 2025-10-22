<?php

namespace App\Http\Controllers;

use App\Models\Mesas;
use App\Models\MesasConsumos;
use App\Models\Productos;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MesasVentasController extends Controller
{
    public function index()
    {
        $mesas = Mesas::all();
        $productos = Productos::all();
        $mesas_consumos = MesasConsumos::all();

        return view('mesasventas.index', compact('mesas', 'productos', 'mesas_consumos'));
    }

    public function iniciarTiempo($idmesa)
    {
        $mesa = Mesas::findOrFail($idmesa);
        $mesa->hora_inicio = Carbon::now();
        $mesa->estado = 'ocupada';
        $mesa->save();

        return redirect()->route('mesasventas.index')->with('success', 'Tiempo iniciado correctamente');
    }

    public function finalizarTiempo($idmesa)
    {
        $mesa = Mesas::findOrFail($idmesa);

        if ($mesa->hora_inicio) {
            $horaInicio = Carbon::parse($mesa->hora_inicio);
            $difMinutos = $horaInicio->diffInMinutes(Carbon::now());
            $mesa->tiempo_total = $difMinutos . ' minutos';
        }

        $mesa->estado = 'disponible';
        $mesa->hora_inicio = null;
        $mesa->save();

        return redirect()->route('mesasventas.index')->with('success', 'Tiempo finalizado');
    }

    public function actualizarEstado(Request $request, $idmesa)
    {
        $mesa = Mesas::findOrFail($idmesa);
        $mesa->estado = $request->estado;
        $mesa->save();

        return redirect()->route('mesasventas.index')->with('success', 'Estado actualizado');
    }

    public function show($idmesa)
    {
        $mesa = Mesas::findOrFail($idmesa);
        $productos = Productos::all();
        $productosMesa = $mesa->productos ?? collect();

        // Si la solicitud viene por AJAX => se envía solo el contenido del modal
        if (request()->ajax()) {
            return view('mesasventas.partials.modal-contenido', compact('mesa', 'productos', 'productosMesa'))->render();
        }

        return view('mesasventas.show', compact('mesa', 'productos', 'productosMesa'));
    }
}
