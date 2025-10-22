<?php

namespace App\Http\Controllers;

use App\Models\productos;
use App\Models\mesas;

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
