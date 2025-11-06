<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mesas;
use App\Models\MesasConsumos;
use App\Models\Productos;
use App\Models\Ventas;
use App\Models\Mesasventas;
use Illuminate\Http\Request;
use App\Models\MesasVentas;
use Carbon\Carbon;
class MesasventasController extends Controller

    public function index()
    {
        // Cargar mesas con ventaActiva
        $mesas = Mesas::with(['ventaActiva.productos'])->get();
        $mesas_consumos = MesasConsumos::with(['ventaActiva.productos'])->get();
        $productos = Productos::all();

        return view('mesasventas.index', compact('mesas','mesas_consumos','productos'));
    }


    // ✅ Actualizar estado de la mesa (disponible / ocupada)
    public function actualizarEstado(Request $request, $idmesa)
    public function agregarProductos(Request $request, $idmesa)
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

        $venta = MesasVentas::where('idmesa', $idmesa)->whereNull('fechafin')->first();
        if (!$venta) {
            $venta = MesasVentas::create(['idmesa'=>$idmesa,'fechainicio'=>now(),'total'=>0]);
        }

        $productosSeleccionados = $request->input('productosSeleccionados', []);
        $cantidades = $request->input('cantidades', []);

        // En tu vista envía cantidades[] y productosSeleccionados[] (mismo orden)
        foreach ($productosSeleccionados as $index => $productoId) {
            $cantidad = $cantidades[$index] ?? 0;
            if ($cantidad <= 0) continue;

            $producto = Productos::findOrFail($productoId);
            if ($producto->stock < $cantidad) {
                return redirect()->back()->with('error', "Stock insuficiente para {$producto->nombre}");
            }

            $venta->productos()->attach($producto->idproducto, [
                'cantidad' => $cantidad,
                'precio_unitario' => $producto->precio,
                'subtotal' => $producto->precio * $cantidad,
            ]);

            $producto->stock -= $cantidad;
            $producto->save();
        }

        return redirect()->back()->with('success','Productos agregados correctamente.');
    }

    public function agregarProductosConsumo(Request $request, $idmesa)
    {
        // Misma lógica pero con MesasConsumos
        $mesa = MesasConsumos::findOrFail($idmesa);

        $venta = MesasVentas::where('idmesa', $idmesa)->whereNull('fechafin')->first();
        if (!$venta) {
            $venta = MesasVentas::create(['idmesa'=>$idmesa,'fechainicio'=>now(),'total'=>0]);
        }

        $productosSeleccionados = $request->input('productosSeleccionados', []);
        $cantidades = $request->input('cantidades', []);

        foreach ($productosSeleccionados as $index => $productoId) {
            $cantidad = $cantidades[$index] ?? 0;
            if ($cantidad <= 0) continue;

            $producto = Productos::findOrFail($productoId);
            if ($producto->stock < $cantidad) {
                return redirect()->back()->with('error', "Stock insuficiente para {$producto->nombre}");
            }

            $venta->productos()->attach($producto->idproducto, [
                'cantidad' => $cantidad,
                'precio_unitario' => $producto->precio,
                'subtotal' => $producto->precio * $cantidad,
            ]);

            $producto->stock -= $cantidad;
            $producto->save();
        }

        return redirect()->back()->with('success','Productos agregados correctamente a la mesa de consumo.');
    }

    public function iniciar($idmesa)
    {
        $mesa = Mesas::findOrFail($idmesa);
        $mesa->estado = 'ocupada';
        $mesa->save();

        $venta = MesasVentas::where('idmesa',$idmesa)->whereNull('fechafin')->first();
        if (!$venta) {
            MesasVentas::create(['idmesa'=>$idmesa,'fechainicio'=>now(),'total'=>0]);
        }

        return redirect()->back();
    }

    public function finalizar($idmesa)
    {
        $mesa = Mesas::findOrFail($idmesa);
        $mesa->estado = 'disponible';
        $mesa->save();

        $venta = MesasVentas::where('idmesa',$idmesa)->whereNull('fechafin')->latest()->first();
        if ($venta) {
            $venta->fechafin = now();
            // calculo tiempo ejemplo (minutos)
            $inicio = Carbon::parse($venta->fechainicio);
            $fin = Carbon::parse($venta->fechafin);
            $minutes = $inicio->diffInMinutes($fin);
            $tarifaHora = 7000;
            $tarifaMinuto = $tarifaHora / 60;
            $cargoTiempo = round($minutes * $tarifaMinuto,2);

            // productos total
            $productos_total = $venta->productos->sum(fn($p) => $p->pivot->subtotal);
            $venta->total = round($productos_total + $cargoTiempo,2);
            $venta->save();
        }

        return redirect()->back();
    }

   public function reiniciar($idmesa)
{
    $mesa = Mesas::findOrFail($idmesa);
    $mesa->estado = 'disponible';
    $mesa->save();

    // Obtiene la venta activa (si existe)
    $venta = MesasVentas::where('idmesa', $idmesa)->whereNull('fechafin')->first();

    if ($venta) {
        // Finaliza la venta sin borrarla
        $venta->fechafin = now();

        // Calcula tiempo y cargo
        $inicio = Carbon::parse($venta->fechainicio);
        $fin = Carbon::parse($venta->fechafin);
        $minutes = $inicio->diffInMinutes($fin);
        $tarifaHora = 7000;
        $tarifaMinuto = $tarifaHora / 60;
        $cargoTiempo = round($minutes * $tarifaMinuto, 2);

        // Suma productos
        $productos_total = $venta->productos->sum(fn($p) => $p->pivot->subtotal);
        $venta->total = round($productos_total + $cargoTiempo, 2);

        $venta->save();
    }

    return redirect()->back();
}

    
    public function actualizarEstado(Request $request, $idmesa)
{
    $mesa = Mesas::findOrFail($idmesa);
    $mesa->estado = $request->input('estado', 'disponible');
    $mesa->save();

    return redirect()->back()->with('success', 'Estado de la mesa actualizado correctamente.');
}
    public function actualizarEstadoConsumo(Request $request, $idmesa)
{
    $mesa = MesasConsumos::findOrFail($idmesa);
    $mesa->estado = $request->input('estado', 'disponible');
    $mesa->save();

    return redirect()->back()->with('success', 'Estado de la mesa de consumo actualizado correctamente.');
}


}
