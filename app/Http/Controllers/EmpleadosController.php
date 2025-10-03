<?php

namespace App\Http\Controllers;

use App\Models\empleados;
use Illuminate\Http\Request;

class EmpleadosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $empleados = empleados::all();
        return view('empleados.index', compact('empleados'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('empleados.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        empleados::create($request->all());
        return redirect()->route('empleados.index')->with('success', 'Empleado creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(empleados $empleados)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    
    public function edit($numerodocumento)
    {
        $empleados = empleados::findOrFail($numerodocumento);
        return view('empleados.edit', compact('empleados'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $numerodocumento)
    {
        $empleados = empleados::findOrFail($numerodocumento);
        $empleados->update($request->all());
        return redirect()->route('empleados.index')->with('success', 'Empleado actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($numerodocumento)
    {
        $empleados = empleados::findOrFail($numerodocumento);
        $empleados->delete();
        return redirect()->route('empleados.index')->with('success', 'Empleado eliminado exitosamente.');
    }
}
