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
                <div class="card border-{{ $mesa->estado == 'ocupada' ? 'danger' : ($mesa->estado == 'reservada' ? 'warning' : 'success') }}">
                    <div class="card-header">
                        <h5 class="card-title">Mesa #{{ $mesa->numeromesa }}</h5>
                        <span class="badge badge-{{ $mesa->estado == 'ocupada' ? 'danger' : ($mesa->estado == 'reservada' ? 'warning' : 'success') }}">
                            {{ ucfirst($mesa->estado) }}
                        </span>
                    </div>
                    <div class="card-body">
                        <p><strong>Tipo:</strong> {{ ucfirst($mesa->tipo) }}</p>

                        <a href="{{route('productos.index', $mesa->idmesa)}}" class="btn btn-primary btn-sm mb-1">
                            <i class="fas fa-plus-circle"></i> Agregar Productos
                        </a>

                        <a href="#" class="btn btn-outline-info btn-sm mb-1">
                            <i class="fas fa-clock"></i> Iniciar Tiempo
                        </a>

                        <a href="#" class="btn btn-outline-danger btn-sm mb-1">
                            <i class="fas fa-stop-circle"></i> Terminar Tiempo
                        </a>
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{ route('mesas.edit', $mesa->idmesa) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@stop
