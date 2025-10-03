<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductosController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MetodopagosController;
use App\Http\Controllers\ProveedoresController;
use App\Http\Controllers\EmpleadosController;

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
