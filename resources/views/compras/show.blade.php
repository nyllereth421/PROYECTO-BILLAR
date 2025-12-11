@extends('adminlte::page')

@section('title', 'Detalle de Compra #' . $compra->id)

@section('content_header')
    <div class="container-fluid">
        <div class="row align-items-center justify-content-between">
            <div class="col">
                <h1 class="text-dark"><i class="fas fa-receipt mr-2"></i> Detalle de Compra #{{ $compra->id }}</h1>
            </div>
            {{-- ACCIONES --}}
    <div class="mt-4">
        
        <a href="{{ route('compras.index') }}" class="btn btn-secondary btn-lg">
            <i class="fas fa-arrow-left mr-2"></i> Volver
        </a>
    </div>
        </div>
    </div>
@stop

@section('content')
<div class="container-fluid">
    {{-- INFORMACIÓN GENERAL --}}
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card card-outline card-primary shadow-lg">
                <div class="card-header bg-primary">
                    <h3 class="card-title"><i class="fas fa-info-circle mr-2"></i> Información de la Compra</h3>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-5">
                            <h6 class="mb-0 text-muted">ID de Compra</h6>
                        </div>
                        <div class="col-sm-7">
                            <strong>#{{ $compra->id }}</strong>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-5">
                            <h6 class="mb-0 text-muted">Fecha</h6>
                        </div>
                        <div class="col-sm-7">
                            <strong>
                                @if(is_object($compra->fecha_compra))
                                    {{ $compra->fecha_compra->format('d/m/Y H:i') }}
                                @else
                                    {{ \Carbon\Carbon::parse($compra->fecha_compra)->format('d/m/Y H:i') }}
                                @endif
                            </strong>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-5">
                            <h6 class="mb-0 text-muted">Estado</h6>
                        </div>
                        <div class="col-sm-7">
                            <span class="badge badge-success">Completada</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card card-outline card-info shadow-lg">
                <div class="card-header bg-info">
                    <h3 class="card-title"><i class="fas fa-truck mr-2"></i> Información del Proveedor</h3>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-5">
                            <h6 class="mb-0 text-muted">Proveedor</h6>
                        </div>
                        <div class="col-sm-7">
                            <strong>{{ $compra->proveedor->nombre }}</strong>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-5">
                            <h6 class="mb-0 text-muted">Contacto</h6>
                        </div>
                        <div class="col-sm-7">
                            <strong>{{ $compra->proveedor->contacto ?? 'N/A' }}</strong>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-5">
                            <h6 class="mb-0 text-muted">Dirección</h6>
                        </div>
                        <div class="col-sm-7">
                            <strong>{{ $compra->proveedor->direccion ?? 'N/A' }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- DETALLES + RESUMEN EN UNA SOLA FILA --}}
<div class="row">

    {{-- DETALLES DE LA COMPRA (OCUPA 8 COLUMNAS) --}}
    <div class="col-md-8">
        <div class="card card-outline card-success shadow-lg mb-4 rounded-4">
            <div class="card-header bg-success text-white rounded-top">
                <h3 class="card-title fw-bold"><i class="fas fa-box mr-2"></i> Detalles de la Compra</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive rounded-bottom">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="bg-light">
                            <tr class="text-center">
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio Unitario</th>
                                <th>Precio Venta</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($compra->detalles as $detalle)
                            <tr class="text-center">
                                <td class="fw-bold text-dark">{{ $detalle->producto->nombre }}</td>
                                <td>
                                    <span class="badge bg-info text-white rounded-pill px-3 py-2 shadow-sm">
                                        {{ $detalle->cantidad }}
                                    </span>
                                </td>
                                <td class="text-success fw-bold">
                                    ${{ number_format($detalle->precio_compra, 2, ',', '.') }}
                                </td>
                                <td class="text-primary fw-bold">
                                    {{ $detalle->precio_venta 
                                        ? '$' . number_format($detalle->precio_venta, 2, ',', '.') 
                                        : 'N/A' }}
                                </td>
                                <td class="fw-bold text-dark">
                                    ${{ number_format($detalle->subtotal, 2, ',', '.') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- RESUMEN (OCUPA 4 COLUMNAS) --}}
    <div class="col-md-4">
        <div class="card card-outline card-warning shadow-lg rounded-4">
            <div class="card-header bg-warning text-dark fw-bold rounded-top">
                <i class="fas fa-chart-pie mr-2"></i> Resumen
            </div>
            <div class="card-body">

                <div class="d-flex justify-content-between mb-3">
                    <span class="text-muted">Cantidad de Ítems</span>
                    <h5 class="fw-bold">{{ $compra->detalles->count() }}</h5>
                </div>

                <div class="d-flex justify-content-between">
                    <span class="text-muted">Costo Total</span>
                    <h4 class="text-success fw-bold">
                        ${{ number_format($compra->total, 2, ',', '.') }}
                    </h4>
                </div>

            </div>
        </div>
    </div>

</div>

    

@endsection
@section('js')
@include('components.sweetalert-global')
@stop
