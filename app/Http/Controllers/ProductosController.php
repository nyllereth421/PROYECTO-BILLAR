<?php

namespace App\Http\Controllers;

use App\Models\Productos;
use App\Models\Proveedores;
use Illuminate\Http\Request;

class ProductosController extends Controller
{
    /**
     * Muestra la lista de productos con buscador y alertas.
     * Ahora compatible con búsqueda en tiempo real sin paginación.
     */
    public function index(Request $request)
    {
        $buscar = $request->input('buscar', null);

        $query = Productos::with('proveedor');

        if ($buscar) {
            $query->where(function ($q) use ($buscar) {
                $q->where('nombre', 'LIKE', "%{$buscar}%")
                  ->orWhere('descripcion', 'LIKE', "%{$buscar}%")
                  ->orWhere('idproducto', $buscar);
            });
        }

        // Paginación de 10 registros
        $productos = $query->orderBy('nombre', 'asc')->paginate(10);
        $productosAll = Productos::where('idproveedor', '!=', 5)->get();


        // Verificar productos con stock bajo
        $productosBajoStock = $productosAll->where('stock', '<', 10)->count();

        if ($productosBajoStock > 0 && !$request->ajax()) {
            session()->flash('alerta_stock', '¡Atención! Hay ' . $productosBajoStock . ' producto(s) con menos de 10 unidades disponibles.');
        }

        // Retornar vista normal
        return view('productos.index', compact('productos', 'buscar','productosAll'));
    }

    /**
     * Muestra el formulario de creación.
     */
    public function create()
    {
        $proveedores = Proveedores::orderBy('nombre', 'asc')->get();
        return view('productos.create', compact('proveedores'));
    }

    /**
     * Guarda un nuevo producto.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:1000',
            'stock' => 'required|integer|min:0',
            'idproveedor' => 'required|exists:proveedores,idproveedor',
        ]);

        Productos::create($validated);

        return redirect()->route('productos.index')->with('success', 'Producto agregado correctamente.');
    }

    /**
     * Muestra el formulario de edición.
     */
    public function edit($id)
    {
        $producto = Productos::findOrFail($id);
        $proveedores = Proveedores::orderBy('nombre', 'asc')->get();
        return view('productos.edit', compact('producto', 'proveedores'));
    }

    /**
     * Actualiza los datos del producto.
     */
    public function update(Request $request, $id)
    {
        $producto = Productos::findOrFail($id);

        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:1000',
            'stock' => 'required|integer|min:0',
            'idproveedor' => 'required|exists:proveedores,idproveedor',
        ]);

        $producto->update($validated);

        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.');
    }

    /**
     * No se permite eliminar productos para evitar daños a ventas.
     */
    public function destroy($id)
    {
        return redirect()->route('productos.index')
            ->with('error', '❌ No está permitido eliminar productos para proteger el historial de ventas.');
    }

    /**
     * Obtiene los productos más vendidos.
     */
    public function topProductos()
    {
        $topProductos = Productos::orderByDesc('cantidad_vendida')->take(5)->get();
        return view('welcome', compact('topProductos'));
    }

    /**
     * Muestra productos en el inicio.
     */
    public function mostrarEnInicio()
    {
        $productos = Productos::take(5)->get();
        return view('welcome', compact('productos'));
    }

    public function buscar(Request $request)
    {
        $buscar = $request->input('buscar');

        $query = Productos::query();

        if ($buscar) {
            $query->where(function ($q) use ($buscar) {
                $q->where('nombre', 'LIKE', "%{$buscar}%")
                    ->orWhere('descripcion', 'LIKE', "%{$buscar}%")
                    ->orWhere('idproducto', $buscar);
            });
        }

        // Paginación con ruta personalizada
        $productos = $query->orderBy('nombre', 'asc')->paginate(10)->appends(request()->query());

        // Retornar la tabla con el paginador usando la ruta /productos
        return view('productos._tabla', compact('productos'))->render();
    }

}
