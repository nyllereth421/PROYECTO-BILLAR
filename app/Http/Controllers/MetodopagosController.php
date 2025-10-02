<?php

namespace App\Http\Controllers;

use App\Models\metodopagos;
use Illuminate\Http\Request;

class MetodopagosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $metodopagos = metodopagos::all();
        return view('metodopago.index', compact('metodopagos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(metodopagos $metodopagos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(metodopagos $metodopagos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, metodopagos $metodopagos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(metodopagos $metodopagos)
    {
        //
    }
}
