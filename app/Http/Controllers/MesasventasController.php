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
    /**
     * Muestra la vista principal de mesas, consumos y productos.
     */
    public function index()
    {
        // Cargar mesas con ventaActiva y los productos asociados
        $mesas = Mesas::with(['ventaActiva.productos'])->get();
        $mesas_consumos = MesasConsumos::with(['ventaActiva.productos'])->get();
        $productos = Productos::paginate(10);

        return view('mesasventas.index', compact('mesas','mesas_consumos','productos'));
    }

    /**
     * Método privado para recalcular y actualizar el total de productos de una venta.
     */
    private function _actualizarTotalVenta(MesasVentas $venta)
    {
        // Vuelve a cargar la relación productos para tener los datos más recientes
        $venta->load('productos'); 
        
        // Suma todos los subtotales (cantidad * precio_unitario) de la tabla pivote.
        $productos_total = $venta->productos->sum(fn($p) => $p->pivot->subtotal);
        
        // Asignar el total solo de consumo (el tiempo se agrega al finalizar la venta)
        $venta->total = round($productos_total, 2); 
        $venta->save();
    }
    
    /**
     * Agrega productos a una Venta Activa de una Mesa NORMAL.
     */
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

    /**
     * Agrega productos a una Venta Activa de una Mesa de CONSUMO.
     */
    public function agregarProductosConsumo(Request $request, $idmesa)
    {
        $mesa = MesasConsumos::findOrFail($idmesa);

        $venta = MesasVentas::where('idmesa_consumo', $idmesa)->whereNull('fechafin')->first(); // 💡 Nota: Asegúrate que tu modelo Venta tiene idmesa_consumo
        if (!$venta) {
            // Asumo que tu tabla MesasVentas tiene una columna idmesa_consumo para registrar estas ventas.
            $venta = MesasVentas::create(['idmesa_consumo'=>$idmesa,'fechainicio'=>now(),'total'=>0]);
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
            ->with('success', 'Productos agregados correctamente a la mesa de consumo.')
            ->with('abrirModalConsumo', $idmesa);
    }

    /**
     * Inicia una nueva venta para una Mesa NORMAL.
     */
    public function iniciar($idmesa)
    {
        $mesa = Mesas::findOrFail($idmesa);
        
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

    /**
     * Finaliza la venta y actualiza la mesa con el total FINAL calculado en el front-end (incluyendo tiempo).
     * Este es el método que usará el botón "Finalizar Venta y Cobrar" del modal.
     */
    public function finalizarVenta(Request $request, MesasVentas $venta)
    {
        // 1. Validación (total_final viene del formulario del modal)
        $request->validate([
            'total_final' => 'required|numeric|min:0',
        ]);

        $totalFinal = $request->input('total_final');

        // 2. Obtener la Mesa (puede ser Mesas o MesasConsumos)
        $mesa = null;
        if ($venta->idmesa) {
            $mesa = Mesas::find($venta->idmesa);
        } elseif ($venta->idmesa_consumo) {
            $mesa = MesasConsumos::find($venta->idmesa_consumo);
        }

        // 3. Actualizar la Venta con el total final del front-end
        $venta->total = $totalFinal; 
        $venta->fechafin = now();  
        $venta->save();

        // 4. Liberar la Mesa si existe
        if ($mesa) {
            $mesa->estado = 'disponible';
            $mesa->save();
        }
        
        // 5. Retornar con éxito
        $nombreMesa = $mesa ? ($mesa->numeromesa ?? $mesa->id) : $venta->id; // Para el mensaje
        return redirect()->route('mesasventas.index') 
                         ->with('success', '¡Venta #'.$venta->id.' de Mesa #'.$nombreMesa.' finalizada y registrada! Total Cobrado: $'.number_format($totalFinal, 0, ',', '.'));
    }

    /**
     * Mantiene el método 'finalizar' original para Mesas NORMALES (si se usaba como botón de cambio de estado).
     * Nota: La lógica de tiempo aquí está basada en una tarifa fija que se aplicaba antes de la integración del modal.
     */
    public function finalizar($idmesa)
    {
        $mesa = Mesas::findOrFail($idmesa);
        $mesa->estado = 'disponible';
        $mesa->save();

        $venta = MesasVentas::where('idmesa',$idmesa)->whereNull('fechafin')->latest()->first();
        if ($venta) {
            $venta->fechafin = now();
            
            // Cálculos para finalizar la venta (Cálculo original: Solo para referencia o si se usa este botón)
            $inicio = Carbon::parse($venta->fechainicio);
            $fin = Carbon::parse($venta->fechafin);
            $minutes = $inicio->diffInMinutes($fin);
            $tarifaHora = 7000;
            $tarifaMinuto = $tarifaHora / 60;
            $cargoTiempo = round($minutes * $tarifaMinuto,2);

            $productos_total = $venta->productos->sum(fn($p) => $p->pivot->subtotal); 
            $venta->total = round($productos_total + $cargoTiempo,2);
            $venta->save();
        }

        return redirect()->back();
    }

    /**
     * Reinicia la Mesa, finalizando la venta activa y liberando el estado.
     */
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

    /**
     * Actualiza el estado de una Mesa NORMAL.
     */
    public function actualizarEstado(Request $request, $idmesa)
    {
        $mesa = Mesas::findOrFail($idmesa);
        $mesa->estado = $request->input('estado', 'disponible');
        $mesa->save();

        return redirect()->back()->with('success', 'Estado de la mesa actualizado correctamente.');
    }

    /**
     * Actualiza el estado de una Mesa de CONSUMO.
     */
    public function actualizarEstadoConsumo(Request $request, $idmesa)
    {
        $mesa = MesasConsumos::findOrFail($idmesa);
        $mesa->estado = $request->input('estado', 'disponible');
        $mesa->save();

        return redirect()->back()->with('success', 'Estado de la mesa de consumo actualizado correctamente.');
    }

    /**
     * Elimina un producto de una Venta Activa de Mesa NORMAL y devuelve el stock.
     */
    public function eliminarProducto($ventaId, $productoId)
    {
        $venta = MesasVentas::findOrFail($ventaId);

        $productoPivot = $venta->productos()->where('productos.idproducto', $productoId)->first();
        if ($productoPivot) {
            $producto = Productos::findOrFail($productoId);
            $producto->stock += $productoPivot->pivot->cantidad;
            $producto->save();

            $venta->productos()->detach($productoId);

            $this->_actualizarTotalVenta($venta);
        }

        return redirect()->back()->with('success', 'Producto eliminado correctamente.');
    }

    /**
     * Elimina un producto de una Venta Activa de Mesa de CONSUMO y devuelve el stock.
     */
    public function eliminarProductoConsumo($ventaId, $productoId)
    {
        $venta = MesasVentas::findOrFail($ventaId);

        $productoPivot = $venta->productos()->where('productos.idproducto', $productoId)->first();

        if ($productoPivot) {
            $producto = Productos::findOrFail($productoId);

            $producto->stock += $productoPivot->pivot->cantidad;
            $producto->save();

            $venta->productos()->detach($productoId);

            $this->_actualizarTotalVenta($venta);
        }

        return redirect()->back()->with('success', 'Producto eliminado correctamente de la mesa de consumo.');
    }
}