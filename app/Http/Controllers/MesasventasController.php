<?php

namespace App\Http\Controllers;

use App\Models\Mesas;
use App\Models\MesasConsumos;
use App\Models\Productos;
use App\Models\ventas;
use Illuminate\Http\Request;
use App\Models\mesas;
use App\Models\Productos;
use App\Models\MesasConsumos;
use Carbon\Carbon;
use App\Models\MesaProducto;
use App\Models\mesaproductos;
use App\Models\mesasventas;
use App\Models\Mesaventas;

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
  
  
  
    public function actualizarEstado(Request $request, $idmesa)
    {
        $mesa = Mesas::findOrFail($idmesa);
        $mesa->estado = $request->estado;
        $mesa->save();

        return redirect()->route('mesasventas.index')->with('success', 'Estado actualizado');
    }

   
    public function agregarProductos(Request $request)
    {
    $mesa = Mesas::findOrFail($request->mesa_id);
    $producto = Productos::findOrFail($request->producto_id);
    $cantidad = $request->cantidad;

    // Verificar stock disponible
    if ($producto->stock < $cantidad) {
        return redirect()->back()->with('error', 'No hay suficiente stock del producto.');
    }

    // Revisar si el producto ya está en la mesa
    $exists = $mesa->productos()->where('producto_id', $producto->idproducto)->first();

    if ($exists) {
        // Actualizar cantidad si ya existe
        $mesa->productos()->updateExistingPivot($producto->idproducto, [
            'cantidad' => $exists->pivot->cantidad + $cantidad,
            'precio' => $producto->precio
        ]);
    } else {
        // Agregar nuevo producto a la mesa
        $mesa->productos()->attach($producto->idproducto, [
            'cantidad' => $cantidad,
            'precio' => $producto->precio
        ]);
    }

    // Descontar stock
    $producto->stock -= $cantidad;
    $producto->save();

    return redirect()->back()->with('success', 'Producto agregado a la mesa correctamente.');
    }
  
  
    public function finalizarMesa($idmesa)
{
    $productos = mesaproductos::where('idmesa', $idmesa)->get();
    if($productos->isEmpty()){
        return back()->with('error', 'No hay productos agregados a esta mesa.');

    }

    $total = $productos->sum(function($p){ 
        return $p->precio * $p->cantidad; 
    });

    // Crear venta
    $venta = ventas::create([
        'fecha' => now(),
        'numerodocumento' => null, // empleado que genera la venta
        'idmesaconsumo' => null,
        'total' => $total
    ]);

    // Crear registro en mesasventas
    mesasventas::create([
        'ventas' => $venta->id,
        'fechainicio' => now(),
        'fechafin' => now(),
        'total' => $total,
        'idmesa' => $idmesa
    ]);

    // Limpiar productos de la mesa
    mesaproductos::where('idmesa', $idmesa)->delete();

    return back()->with('success', 'Venta finalizada y recibo generado correctamente.');
}




}
