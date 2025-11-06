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


// MESAS DE CONSUMO
Route::get('/mesasconsumo', [MesasConsumosController::class, 'index'])->name('mesasconsumo.index');
Route::get('/mesasconsumo/create', [MesasConsumosController::class, 'create'])->name('mesasconsumo.create');
Route::post('/mesasconsumo/store', [MesasConsumosController::class, 'store'])->name('mesasconsumo.store');
Route::get('/mesasconsumo/{idmesaconsumo}/edit', [MesasConsumosController::class, 'edit'])->name('mesasconsumo.edit');
Route::post('/mesasconsumo/{idmesaconsumo}/update', [MesasConsumosController::class, 'update'])->name('mesasconsumo.update');
Route::post('/mesasconsumo/{idmesaconsumo}/destroy', [MesasConsumosController::class, 'destroy'])->name('mesasconsumo.destroy');
Route::post('/mesasconsumo/{idmesaconsumo}/estado', [MesasConsumosController::class, 'cambiarEstado'])->name('mesasconsumo.estado');

Route::post('/mesasconsumo/agregar-productos', [MesasConsumosController::class, 'agregarProductos'])->name('mesasconsumo.agregarProductos');
Route::post('/mesasconsumo/{idmesaconsumo}/estado', [MesasConsumosController::class, 'cambiarEstado'])->name('mesasconsumo.estado');
Route::get('/mesasconsumo/{idmesaconsumo}/agregar-producto', [MesasConsumosController::class, 'agregarProducto'])->name('mesasconsumo.agregar');
Route::post('/mesasconsumo/{idmesaconsumo}/guardar-producto', [MesasConsumosController::class, 'guardarProducto'])->name('mesasconsumo.guardar');
Route::get('/mesasconsumo/{idmesaconsumo}/agregarproducto', [MesasConsumosController::class, 'agregarProducto'])->name('mesasconsumo.agregar');
Route::post('/mesasconsumo/{idmesaconsumo}/guardarproducto', [MesasConsumosController::class, 'guardarProducto'])->name('mesasconsumo.guardar');


// MESAS VENTAS
Route::get('/mesasventas', [MesasventasController::class, 'index'])->name('mesasventas.index');
Route::get('/mesasventas/create', [MesasventasController::class, 'create'])->name('mesasventas.create');
Route::post('/mesasventas/store', [MesasventasController::class, 'store'])->name('mesasventas.store');
Route::get('/mesasventas/{id}/edit', [MesasventasController::class, 'edit'])->name('mesasventas.edit');
Route::post('/mesasventas/{id}/update', [MesasventasController::class, 'update'])->name('mesasventas.update');
Route::post('/mesasventas/{id}/destroy', [MesasventasController::class, 'destroy'])->name('mesasventas.destroy');
Route::post('/mesasventas/pausar/{idmesa}', [MesasventasController::class, 'pausar'])->name('mesasventas.pausar');
Route::post('/mesasventas/{idmesa}/iniciar', [MesasventasController::class, 'iniciar'])->name('mesasventas.iniciar');
Route::get('/mesasventas/{idmesa}', [MesasventasController::class, 'show'])->name('mesasventas.show');
// Finalizar tiempo de una mesa
Route::post('/mesasventas/{idmesa}/finalizar', [MesasventasController::class, 'finalizar'])->name('mesasventas.finalizar');
// Cambiar estado de una mesa
Route::post('/mesasventas/{idmesa}/estado', [MesasventasController::class, 'actualizarEstado'])->name('mesasventas.estado');
// Agregar productos a una mesa
Route::post('/mesasventas/{idmesa}/agregar-productos', [MesasventasController::class, 'agregarProductos'])->name('mesasventas.agregarProductos');
// Reiniciar tiempo (opcional)
Route::post('/mesasventas/{idmesa}/reiniciar', [MesasventasController::class, 'reiniciar'])->name('mesasventas.reiniciar');

// ------------------------- VENTAS -----------------------------------
Route::post('/ventas/store', [VentasController::class, 'store'])->name('ventas.store');
Route::get('/ventas/{id}/factura', [VentasController::class, 'showFactura'])->name('ventas.factura');
=======
Route::get('/mesasventas/{idmesa}', [MesasventasController::class, 'show'])->name('mesasventas.show');

Route::post('/mesasventas/{idmesa}/iniciar', [MesasventasController::class, 'iniciar'])->name('mesasventas.iniciar');
Route::post('/mesasventas/{idmesa}/finalizar', [MesasventasController::class, 'finalizar'])->name('mesasventas.finalizar');
Route::post('/mesasventas/{idmesa}/estado', [MesasventasController::class, 'actualizarEstado'])->name('mesasventas.estado');
Route::post('/mesasventas/{idmesa}/reiniciar', [MesasventasController::class, 'reiniciar'])->name('mesasventas.reiniciar');

// Agregar productos (mesas normales)
Route::post('/mesasventas/{idmesa}/agregarproductos', [MesasventasController::class, 'agregarProductos'])
    ->name('mesasventas.agregarProductos');

// Agregar productos (mesas de consumo)
Route::post('/mesasventas/{idmesa}/agregarproductosconsumo', [MesasventasController::class, 'agregarProductosConsumo'])
    ->name('mesasventas.agregarProductosConsumo');

// VENTAS - factura
Route::post('/ventas/store', [VentasController::class, 'store'])->name('ventas.store');
Route::get('/ventas/{id}/factura', [VentasController::class, 'showFactura'])->name('ventas.factura');











