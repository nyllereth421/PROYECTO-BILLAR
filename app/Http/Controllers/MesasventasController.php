<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mesas;
use App\Models\MesasConsumos;
use App\Models\Productos;
use App\Models\MesasVentas;
use Carbon\Carbon;

class MesasventasController extends Controller
{
    public function index()
    {
        // Cargar mesas con ventaActiva
        $mesas = Mesas::with(['ventaActiva.productos'])->get();
        $mesas_consumos = MesasConsumos::with(['ventaActiva.productos'])->get();
        $productos = Productos::all();

        return view('mesasventas.index', compact('mesas','mesas_consumos','productos'));
    }

    public function agregarProductos(Request $request, $idmesa)
    {
        $mesa = Mesas::findOrFail($idmesa);

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
