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
    // Cargar mesas con ventaActiva y los productos asociados
    $mesas = Mesas::with(['ventaActiva.productos'])->get();
    $productos = Productos::all();

    // ...
    return view('mesasventas.index', compact('mesas','productos'));
}

    
    // Esto asegura que el total se actualice al agregar productos.
    
    private function _actualizarTotalVenta(MesasVentas $venta)
{
    // Vuelve a cargar la relación productos para tener los datos más recientes
    $venta->load('productos'); 
    
    // Suma todos los subtotales (cantidad * precio_unitario) de la tabla pivote.
    $productos_total = $venta->productos->sum(fn($p) => $p->pivot->subtotal);
    
    // Asignar el total solo de consumo (el tiempo se agrega al finalizar)
    $venta->total = round($productos_total, 2); 
    $venta->save();
}
  


   public function agregarProductos(Request $request, $idmesa)
{
    $mesa = Mesas::findOrFail($idmesa);

    $venta = MesasVentas::where('idmesa', $idmesa)->whereNull('fechafin')->first();
    if (!$venta) {
        $venta = MesasVentas::create(['idmesa'=>$idmesa,'fechainicio'=>now(),'total'=>0]);
        if ($mesa->estado !== 'ocupada') {
             $mesa->estado = 'ocupada';
             $mesa->save();
        }
    }

    $cantidadesInput = $request->input('cantidades', []); 
    $hayCambios = false;

    foreach ($cantidadesInput as $productoId => $cantidad) {
        if ($cantidad > 0) {
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

            $hayCambios = true;
        }
    }

    if ($hayCambios) {
        $this->_actualizarTotalVenta($venta);
    }

    return redirect()->back()
        ->with('success', 'Productos agregados correctamente.')
        ->with('abrirModalMesa', $idmesa);
}


    

    public function iniciar($idmesa)
    {
        $mesa = Mesas::findOrFail($idmesa);
        
        // Solo inicia si está disponible para evitar problemas
        if ($mesa->estado == 'disponible') {
            $mesa->estado = 'ocupada';
            $mesa->save();

            $venta = MesasVentas::where('idmesa',$idmesa)->whereNull('fechafin')->first();
            if (!$venta) {
                MesasVentas::create(['idmesa'=>$idmesa,'fechainicio'=>now(),'total'=>0]);
            }
        }

        return redirect()->back();
    }

    public function finalizar(Request $request, $idmesa)
{
    $venta = MesaVenta::findOrFail($idmesa);

    // Actualizar costo de tiempo y método de pago
    $venta->costo_tiempo = $request->costo_tiempo ?? 0;
    $venta->metodo_pago = $request->metodo_pago ?? 'efectivo';
    $venta->estado = 'finalizada';
    $venta->save();

    return response()->json(['success' => true]);
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
        $tarifaHora = 10000;
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
public function eliminarProducto($ventaId, $productoId)
{
    $venta = MesasVentas::findOrFail($ventaId);

    // Buscar el producto en la venta
    $productoPivot = $venta->productos()->where('productos.idproducto', $productoId)->first();

    if ($productoPivot) {
        $producto = Productos::findOrFail($productoId);

        $cantidadActual = $productoPivot->pivot->cantidad;

        if ($cantidadActual > 1) {
            // Resta una unidad y actualiza subtotal
            $nuevaCantidad = $cantidadActual - 1;
            $venta->productos()->updateExistingPivot($productoId, [
                'cantidad' => $nuevaCantidad,
                'subtotal' => $nuevaCantidad * $producto->precio
            ]);
        } else {
            // Elimina completamente el producto
            $venta->productos()->detach($productoId);
        }

        // Devuelve 1 unidad al stock del producto
        $producto->stock += 1;
        $producto->save();

        // Recalcular el total
        $this->_actualizarTotalVenta($venta);
    }

    return redirect()->back()->with('success', 'Cantidad eliminada correctamente de la mesa de consumo.');
}

public function finalizarConsumo($idmesa)
{
    $mesa = MesasConsumos::findOrFail($idmesa);
    $mesa->estado = 'disponible';
    $mesa->save();

    $venta = MesasVentas::where('idmesa', $idmesa)
        ->whereNull('fechafin')
        ->latest()
        ->first();

    if ($venta) {
        $venta->fechafin = now();

        // Cálculo del tiempo
        $inicio = Carbon::parse($venta->fechainicio);
        $fin = Carbon::parse($venta->fechafin);
        $minutes = $inicio->diffInMinutes($fin);

        $tarifaHora = 7000; // puedes ajustar este valor
        $tarifaMinuto = $tarifaHora / 60;
        $cargoTiempo = round($minutes * $tarifaMinuto, 2);

        // Cálculo de productos
        $productos_total = $venta->productos->sum(fn($p) => $p->pivot->subtotal);

        $venta->total = round($productos_total + $cargoTiempo, 2);
        $venta->save();
    }

    return redirect()->back()->with('success', 'Mesa de consumo finalizada y marcada como disponible.');
}






}
