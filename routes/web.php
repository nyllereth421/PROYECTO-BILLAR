<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductosController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MetodopagosController;
use App\Http\Controllers\ProveedoresController;
use App\Http\Controllers\EmpleadosController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\MesasController;
use App\Http\Controllers\MesasConsumosController;
use App\Http\Controllers\MesasventasController;
use App\Models\mesasConsumos;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/productos/index',[ProductosController::class,'index'])->name('productos.index');
Route::get('/productos/create',[ProductosController::class,'create'])->name('productos.create');
Route::post('/productos/store',[ProductosController::class,'store'])->name('productos.store');
Route::get('/productos/{idproducto}/edit',[ProductosController::class,'edit'])->name('productos.edit');
Route::post('/productos/{idproducto}/update',[ProductosController::class,'update'])->name('productos.update');
Route::post('/productos/{idproducto}/destroy',[ProductosController::class,'destroy'])->name('productos.destroy');

//metodos de pago
Route::get('/metodopago/index',[MetodopagosController::class,'index'])->name('metodopago.index');
Route::get('/metodopago/create',[MetodopagosController::class,'create'])->name('metodopago.create');
Route::post('/metodopago/store',[MetodopagosController::class,'store'])->name('metodopago.store');
Route::get('/metodopago/{idmetodopago}/edit',[MetodopagosController::class,'edit'])->name('metodopago.edit');
Route::post('/metodopago/{idmetodopago}/update', [MetodopagosController::class,'update'])->name('metodopago.update');
Route::post('/metodopago/{idmetodopago}/destroy', [MetodopagosController::class,'destroy'])->name('metodopago.destroy');

//proveedores
Route::get('/proveedores/index',[ProveedoresController::class,'index'])->name('proveedores.index');
Route::get('/proveedores/create',[ProveedoresController::class,'create'])->name('proveedores.create');
Route::post('/proveedores/store',[ProveedoresController::class,'store'])->name('proveedores.store');
Route::get('/proveedores/{idproveedor}/edit',[ProveedoresController::class,'edit'])->name('proveedores.edit');
Route::post('/proveedores/{idproveedor}/update',[ProveedoresController::class,'update'])->name('proveedores.update');
Route::post('/proveedores/{idproveedor}/destroy',[ProveedoresController::class,'destroy'])->name('proveedores.destroy');



//empleados
Route::get('/empleados/index',[EmpleadosController::class,'index'])->name('empleados.index');
Route::get('/empleados/create',[EmpleadosController::class,'create'])->name('empleados.create');
Route::post('/empleados/store',[EmpleadosController::class,'store'])->name('empleados.store');
Route::get('/empleados/{numerodocumento}/edit',[EmpleadosController::class,'edit'])->name('empleados.edit');
Route::post('/empleados/{numerodocumento}/update',[EmpleadosController::class,'update'])->name('empleados.update');
Route::post('/empleados/{numerodocumento}/destroy',[EmpleadosController::class,'destroy'])->name('empleados.destroy');

//mesas

Route::get('/mesas/index', [MesasController::class, 'index'])->name('mesas.index');
Route::get('/mesas/create', [MesasController::class,   'create'])->name('mesas.create');
Route::post('/mesas/store', [MesasController::class,   'store'])->name('mesas.store');
Route::get('/mesas/{idmesa}/edit', [MesasController::class, 'edit'])->name('mesas.edit');
Route::post('/mesas/{idmesa}/update', [MesasController::class, 'update'])->name('mesas.update');
Route::post('/mesas/{idmesa}/destroy', [MesasController::class, 'destroy'])->name('mesas.destroy');
// rutas finciones mesas

//inventario
Route::get('/inventario/index',[InventarioController::class,'index'])->name('inventario.index');

Route::get('/mesasconsumo', [MesasConsumosController::class, 'index'])->name('mesasconsumo.index');

// Crear nueva mesa de consumo
Route::get('/mesasconsumo/create', [MesasConsumosController::class, 'create'])->name('mesasconsumo.create');
Route::post('/mesasconsumo/store', [MesasConsumosController::class, 'store'])->name('mesasconsumo.store');

// Editar mesa de consumo
Route::get('/mesasconsumo/{idmesaconsumo}/edit', [MesasConsumosController::class, 'edit'])->name('mesasconsumo.edit');
Route::post('/mesasconsumo/{idmesaconsumo}/update', [MesasConsumosController::class, 'update'])->name('mesasconsumo.update');

// Eliminar mesa de consumo
Route::post('/mesasconsumo/{idmesaconsumo}/destroy', [MesasConsumosController::class, 'destroy'])->name('mesasconsumo.destroy');

//  Cambiar estado (Libre, Ocupada, Reservada)
Route::post('/mesasconsumo/{idmesaconsumo}/estado', [MesasConsumosController::class, 'cambiarEstado'])->name('mesasconsumo.estado');

//  Agregar productos a la mesa de consumo
Route::get('/mesasconsumo/{idmesaconsumo}/agregar-producto', [MesasConsumosController::class, 'agregarProducto'])->name('mesasconsumo.agregar');

//  Guardar productos agregados
Route::post('/mesasconsumo/{idmesaconsumo}/guardar-producto', [MesasConsumosController::class, 'guardarProducto'])->name('mesasconsumo.guardar');




// mesasventas
Route::get('/mesasventas', [MesasventasController::class, 'index'])->name('mesasventas.index');
Route::get('/mesasventas/create', [MesasventasController::class, 'create'])->name('mesasventas.create');
Route::post('/mesasventas/store', [MesasventasController::class, 'store'])->name('mesasventas.store');
Route::get('/mesasventas/{id}/edit', [MesasventasController::class, 'edit'])->name('mesasventas.edit');
Route::post('/mesasventas/{id}/update', [MesasventasController::class, 'update'])->name('mesasventas.update');
Route::post('/mesasventas/{id}/destroy', [MesasventasController::class, 'destroy'])->name('mesasventas.destroy');

Route::post('/mesasconsumo/{idmesaconsumo}/estado', [MesasConsumosController::class, 'cambiarEstado'])->name('mesasconsumo.estado');
Route::get('/mesasconsumo/{idmesaconsumo}/agregar-producto', [MesasConsumosController::class, 'agregarProducto'])->name('mesasconsumo.agregar');
Route::post('/mesasconsumo/{idmesaconsumo}/guardar-producto', [MesasConsumosController::class, 'guardarProducto'])->name('mesasconsumo.guardar');


Route::get('/mesasventas', [MesasVentasController::class, 'index'])->name('mesasventas.index');

Route::get('/mesasventas/iniciar/{idmesa}', [MesasVentasController::class, 'iniciarTiempo'])->name('mesasventas.iniciar');

Route::get('/mesasventas/finalizar/{idmesa}', [MesasVentasController::class, 'finalizarTiempo'])->name('mesasventas.finalizar');

Route::post('/mesasventas/estado/{idmesa}', [MesasVentasController::class, 'actualizarEstado'])->name('mesasventas.estado');
Route::get('/mesasventas/{idmesa}', [MesasVentasController::class, 'show'])->name('mesasventas.show');


