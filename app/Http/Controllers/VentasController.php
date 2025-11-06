<?php

namespace App\Http\Controllers;

use App\Models\Ventas;
use App\Models\Mesas;
use App\Models\MesasConsumos;
use App\Models\MesasVentas;
use App\Models\ProductosVentas;
use App\Models\Productos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentasController extends Controller
{
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $venta = Ventas::create([
                'fecha' => now(),
                'numerodocumento' => 'FAC-' . time(),
                'idmesaconsumo' => $request->idmesaconsumo ?? null,
                'idmesa' => $request->idmesa ?? null,
                'total' => 0,
            ]);

            $totalVenta = 0;

            foreach ($request->productos as $item) {
                $producto = Productos::findOrFail($item['idproducto']);

                if ($producto->stock < $item['cantidad']) {
                    throw new \Exception("Stock insuficiente para {$producto->nombre}");
                }

                $subtotal = $producto->precio * $item['cantidad'];

                ProductosVentas::create([
                    'idproducto' => $producto->idproducto,
                    'idventa' => $venta->id,
                    'cantidad' => $item['cantidad'],
                    'total' => $subtotal,
                    'descripcion' => $producto->descripcion,
                ]);

                $producto->stock -= $item['cantidad'];
                $producto->save();

                $totalVenta += $subtotal;
            }

            $venta->update(['total' => $totalVenta]);
            DB::commit();

            return response()->json(['success' => true, 'message' => 'Venta registrada', 'venta_id' => $venta->id]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function showFactura($id)
    {
        $venta = Ventas::findOrFail($id);

        // Buscar mesa normal o de consumo
        $mesa = Mesas::find($venta->idmesa) ?? MesasConsumos::find($venta->idmesaconsumo);

        // Obtener los productos de la venta
        $productosVentas = ProductosVentas::where('idventa', $venta->id)->with('producto')->get();

        // Calcular totales
        $totalProductos = $productosVentas->sum('total');
        $totalTiempo = max(0, $venta->total - $totalProductos);
        $tiempo = $mesa->tiempo ?? '00:00:00';

        return view('ventas.factura', compact('venta', 'mesa', 'productosVentas', 'totalProductos', 'totalTiempo', 'tiempo'));
    }
}
