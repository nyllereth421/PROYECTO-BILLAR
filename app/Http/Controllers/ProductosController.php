<?php

namespace App\Http\Controllers;

use App\Models\Productos;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class ProductosController extends Controller
{
    /**
     * Muestra la lista de productos con buscador y alertas.
     */
    public function index(Request $request)
    {
        // Texto de búsqueda
        $buscar = $request->input('buscar', null);

        // Construcción de la consulta
        $query = Productos::with('proveedor');

        if ($buscar) {
            $query->where(function ($q) use ($buscar) {
                $q->where('nombre', 'LIKE', "%{$buscar}%")
                  ->orWhere('descripcion', 'LIKE', "%{$buscar}%")
                  ->orWhere('idproducto', $buscar);
            });
        }

        // Se listan todos los productos ordenados alfabéticamente
        $productos = $query->orderBy('nombre', 'asc')->get();

        // Verificar si hay productos con poco stock
        $productosBajoStock = $productos->where('cantidad', '<', 10)->count();

        if ($productosBajoStock < 10) {
            session()->flash('alerta_stock', '¡Atención! Algunos productos tienen menos de 10 unidades disponibles.');
        }

        return view('productos.index', compact('productos', 'buscar'));
    }

    /**
     * Muestra el formulario de creación.
     */
    public function create()
    {
        return view('productos.create');
    }

    /**
     * Guarda un nuevo producto.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'precio' => 'required|numeric|min:1000',
            'cantidad' => 'required|integer|min:10',
        ]);

        Productos::create($request->all());

        return redirect()->route('productos.index')->with('success', 'Producto agregado correctamente.');
    }

    /**
     * Muestra el formulario de edición.
     */
    public function edit($id)
    {
        $producto = Productos::findOrFail($id);
        return view('productos.edit', compact('producto'));
    }

    /**
     * Actualiza los datos del producto.
     */
    public function update(Request $request, $id)
    {
        $producto = Productos::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:100',
            'precio' => 'required|numeric|min:1000',
            'cantidad' => 'required|integer|min:10',
        ]);

        $producto->update($request->all());

        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.');
    }

    /**
     * Elimina un producto, validando si tiene relaciones activas.
     */
    public function destroy($id)
    
{
    return redirect()->route('productos.index')
        ->with('error', '❌ No está permitido eliminar productos.');
}

    /**
     * Muestra los 5 productos más vendidos (para el dashboard o welcome).
     */
    public function topProductos()
    {
        $topProductos = Productos::orderByDesc('cantidad_vendida')->take(5)->get();
        return view('welcome', compact('topProductos'));
    }
      public function mostrarEnInicio()
{
    // Consulta los 5 productos más vendidos o solo todos los productos
    $productos = Productos::take(5)->get();


    // Pasar los datos a la vista welcome
    return view('welcome', compact('productos'));
}
}
