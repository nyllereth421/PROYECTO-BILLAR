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
    $mesas_consumos = MesasConsumos::with(['ventaActiva.productos'])->get();
    $productos = Productos::all();

    // ...
    return view('mesasventas.index', compact('mesas','mesas_consumos','productos'));
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

    $productosSeleccionados = $request->input('productosSeleccionados', []);
    // 💡 CAMBIO CLAVE: Recibir el array asociativo de cantidades
    $cantidadesInput = $request->input('cantidades', []); 
    $hayCambios = false;

    // Iteramos SOLAMENTE sobre los IDs de los productos marcados
    foreach ($productosSeleccionados as $productoId) {
        // 💡 CAMBIO CLAVE: Obtener la cantidad usando el ID del producto como llave
        $cantidad = $cantidadesInput[$productoId] ?? 0; 
        
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

        $hayCambios = true;
    }

    // Actualiza el campo 'total' en la base de datos
    if ($hayCambios) {
        $this->_actualizarTotalVenta($venta);
    }

    return redirect()->back()->with('success','Productos agregados correctamente.');
}

    public function agregarProductosConsumo(Request $request, $idmesa)
{
    $mesa = MesasConsumos::findOrFail($idmesa);


    $venta = MesasVentas::where('idmesa', $idmesa)->whereNull('fechafin')->first(); 
    if (!$venta) {
        $venta = MesasVentas::create(['idmesa'=>$idmesa,'fechainicio'=>now(),'total'=>0]);
        if ($mesa->estado !== 'ocupada') {
             $mesa->estado = 'ocupada';
             $mesa->save();
        }
    }

    $productosSeleccionados = $request->input('productosSeleccionados', []);
    // 💡 CAMBIO CLAVE: Recibir el array asociativo de cantidades
    $cantidadesInput = $request->input('cantidades', []); 
    $hayCambios = false;

    // Iteramos SOLAMENTE sobre los IDs de los productos marcados
    foreach ($productosSeleccionados as $productoId) {
        // 💡 CAMBIO CLAVE: Obtener la cantidad usando el ID del producto como llave
        $cantidad = $cantidadesInput[$productoId] ?? 0; 
        
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
        
        $hayCambios = true;
    }

    // Actualiza el campo 'total' en la base de datos
    if ($hayCambios) {
        $this->_actualizarTotalVenta($venta);
    }

    return redirect()->back()->with('success','Productos agregados correctamente a la mesa de consumo.');
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

    public function finalizar($idmesa)
    {
        $mesa = Mesas::findOrFail($idmesa);
        $mesa->estado = 'disponible'; // Cambia el estado
        $mesa->save();

        $venta = MesasVentas::where('idmesa',$idmesa)->whereNull('fechafin')->latest()->first();
        if ($venta) {
            $venta->fechafin = now();
            
            // Cálculos para finalizar la venta
            $inicio = Carbon::parse($venta->fechainicio);
            $fin = Carbon::parse($venta->fechafin);
            $minutes = $inicio->diffInMinutes($fin);
            $tarifaHora = 7000;
            $tarifaMinuto = $tarifaHora / 60;
            $cargoTiempo = round($minutes * $tarifaMinuto,2);

            // Se calcula el total de productos directamente de la tabla pivote
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


}
