<?php

namespace App\Http\Controllers;

use App\Models\mesas;
use Illuminate\Http\Request;

class MesasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mesas = mesas::all();
        return view('mesas.index', compact('mesas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mesas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        mesas::create($request->all());
        return redirect()->route('mesas.index')->with('success', 'Mesa creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(mesas $mesas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($idmesa)
    {
        $mesa = mesas::findorFail($idmesa);
        return view('mesas.edit', compact('mesa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $idmesa)
    {
        $mesa = mesas::findorFail($idmesa);
        $mesa->update($request->all());
        return redirect()->route('mesas.index')->with('success', 'Mesa actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($idmesa)
    {
        $mesa = mesas::findorFail($idmesa);
        $mesa->delete();
        return redirect()->route('mesas.index')->with('success', 'Mesa eliminada correctamente.');
    }
}
