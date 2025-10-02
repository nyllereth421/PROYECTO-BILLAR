<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductosController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MetodopagosController;
use App\Http\Controllers\ProveedoresController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/productos',[ProductosController::class,'index'])->name('productos.index');
Route::get('/productos/create',[ProductosController::class,'create'])->name('productos.create');
Route::post('/productos',[ProductosController::class,'store'])->name('productos.store');
Route::get('/productos/{idproducto}/edit',[ProductosController::class,'edit'])->name('productos.edit');
Route::post('/productos/{idproducto}/update',[ProductosController::class,'update'])->name('productos.update');
Route::post('/productos/{idproducto}/destroy',[ProductosController::class,'destroy'])->name('productos.destroy');

//metodos de pago
Route::get('/metodopago',[MetodopagosController::class,'index'])->name('metodopago.index');
Route::get('/metodopago/create',[MetodopagosController::class,'create'])->name('metodopago.create');
Route::post('/metodopago',[MetodopagosController::class,'store'])->name('metodopago.store');
Route::get('/metodopago/{idmetodopago}/edit',[MetodopagosController::class,'edit'])->name('metodopago.edit');
Route::post('/metodopago/{idmetodopago}/update', [MetodopagosController::class,'update'])->name('metodopago.update');
Route::post('/metodopago/{idmetodopago}/destroy', [MetodopagosController::class,'destroy'])->name('metodopago.destroy');

//proveedores
Route::get('/proveedores',[ProveedoresController::class,'index'])->name('proveedores.index');
Route::get('/proveedores/create',[ProveedoresController::class,'create'])->name('proveedores.create');
Route::post('/proveedores',[ProveedoresController::class,'store'])->name('proveedores.store');
Route::get('/proveedores/{idproveedor}/edit',[ProveedoresController::class,'edit'])->name('proveedores.edit');
Route::post('/proveedores/{idproveedor}/update',[ProveedoresController::class,'update'])->name('proveedores.update');
Route::post('/proveedores/{idproveedor}/destroy',[ProveedoresController::class,'destroy'])->name('proveedores.destroy');
