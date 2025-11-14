<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\MetodopagosController;
use App\Http\Controllers\ProveedoresController;
use App\Http\Controllers\EmpleadosController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\MesasController;
use App\Http\Controllers\MesasConsumosController;
use App\Http\Controllers\MesasventasController;
use App\Http\Controllers\VentasController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\informescontroller;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

//WELOCME
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::get('/ingreso-dia', function () {
    $hoy = Carbon::now('America/Bogota')->toDateString();

    $ingresoDia = DB::table('mesasventas')
        ->whereDate(DB::raw('CONVERT_TZ(created_at, "+00:00", "-05:00")'), $hoy)
        ->sum('total') ?? 0;

    return response()->json(['ingresoDia' => $ingresoDia]);
});

Route::get('/ventas-semana', function () {
    $dias = ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'];
    $inicioSemana = Carbon::now('America/Bogota')->startOfWeek();

    $labels = [];
    $valores = [];

    for ($i = 0; $i < 7; $i++) {
        $fecha = $inicioSemana->copy()->addDays($i);
        $labels[] = $dias[$fecha->dayOfWeek];
        
        $total = DB::table('mesasventas')
            ->whereDate(DB::raw('CONVERT_TZ(created_at, "+00:00", "-05:00")'), $fecha->toDateString())
            ->sum('total') ?? 0;
            
        $valores[] = $total;
    }

    return response()->json([
        'labels' => $labels,
        'valores' => $valores,
    ]);
});

// Endpoint para obtener mesas ocupadas en tiempo real
Route::get('/mesas-ocupadas', function () {
    $total = \App\Models\Mesas::count();
    $ocupadas = \App\Models\Mesas::where('estado', 'ocupada')
        ->get(['idmesa', 'numeromesa', 'tipo']);

    return response()->json([
        'ocupadas' => $ocupadas->count(),
        'total' => $total,
        'mesas' => $ocupadas,
    ]);
});

// Endpoint para obtener la cantidad de productos registrados
Route::get('/productos-cantidad', function () {
    $cantidad = \App\Models\productos::count();
    return response()->json(['cantidad' => $cantidad]);
});





// ---------------------- PRODUCTOS ----------------------
Route::get('/productos/index', [ProductosController::class, 'index'])->name('productos.index');
Route::get('/productos/create', [ProductosController::class, 'create'])->name('productos.create');
Route::post('/productos/store', [ProductosController::class, 'store'])->name('productos.store');
Route::get('/productos/{idproducto}/edit', [ProductosController::class, 'edit'])->name('productos.edit');
Route::post('/productos/{idproducto}/update', [ProductosController::class, 'update'])->name('productos.update');
Route::post('/productos/{idproducto}/destroy', [ProductosController::class, 'destroy'])->name('productos.destroy');
Route::get('/', [ProductosController::class, 'mostrarEnInicio'])->name('welcome');


// ---------------------- MÉTODOS DE PAGO ----------------------
Route::get('/metodopago/index', [MetodopagosController::class, 'index'])->name('metodopago.index');
Route::get('/metodopago/create', [MetodopagosController::class, 'create'])->name('metodopago.create');
Route::post('/metodopago/store', [MetodopagosController::class, 'store'])->name('metodopago.store');
Route::get('/metodopago/{idmetodopago}/edit', [MetodopagosController::class, 'edit'])->name('metodopago.edit');
Route::post('/metodopago/{idmetodopago}/update', [MetodopagosController::class, 'update'])->name('metodopago.update');
Route::post('/metodopago/{idmetodopago}/destroy', [MetodopagosController::class, 'destroy'])->name('metodopago.destroy');

// ---------------------- INVENTARIO ----------------------
Route::get('/inventario/index', [InventarioController::class, 'index'])->name('inventario.index');
Route::get('/inventario/create', [InventarioController::class, 'create'])->name('inventario.create');
Route::post('/inventario/store', [InventarioController::class, 'store'])->name('inventario.store');
Route::get('/inventario/{id}/edit', [InventarioController::class, 'edit'])->name('inventario.edit');
Route::post('/inventario/{id}/update', [InventarioController::class, 'update'])->name('inventario.update');
Route::post('/inventario/{id}/destroy', [InventarioController::class, 'destroy'])->name('inventario.destroy');


// ---------------------- PROVEEDORES ----------------------
Route::get('/proveedores/index', [ProveedoresController::class, 'index'])->name('proveedores.index');
Route::get('/proveedores/create', [ProveedoresController::class, 'create'])->name('proveedores.create');
Route::post('/proveedores/store', [ProveedoresController::class, 'store'])->name('proveedores.store');
Route::get('/proveedores/{idproveedor}/edit', [ProveedoresController::class, 'edit'])->name('proveedores.edit');
Route::post('/proveedores/{idproveedor}/update', [ProveedoresController::class, 'update'])->name('proveedores.update');
Route::post('/proveedores/{idproveedor}/destroy', [ProveedoresController::class, 'destroy'])->name('proveedores.destroy');


