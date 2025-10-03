<?php

namespace App\Http\Controllers;
use App\Models\Proveedores;
use App\Models\Productos;
use Illuminate\Http\Request;

class ProductosController extends Controller
{
    // Mostrar lista
    public function index()
    {
        $productos = Productos::all();
        $proveedores = Proveedores::all();

        return view('productos.index', compact('productos', 'proveedores'));
    }

    // Mostrar formulario para crear
    public function create()
    {
        $proveedores = Proveedores::all();
        return view('productos.create', compact('proveedores'));
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
        $proveedores = Proveedores::all();
        return view('productos.edit', compact('producto', 'proveedores'));
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
