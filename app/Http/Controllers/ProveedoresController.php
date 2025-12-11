<?php

namespace App\Http\Controllers;

use App\Models\Proveedores;
use Illuminate\Http\Request;
use App\Helpers\AlertHelper;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreProveedorRequest;
use App\Http\Requests\UpdateProveedorRequest;

class ProveedoresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $proveedores = proveedores::all();
         $totalStock = \DB::table('productos')->sum('stock');

    // lista de proveedores
    $proveedores = Proveedores::all();
        return view('proveedores.index', compact('proveedores','totalStock'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('proveedores.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProveedorRequest $request)
    {
        try {
            Proveedores::create($request->validated());
            AlertHelper::success('Proveedor creado exitosamente.');
            return redirect()->route('proveedores.index');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                AlertHelper::error('El proveedor ya existe.');
            } else {
                AlertHelper::error('Error al crear el proveedor: ' . $e->getMessage());
            }
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(proveedores $proveedores)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($idproveedor)
    {
        $proveedor = proveedores::findOrFail($idproveedor);
        return view('proveedores.edit', compact('proveedor'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProveedorRequest $request, $id)
    {
        try {
            $proveedor = Proveedores::findOrFail($id);
            $proveedor->update($request->validated());
            AlertHelper::success('Proveedor actualizado exitosamente.');
            return redirect()->route('proveedores.index');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                AlertHelper::error('El nombre del proveedor ya existe.');
            } else {
                AlertHelper::error('Error al actualizar el proveedor: ' . $e->getMessage());
            }
            return redirect()->back()->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $proveedor = Proveedores::findOrFail($id);
            $proveedor->delete();

            return redirect()->route('proveedores.index')->with('success', 'Proveedor eliminado exitosamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            // Capturar error de integridad referencial (foreign key)
            if ($e->getCode() == '23000') {
                return redirect()->route('proveedores.index')->with('error', 
                    'No se puede eliminar este proveedor porque tiene registros asociados (compras o productos). Elimina primero esos registros.');
            }
            // Otros errores de base de datos
            return redirect()->route('proveedores.index')->with('error', 'Error al eliminar el proveedor: ' . $e->getMessage());
        } catch (\Exception $e) {
            // Otros errores generales
            return redirect()->route('proveedores.index')->with('error', 'Error inesperado: ' . $e->getMessage());
        }
    }
}