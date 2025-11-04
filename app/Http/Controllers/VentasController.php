<?php

namespace App\Http\Controllers;

use App\Models\ventas;
use Illuminate\Http\Request;

class VentasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    DB::beginTransaction();

    try {
        // 1️⃣ Crear la venta
        $venta = Ventas::create([
            'fecha' => now(),
            'numerodocumento' => 'FAC-' . time(),
            'idmesaconsumo' => $request->idmesaconsumo,
            'total' => 0, // se actualizará más adelante
        ]);

        $totalVenta = 0;

        // 2️⃣ Recorrer los productos seleccionados
        foreach ($request->productos as $item) {
            $producto = Productos::findOrFail($item['idproducto']);

            // Verificar stock suficiente
            if ($producto->stock < $item['cantidad']) {
                throw new \Exception("Stock insuficiente para el producto {$producto->nombre}");
            }

            // Calcular subtotal
            $subtotal = $producto->precio * $item['cantidad'];

            // 3️⃣ Crear registro en productos_ventas
            ProductosVentas::create([
                'idproducto' => $producto->idproducto,
                'id' => $venta->id,
                'cantidad' => $item['cantidad'],
                'total' => $subtotal,
                'descripcion' => $producto->descripcion,
            ]);

            // 4️⃣ Descontar del stock
            $producto->stock -= $item['cantidad'];
            $producto->save();

            $totalVenta += $subtotal;
        }

        // 5️⃣ Actualizar total de la venta
        $venta->update(['total' => $totalVenta]);

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Venta registrada con éxito',
            'venta_id' => $venta->id,
        ]);

    } catch (\Exception $e) {
        DB::rollBack();

        return response()->json([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage(),
        ], 500);
    }
}


    /**
     * Display the specified resource.
     */
    public function show(ventas $ventas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ventas $ventas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ventas $ventas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ventas $ventas)
    {
        //
    }

    public function showFactura($id)
{
    $venta = Ventas::findOrFail($id);
    $mesa = Mesas::findOrFail($venta->idmesaconsumo);
    $productosVentas = ProductosVentas::where('idventa', $venta->id)->get();

    // Calcula totales
    $totalProductos = $productosVentas->sum('total');
    $totalTiempo = $venta->total - $totalProductos; // o el valor que corresponda
    $tiempo = $mesa->tiempo ?? '00:00:00';

    return view('ventas.factura', compact('venta', 'mesa', 'productosVentas', 'totalProductos', 'totalTiempo', 'tiempo'));
}

}
