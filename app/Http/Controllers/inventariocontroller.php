<?php

namespace App\Http\Controllers;

use App\Models\producto;
use App\Models\mesas;
use App\Models\productos;

class InventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = productos::all();
        $mesas = mesas::all();
        return view('inventario.index', compact('productos','mesas'));
    }

   
}
