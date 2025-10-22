<?php

namespace App\Http\Controllers;

use App\Models\MesasConsumos;
use App\Models\productos;
use Illuminate\Http\Request;

class MesasConsumosController extends Controller
{
    // 📌 Mostrar todas las mesas de consumo
    public function index()
    {
        $mesas_consumos = MesasConsumos::all();
        return view('mesasconsumo.index', compact('mesas_consumos'));
    }

    // 📌 Cambiar estado de la mesa (Libre, Ocupada, Reservada)
    public function cambiarEstado(Request $request, $id)
    {
        $mesa = MesasConsumos::findOrFail($id);
        $mesa->estado = $request->estado;
        $mesa->save();

        return back()->with('success', '✅ Estado actualizado correctamente.');
    }

    // 📌 Mostrar productos para agregar al consumo de esta mesa
    public function agregarProducto($id)
    {
        $mesa = MesasConsumos::findOrFail($id);
        $productos = productos::all();

        return view('mesasconsumo.agregar', compact('mesa', 'productos'));
    }

    // 📌 Guardar producto agregado al consumo de la mesa
    public function guardarProducto(Request $request, $id)
    {
        $request->validate([
            'idproducto' => 'required|exists:productos,idproducto',
            'cantidad' => 'required|integer|min:1'
        ]);

        // Evita crear otra mesa; actualiza consumos en la misma
        $mesa = MesasConsumos::findOrFail($id);

        // Guarda el consumo como texto o puedes usar una tabla pivote si la tienes
        $nuevoConsumo = $mesa->consumos . "\nProducto: " . $request->idproducto . " - Cantidad: " . $request->cantidad;
        $mesa->consumos = trim($nuevoConsumo);
        $mesa->save();

        return back()->with('success', '✅ Producto agregado correctamente.');
    }
}
