<?php

namespace App\Http\Controllers;

use App\Models\Productos;
use Illuminate\Http\Request;

class ProductosController extends Controller
{
    // Mostrar lista
    public function index()
    {
        $productos = Productos::all();
        return view('productos.index', compact('productos'));
    }

    // Mostrar formulario para crear
    public function create()
    {
        return view('productos.create');
    }

    // Guardar nuevo producto
    public function store(Request $request)
    {
        Productos::create($request->all());
        return redirect()->route('productos.index')->with('success', 'Producto creado correctamente.');
    }

    // Mostrar formulario para editar
    public function edit($idproducto)
    {
        $producto = Productos::findOrFail($idproducto);
        return view('productos.edit', compact('producto'));
    }

    // Actualizar producto
    public function update(Request $request, $idproducto)
    {
        $producto = Productos::findOrFail($idproducto);
        $producto->update($request->all());

        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.');
    }

    // Eliminar producto (opcional)
    public function destroy($idproducto)
    {
        $producto = Productos::findOrFail($idproducto);
        $producto->delete();
        return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente.');
    }
}
