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

    // 📌 Mostrar formulario de creación
    public function create()
    {
        return view('mesasconsumo.create');
    }

    // 📌 Guardar una nueva mesa de consumo
    public function store(Request $request)
    {
        $request->validate([
            'estado' => 'required|in:libre,ocupada,reservada',
            'consumos' => 'nullable|string',
        ]);

        MesasConsumos::create([
            'estado' => $request->estado,
            'consumos' => $request->consumos ?? '',
        ]);

        return redirect()->route('mesasconsumo.index')
            ->with('success', '✅ Mesa de consumo creada correctamente.');
    }

    // 📌 Mostrar detalles de una mesa de consumo
    public function show($id)
    {
        $mesa = MesasConsumos::findOrFail($id);
        return view('mesasconsumo.show', compact('mesa'));
    }

    // 📌 Editar una mesa de consumo
    public function edit($id)
    {
        $mesa = MesasConsumos::findOrFail($id);
        return view('mesasconsumo.edit', compact('mesa'));
    }

    // 📌 Actualizar mesa de consumo
    public function update(Request $request, $id)
    {
        $request->validate([
            'estado' => 'required|in:libre,ocupada,reservada',
            'consumos' => 'nullable|string',
        ]);

        $mesa = MesasConsumos::findOrFail($id);
        $mesa->update([
            'estado' => $request->estado,
            'consumos' => $request->consumos,
        ]);

        return redirect()->route('mesasconsumo.index')
            ->with('success', '✅ Mesa actualizada correctamente.');
    }

    // 📌 Eliminar mesa de consumo
    public function destroy($id)
    {
        $mesa = MesasConsumos::findOrFail($id);
        $mesa->delete();

        return redirect()->route('mesasconsumo.index')
            ->with('success', '🗑️ Mesa eliminada correctamente.');
    }

    // 📌 Cambiar estado de mesa
    public function cambiarEstado(Request $request, $id)
    {
        $mesa = MesasConsumos::findOrFail($id);
        $mesa->estado = $request->estado;
        $mesa->save();

        return back()->with('success', '✅ Estado actualizado correctamente.');
    }

    // 📌 Mostrar productos para agregar al consumo
    public function agregarProducto($id)
    {
        $mesa = MesasConsumos::findOrFail($id);
        $productos = productos::all();

        return view('mesasconsumo.agregar', compact('mesa', 'productos'));
    }

    // 📌 Guardar producto agregado a la mesa
    public function guardarProducto(Request $request, $id)
    {
        $request->validate([
            'idproducto' => 'required|exists:productos,idproducto',
            'cantidad' => 'required|integer|min:1'
        ]);

        $mesa = MesasConsumos::findOrFail($id);
        $nuevoConsumo = $mesa->consumos . "\nProducto: " . $request->idproducto . " - Cantidad: " . $request->cantidad;
        $mesa->consumos = trim($nuevoConsumo);
        $mesa->save();

        return back()->with('success', '✅ Producto agregado correctamente.');
    }
}
