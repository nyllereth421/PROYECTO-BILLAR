@extends('adminlte::page')

@section('title', 'Gestión de Mesas')

@section('content_header')
    <h1><i class="fas fa-table"></i> Mesas y Mesas de Consumo</h1>
@stop

@section('content')
<div class="container-fluid">

    {{-- Botón volver --}}
    <div class="mb-3">
        <a href="{{ route('welcome') }}" class="btn btn-secondary">Volver al Inicio</a>
    </div>

    <div class="row">

        {{-- 🟢 MESAS NORMALES --}}
        @foreach($mesas as $mesa)
        <div class="col-md-3 mb-3">
            <div class="card {{ $mesa->estado == 'ocupada' ? 'card-danger' : ($mesa->estado == 'reservada' ? 'card-info' : 'card-success') }}">
                <div class="card-header text-center">
                    <h3 class="card-title">Mesa #{{ $mesa->numeromesa }}</h3>
                </div>
                <div class="card-body text-center">
                    <img src="{{ asset('img/mesas/' . $mesa->tipo . '.png') }}" class="img-fluid mb-2" style="height:120px;">
                    <p><strong>Estado:</strong> {{ $mesa->estado }}</p>

                    <div class="d-flex justify-content-center gap-2 flex-wrap">
                        @if($mesa->estado == 'disponible')
                        <form action="{{ route('mesas.iniciar', $mesa->idmesa) }}" method="POST">
                            @csrf
                            <button class="btn btn-success btn-sm"><i class="fas fa-play"></i></button>
                        </form>
                        @endif

                        @if($mesa->estado == 'ocupada')
                        <form action="{{ route('mesas.finalizar', $mesa->idmesa) }}" method="POST">
                            @csrf
                            <button class="btn btn-danger btn-sm"><i class="fas fa-stop"></i></button>
                        </form>
                        @endif

                        <form action="{{ route('mesas.estado', $mesa->idmesa) }}" method="POST" class="d-flex gap-1">
                            @csrf
                            <select name="estado" class="form-control form-control-sm">
                                <option {{ $mesa->estado=='disponible'?'selected':'' }}>disponible</option>
                                <option {{ $mesa->estado=='ocupada'?'selected':'' }}>ocupada</option>
                                <option {{ $mesa->estado=='reservada'?'selected':'' }}>reservada</option>
                            </select>
                            <button class="btn btn-primary btn-sm"><i class="fas fa-sync"></i></button>
                        </form>

                        <a href="{{ route('mesasventas.create', $mesa->idmesa) }}" class="btn btn-warning btn-sm"><i class="fas fa-cart-plus"></i></a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        {{-- 🔵 MESAS DE CONSUMO --}}
        @foreach($mesas_consumos as $mesa)
        <div class="col-md-3 mb-3">
            <div class="card {{ $mesa->estado == 'ocupada' ? 'card-danger' : ($mesa->estado == 'reservada' ? 'card-info' : 'card-success') }}">
                <div class="card-header text-center">
                    <h3 class="card-title">Mesa Consumo #{{ $mesa->idmesaconsumo }}</h3>
                </div>
                <div class="card-body text-center">
                    <img src="{{ asset('img/mesas/mesaconsumo.png') }}" style="height:120px;" class="img-fluid mb-2">
                    <p><strong>Estado:</strong> {{ $mesa->estado }}</p>

                    <div class="d-flex justify-content-center gap-2 flex-wrap">
                        <form action="{{ route('mesasconsumo.estado', $mesa->idmesaconsumo) }}" method="POST" class="d-flex gap-1">
                            @csrf
                            <select name="estado" class="form-control form-control-sm">
                                <option {{ $mesa->estado=='disponible'?'selected':'' }}>disponible</option>
                                <option {{ $mesa->estado=='ocupada'?'selected':'' }}>ocupada</option>
                                <option {{ $mesa->estado=='reservada'?'selected':'' }}>reservada</option>
                            </select>
                            <button class="btn btn-primary btn-sm"><i class="fas fa-sync"></i></button>
                        </form>
                        <a href="{{ route('mesasconsumo.agregar', $mesa->idmesaconsumo) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-plus"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

    </div>
</div>
@stop