// ---------------------- EMPLEADOS ----------------------
Route::get('/empleados/index', [EmpleadosController::class, 'index'])->name('empleados.index');
Route::get('/empleados/create', [EmpleadosController::class, 'create'])->name('empleados.create');
Route::post('/empleados/store', [EmpleadosController::class, 'store'])->name('empleados.store');
Route::get('/empleados/{numerodocumento}/edit', [EmpleadosController::class, 'edit'])->name('empleados.edit');
Route::post('/empleados/{numerodocumento}/update', [EmpleadosController::class, 'update'])->name('empleados.update');
Route::post('/empleados/{numerodocumento}/destroy', [EmpleadosController::class, 'destroy'])->name('empleados.destroy');


// ---------------------- MESAS NORMALES ----------------------
Route::get('/mesas/index', [MesasController::class, 'index'])->name('mesas.index');
Route::get('/mesas/create', [MesasController::class, 'create'])->name('mesas.create');
Route::post('/mesas/store', [MesasController::class, 'store'])->name('mesas.store');
Route::get('/mesas/{idmesa}/edit', [MesasController::class, 'edit'])->name('mesas.edit');
Route::post('/mesas/{idmesa}/update', [MesasController::class, 'update'])->name('mesas.update');
Route::post('/mesas/{idmesa}/destroy', [MesasController::class, 'destroy'])->name('mesas.destroy');


// MESAS VENTAS
Route::get('/mesasventas', [MesasventasController::class, 'index'])->name('mesasventas.index');
Route::get('/mesasventas/historial', [MesasventasController::class, 'historial'])->name('mesasventas.historial');
Route::get('/mesasventas/create', [MesasventasController::class, 'create'])->name('mesasventas.create');
Route::post('/mesasventas/store', [MesasventasController::class, 'store'])->name('mesasventas.store');
Route::get('/mesasventas/{idmesa}', [MesasventasController::class, 'show'])->name('mesasventas.show');
Route::post('/mesasventas/{id}/iniciar', [MesasventasController::class, 'iniciar'])->name('mesasventas.iniciar');
Route::post('/mesasventas/{idmesa}/finalizar', [MesasventasController::class, 'finalizar'])->name('mesasventas.finalizar');
Route::post('/mesasventas/{idmesa}/estado', [MesasventasController::class, 'actualizarEstado'])->name('mesasventas.estado');
Route::post('/mesasventas/{idmesa}/reiniciar', [MesasventasController::class, 'reiniciar'])->name('mesasventas.reiniciar');
Route::post('/mesasventas/{idmesa}/agregarproductos', [MesasventasController::class, 'agregarProductos'])->name('mesasventas.agregarProductos');
Route::post('/mesasventas/{idmesa}/agregarproductosconsumo', [MesasventasController::class, 'agregarProductosConsumo'])->name('mesasventas.agregarProductosConsumo');
Route::get('/mesasventas/{idmesa}/total', [MesasventasController::class, 'verTotalVenta'])->name('mesasventas.verTotalVenta');
Route::delete('ventas/{ventaId}/productos/{productoId}', [MesasventasController::class, 'eliminarProducto'])->name('mesasventas.eliminarProducto');
Route::post('/mesasventas/finalizarVenta/{venta}', [MesasventasController::class, 'finalizarVenta'])->name('mesasventas.finalizarVenta');
Route::post('/mesasventas/{idmesa}/cerrar', [MesasventasController::class, 'cerrarVenta'])->name('mesasventas.cerrarVenta');
Route::post('/mesasventas/{id}/parar', [MesasventasController::class, 'parar'])->name('mesasventas.parar');



// VENTAS - factura
Route::post('/ventas/store', [VentasController::class, 'store'])->name('ventas.store');
Route::get('/ventas/{id}/factura', [VentasController::class, 'showFactura'])->name('ventas.factura');
Route::get('/mesas/vertotal/{id}', [MesasVentasController::class, 'verTotalVenta'])->name('mesas.verTotalVenta');

// ---------------------- INFORMES ----------------------
Route::get('/informes', [informescontroller::class, 'index'])->name('informes.index');
Route::get('/api/informes/ventas-periodo', [informescontroller::class, 'ventasPorPeriodo'])->name('api.informes.ventas-periodo');
Route::get('/api/informes/productos-vendidos', [informescontroller::class, 'productosMasVendidos'])->name('api.informes.productos-vendidos');
Route::get('/api/informes/ingresos-metodo', [informescontroller::class, 'ingresosPorMetodoPago'])->name('api.informes.ingresos-metodo');
Route::get('/api/informes/ocupacion-mesas', [informescontroller::class, 'ocupacionMesas'])->name('api.informes.ocupacion-mesas');
Route::get('/api/informes/resumen', [informescontroller::class, 'resumenGeneral'])->name('api.informes.resumen');
Route::get('/api/informes/comparacion-meses', [informescontroller::class, 'comparacionMeses'])->name('api.informes.comparacion-meses');











