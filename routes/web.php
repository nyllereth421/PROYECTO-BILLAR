<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ProductosController;

Route::get('/', function () {
    return view('welcome');
});
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

//rutas de productos
Route::get('/productos/index', [ProductosController::class, 'index'])->name('productos.index');
Route::get('/productos/create', [ProductosController::class, 'create'])->name('productos.create');
Route::post('/productos/store', [ProductosController::class, 'store'])->name('productos.store');
Route::get('/productos/edit/{id}', [ProductosController::class, 'edit'])->name('productos.edit');
Route::post('/productos/update/{id}', [ProductosController::class, 'update'])->name('productos.update');
Route::post('/productos/destroy/{id}', [ProductosController::class, 'destroy'])->name('productos.destroy');
