@extends('adminlte::page')

@section('title', 'Mesas Consumo')

@section('content_header')
    <h1><i class="fas fa-chair"></i> Gestión de Mesas de Consumo</h1>
@stop

@section('content')
<div class="container-fluid">
    <div>
        <a href="{{ route('welcome') }}" class="btn btn-secondary">Volver al Inicio</a>
    </div>

    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('mesasconsumo.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Nueva Mesa de Consumo
        </a>
    </div>

    <div class="row">
        @foreach($mesas_consumos as $mesa)
            <div class="col-md-4">
                <div class="card 
                    {{ $mesa->estado == 'ocupada' ? 'card-danger' : 
                    ($mesa->estado == 'reservada' ? 'card-info' : 'card-success') }}">
                    
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Mesa Consumo #{{ $mesa->idmesaconsumo }}</h3>
                        <span class="badge bg-secondary">{{ ucfirst($mesa->estado) }}</span>
                    </div>

                    <div class="card-body text-center">
                        {{-- Mostrar información del consumo --}}
                        <p class="mb-2"><strong>Consumos:</strong> {{ $mesa->consumos }}</p>

                        {{-- Imagen genérica o personalizada --}}
                        <img src="{{ asset('img/mesas/mesaconsumo.png') }}" 
                             alt="Mesa consumo" 
                             class="img-fluid mb-2" 
                             style="height: 150px; object-fit: contain;">

                        {{-- Botones de acción --}}
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('mesasconsumo.edit', $mesa->idmesaconsumo) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-edit"></i> Editar
                            </a>

                            <form action="{{ route('mesasconsumo.destroy', $mesa->idmesaconsumo) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('¿Estás seguro de eliminar esta mesa de consumo?');">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash-alt"></i> Eliminar
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        @endforeach
    </div>
</div>
@stop
