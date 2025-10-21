<?php

namespace App\Http\Controllers;

use App\Models\MesasVentas;
use App\Models\MesasConsumos;
use App\Models\Mesas;
use App\Models\Productos;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MesasVentasController extends Controller
{
    /**
     * Mostrar todas las mesas normales y de consumo
     */
    public function index()
    {
        $mesas = Mesas::all(); // Mesas normales
        $mesas_consumos = MesasConsumos::all(); // Mesas de consumo

        return view('mesasventas.index', compact('mesas', 'mesas_consumos'));
    }

    // ✅ Cambiar estado de mesa (Libre / Ocupada / Reservada)
    public function actualizarEstado(Request $request, $idmesa)
    {
        $mesa = Mesas::findOrFail($idmesa);
        $mesa->estado = $request->estado;
        $mesa->save();

        return back()->with('success', '✅ Estado actualizado correctamente');
    }

    // ✅ Iniciar tiempo de la mesa
    public function iniciarTiempo($idmesa)
    {
        $mesa = Mesas::findOrFail($idmesa);
        $mesa->hora_inicio = now();
        $mesa->estado = 'Ocupada';
        $mesa->save();

        return back()->with('success', '✅ Tiempo iniciado en la mesa');
    }

    // ✅ Finalizar tiempo de la mesa
    public function finalizarTiempo($idmesa)
    {
        $mesa = Mesas::findOrFail($idmesa);
        $mesa->hora_fin = now();
        $mesa->estado = 'Libre';
        $mesa->save();

        return back()->with('success', '✅ Tiempo finalizado en la mesa');
    }

    // ✅ Formulario para agregar productos a la mesa
    public function agregarProductos($idmesa)
    {
        $mesa = Mesas::findOrFail($idmesa);
        $productos = Productos::all();

        return view('mesasventas.agregar', compact('mesa', 'productos'));
    }

    // ✅ Guardar productos en la mesa (crear venta/consumo)
    public function guardarProductos(Request $request)
    {
        $request->validate([
            'idmesa' => 'required|exists:mesas,idmesa',
            'idproducto' => 'required|array',
            'cantidad' => 'required|array',
        ]);

        // Crear una venta
        $venta = MesasVentas::create([
            'idmesa' => $request->idmesa,
            'hora_inicio' => Carbon::now(),
            'estado' => 'ocupada',
        ]);

        // Relacionar productos con la venta
        foreach ($request->idproducto as $i => $producto) {
            $venta->productos()->attach($producto, [
                'cantidad' => $request->cantidad[$i],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Cambiar estado de la mesa
        $mesa = Mesas::find($request->idmesa);
        $mesa->estado = 'Ocupada';
        $mesa->save();

        return redirect()->route('mesasventas.index')->with('success', '✅ Productos agregados correctamente');
    }

    // ✅ Finalizar venta y liberar mesa
    public function finalizarVenta($idventa)
    {
        $venta = MesasVentas::findOrFail($idventa);
        $venta->hora_fin = Carbon::now();
        $venta->estado = 'finalizada';
        $venta->save();

        // Liberar mesa
        $mesa = Mesas::find($venta->idmesa);
        $mesa->estado = 'Libre';
        $mesa->save();

        return redirect()->route('mesasventas.index')->with('success', '✅ Venta finalizada y mesa liberada');
    }
}
