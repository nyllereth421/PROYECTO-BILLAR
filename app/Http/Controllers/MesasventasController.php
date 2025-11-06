<?php

namespace App\Http\Controllers;

use App\Models\Mesas;
use App\Models\MesasConsumos;
use App\Models\Productos;
use App\Models\Ventas;
use App\Models\Mesasventas;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MesasVentasController extends Controller
{
    // ✅ Mostrar todas las mesas con productos y consumos
    public function index()
    {
        $mesas = Mesas::all();
        $productos = Productos::all();
        $mesas_consumos = MesasConsumos::all();

        return view('mesasventas.index', compact('mesas', 'productos', 'mesas_consumos'));
    }

    // ✅ Actualizar estado de la mesa (disponible / ocupada)
    public function actualizarEstado(Request $request, $idmesa)
    {
        $mesa = Mesas::findOrFail($idmesa);
        $mesa->estado = $request->estado;
        $mesa->save();

        return redirect()->route('mesasventas.index')->with('success', 'Estado actualizado correctamente.');
    }

    // ✅ Agregar productos a la mesa
    public function agregarProductos(Request $request)
    {
        $mesa = Mesas::findOrFail($request->mesa_id);
        $producto = Productos::findOrFail($request->producto_id);
        $cantidad = $request->cantidad;

        // Verificar stock
        if ($producto->stock < $cantidad) {
            return response()->json(['success' => false, 'message' => 'Stock insuficiente']);
        }

        // Revisar si ya existe el producto en la mesa
        $exists = $mesa->productos()->where('producto_id', $producto->idproducto)->first();

        if ($exists) {
            $mesa->productos()->updateExistingPivot($producto->idproducto, [
                'cantidad' => $exists->pivot->cantidad + $cantidad,
                'precio' => $producto->precio
            ]);
        } else {
            $mesa->productos()->attach($producto->idproducto, [
                'cantidad' => $cantidad,
                'precio' => $producto->precio
            ]);
        }

        $producto->stock -= $cantidad;
        $producto->save();

        return response()->json(['success' => true, 'message' => 'Producto agregado correctamente']);
    }

    // ✅ Iniciar cronómetro (crear registro en mesasventas)
    public function iniciar($idmesa)
    {
        $mesa = Mesas::findOrFail($idmesa);
        $mesa->estado = 'ocupada';
        $mesa->save();

        // Crear registro solo si no existe uno abierto
        $ventaAbierta = Mesasventas::where('idmesa', $idmesa)->whereNull('fechafin')->first();
        if (!$ventaAbierta) {
            Mesasventas::create([
                'idmesa' => $idmesa,
                'fechainicio' => now(),
                'total' => 0,
            ]);
        }

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Cronómetro iniciado']);
        }

        return redirect()->back()->with('success', 'Tiempo iniciado correctamente.');
    }

    // ✅ Finalizar cronómetro (calcula total de tiempo + productos)
    public function finalizar($idmesa)
    {
        $mesa = Mesas::findOrFail($idmesa);
        $mesa->estado = 'disponible';
        $mesa->save();

        $venta = MesasVentas::where('idmesa', $idmesa)
            ->whereNull('fechafin')
            ->orderByDesc('id')
            ->first();

        if ($venta) {
            $venta->fechafin = now();

            // Duración
            $inicio = Carbon::parse($venta->fechainicio);
            $fin = Carbon::parse($venta->fechafin);
            $minutes = $inicio->diffInMinutes($fin);

            // Tarifa
            $tarifa_por_hora = 7000;
            $tarifa_por_minuto = $tarifa_por_hora / 60;
            $cargo_tiempo = round($minutes * $tarifa_por_minuto, 2);

            // Total productos
            $productos_total = 0;
            if (method_exists($mesa, 'productos')) {
                foreach ($mesa->productos as $p) {
                    $productos_total += $p->pivot->cantidad * $p->pivot->precio;
                }
            }

            // Total final
            $venta->total = round($productos_total + $cargo_tiempo, 2);
            $venta->save();
        }

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Tiempo finalizado.',
                'minutes' => $minutes ?? 0,
                'cargo_tiempo' => $cargo_tiempo ?? 0,
                'productos_total' => $productos_total ?? 0,
                'total' => $venta->total ?? 0
            ]);
        }

        return redirect()->back()->with('success', 'Tiempo finalizado correctamente.');
    }

    // ✅ Reiniciar cronómetro (borrar venta abierta)
    public function reiniciar($idmesa)
    {
        $mesa = Mesas::findOrFail($idmesa);
        $mesa->estado = 'disponible';
        $mesa->save();

        MesasVentas::where('idmesa', $idmesa)->whereNull('fechafin')->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Cronómetro reiniciado']);
        }

        return redirect()->back()->with('success', 'Cronómetro reiniciado.');
    }

    public function iniciarTiempo($id)
{
    $mesaVenta = MesasVentas::findOrFail($id);
    $mesaVenta->fechainicio = now();
    $mesaVenta->fechafin = null;
    $mesaVenta->save();

    return response()->json([
        'success' => true,
        'message' => 'Tiempo iniciado correctamente',
        'fechainicio' => $mesaVenta->fechainicio
    ]);
}

public function finalizarTiempo($id)
{
    $mesaVenta = MesasVentas::findOrFail($id);
    $mesaVenta->fechafin = now();

    // Calcular tiempo total en horas
    $inicio = strtotime($mesaVenta->fechainicio);
    $fin = strtotime($mesaVenta->fechafin);
    $horas = ($fin - $inicio) / 3600;
    $valorHora = 7000;
    $mesaVenta->total = round($horas * $valorHora, 2);
    $mesaVenta->save();

    return response()->json([
        'success' => true,
        'message' => 'Tiempo finalizado correctamente',
        'fechafin' => $mesaVenta->fechafin,
        'total' => $mesaVenta->total
    ]);
}

}
