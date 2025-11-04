@extends('adminlte::page')

@section('title', 'Factura de Venta')

@section('content_header')
    <h1><i class="fas fa-file-invoice-dollar"></i> Factura de la Mesa #{{ $mesa->numeromesa }}</h1>
@stop

@section('content')
<div class="container">

    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title mb-0">Factura N° {{ $venta->id }}</h3>
        </div>

        <div class="card-body">

            {{-- Información general --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Fecha:</strong> {{ $venta->fecha }}</p>
                    <p><strong>Mesa:</strong> #{{ $mesa->numeromesa }}</p>
                    <p><strong>Estado:</strong> {{ ucfirst($mesa->estado) }}</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p><strong>Documento:</strong> {{ $venta->numerodocumento ?? 'N/A' }}</p>
                    <p><strong>Tiempo Jugado:</strong> {{ $tiempo ?? '00:00:00' }}</p>
                </div>
            </div>

            {{-- Productos consumidos --}}
            <h5 class="mb-3"><i class="fas fa-cocktail"></i> Productos consumidos</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center">
                    <thead class="table-secondary">
                        <tr>
                            <th>Producto</th>
                            <th>Descripción</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($productosVentas as $detalle)
                        <tr>
                            <td>{{ $detalle->producto->nombre }}</td>
                            <td>{{ $detalle->descripcion }}</td>
                            <td>{{ $detalle->cantidad }}</td>
                            <td>${{ number_format($detalle->producto->precio, 2) }}</td>
                            <td>${{ number_format($detalle->total, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <th colspan="4" class="text-end">Total Productos:</th>
                            <th>${{ number_format($totalProductos, 2) }}</th>
                        </tr>
                        <tr>
                            <th colspan="4" class="text-end">Total Tiempo ({{ $tiempo ?? '00:00:00' }}):</th>
                            <th>${{ number_format($totalTiempo, 2) }}</th>
                        </tr>
                        <tr>
                            <th colspan="4" class="text-end text-primary">Total General:</th>
                            <th class="text-primary">${{ number_format($venta->total, 2) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('mesasventas.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
                <button class="btn btn-success" onclick="window.print()">
                    <i class="fas fa-print"></i> Imprimir Factura
                </button>
            </div>
        </div>
    </div>
</div>
@stop
