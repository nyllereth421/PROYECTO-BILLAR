<?php

namespace App\Http\Controllers;

use App\Models\producto;
use App\Models\mesas;
use App\Models\productos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Proveedores;



class InventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = productos::all();
        $mesas = mesas::all();
        $productosTiempo = DB::table('productos')
        ->select('nombre', 'stock') // o la columna que quieras mostrar en la gráfica
        ->where('nombre', 'like', '%tiempo%')
        ->get();

        $proveedoresActivos = Proveedores::count();
        
        return view('inventario.index', compact('productos','mesas','productosTiempo','proveedoresActivos'));
    }

   
}
