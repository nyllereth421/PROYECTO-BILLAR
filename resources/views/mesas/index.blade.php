@extends('adminlte::page')

@section('title', 'Mesas')

@section('content_header')
    <h1><i class="fas fa-table"></i> Gestión de Mesas</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="container-fluid">
        <div>
            <a href="{{ route('welcome') }}" class="btn btn-secondary">Volver al Inicio</a>
        </div>
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('mesas.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Nueva Mesa
            </a>
        </div>

        <div class="row">
            @foreach($mesas as $mesa)
                <div class="col-md-4">
                    <div class="card {{ $mesa->estado == 'ocupada' ? 'card-danger' : ($mesa->estado == 'reservada' ? 'card-info' : 'card-success') }}">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title">Mesa #{{ $mesa->numeromesa }}</h3>
                            <span class="badge bg-secondary">{{ ucfirst($mesa->tipo) }}</span>
                        </div>
                        <div class="card-body text-center">
                            {{-- Imagen según tipo de mesa --}}
                            <img src="{{ asset('img/mesas/' . $mesa->tipo . '.png') }}" alt="{{ $mesa->tipo }}" class="img-fluid mb-2" style="height: 150px; object-fit: contain;">

                            {{-- Formulario para actualizar estado --}}
                            <form action="{{ route('mesas.updateEstado', $mesa->idmesa) }}" method="POST" class="d-flex justify-content-center align-items-center gap-2 mb-2">
                                @csrf
                                @method('PUT')
                                <select name="estado" class="form-select form-select-sm w-auto">
                                    <option value="libre" {{ $mesa->estado == 'libre' ? 'selected' : '' }}>Libre</option>
                                    <option value="ocupada" {{ $mesa->estado == 'ocupada' ? 'selected' : '' }}>Ocupada</option>
                                    <option value="reservada" {{ $mesa->estado == 'reservada' ? 'selected' : '' }}>Reservada</option>
                                </select>
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                            </form>

                            {{-- Botones de acción --}}
                            <div class="d-flex justify-content-center gap-2">
                                {{-- Editar --}}
                                <a href="{{ route('mesas.edit', $mesa->idmesa) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i> Editar
                                </a>

                                {{-- Eliminar --}}
                                <form action="{{ route('mesas.destroy', $mesa->idmesa) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta mesa?');">
                                    @csrf
                                    
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash-alt"></i> Eliminar
                                    </button>
                                </form>
                            </div>

                            {{-- Agregar productos --}}
                            <a href="#" class="btn btn-warning btn-sm mt-2">
                                <i class="fas fa-utensils"></i> Agregar Productos
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@stop
