<?php

namespace App\Http\Controllers;

use App\Models\proveedores;
use Illuminate\Http\Request;

class ProveedoresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $proveedores = proveedores::all();
        return view('proveedores.index', compact('proveedores'));
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
    public function store(Request $request)
    {
        proveedores::create($request->all());
        return redirect()->route('proveedores.index')->with('success', 'Proveedor creado correctamente.');
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
    public function update(Request $request, $idproveedor)
    {
        $proveedor = proveedores::findOrFail($idproveedor);
        $proveedor->update($request->all());

        return redirect()->route('proveedores.index')->with('success', 'Proveedor actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $proveedor = proveedores::findOrFail($id);
        $proveedor->delete();

        return redirect()->route('proveedores.index')->with('success', 'Proveedor eliminado correctamente.');
    }
}
