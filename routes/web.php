<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductosController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/productos',[ProductosController::class,'index'])->name('productos.index');
Route::get('/productos/create',[ProductosController::class,'create'])->name('productos.create');
Route::post('/productos',[ProductosController::class,'store'])->name('productos.store');
Route::get('/productos/{id}/edit',[ProductosController::class,'edit'])->name('productos.edit');
Route::post('/productos/{id}',[ProductosController::class,'update'])->name('productos.update');
Route::post('/productos/{id}',[ProductosController::class,'destroy'])->name('productos.destroy');
