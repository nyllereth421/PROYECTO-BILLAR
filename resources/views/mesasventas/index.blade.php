@extends('adminlte::page')

@section('title', 'Gestión de Mesas')

@section('content_header')
    <h1><i class="fas fa-table"></i> Mesas y Mesas de Consumo</h1>
@stop

@section('content')
<div class="container-fluid">

    <div class="mb-3">
        <a href="{{ route('welcome') }}" class="btn btn-secondary">Volver al Inicio</a>
    </div>

    <div class="row">
        {{-- ✅ MESAS NORMALES --}}
        @foreach($mesas as $mesa)
        <div class="col-md-3 mb-3">
            <div class="card {{ $mesa->estado == 'ocupada' ? 'card-danger' : ($mesa->estado == 'reservada' ? 'card-info' : 'card-success') }}">
                <div class="card-header text-center">
                    <h3 class="card-title">Mesa #{{ $mesa->numeromesa }}</h3>
                </div>
                <div class="card-body text-center">
                    <img src="{{ asset('img/mesas/' . $mesa->tipo . '.png') }}" style="height:120px;">
                    <p><strong>Estado:</strong> {{ $mesa->estado }}</p>

                    <div class="d-flex justify-content-center gap-2 flex-wrap">
                        @if($mesa->estado == 'disponible')
                        <form action="{{ route('mesasventas.iniciar', $mesa->idmesa) }}" method="POST">
                            @csrf
                            <button class="btn btn-success btn-sm"><i class="fas fa-play"></i></button>
                        </form>
                        @endif

                        @if($mesa->estado == 'ocupada')
                        <form action="{{ route('mesasventas.finalizar', $mesa->idmesa) }}" method="POST">
                            @csrf
                            <button class="btn btn-danger btn-sm"><i class="fas fa-stop"></i></button>
                        </form>
                        @endif

                        <form action="{{ route('mesasventas.estado', $mesa->idmesa) }}" method="POST" class="d-flex gap-1">
                            @csrf
                            <select name="estado" class="form-control form-control-sm">
                                <option {{ $mesa->estado=='disponible'?'selected':'' }}>Disponible</option>
                                <option {{ $mesa->estado=='ocupada'?'selected':'' }}>Ocupada</option>
                                <option {{ $mesa->estado=='reservada'?'selected':'' }}>Reservada</option>
                            </select>
                            <button class="btn btn-primary btn-sm"><i class="fas fa-sync"></i></button>
                        </form>

                        {{-- Modal productos --}}
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#productosModal-{{ $mesa->idmesa }}">
                            <i class="fas fa-cart-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- ✅ MODAL PRODUCTOS PARA CADA MESA NORMAL --}}
        <div class="modal fade" id="productosModal-{{ $mesa->idmesa }}" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Agregar Productos a Mesa #{{ $mesa->numeromesa }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" class="form-control mb-3" placeholder="Buscar producto..." id="buscarProducto-{{ $mesa->idmesa }}">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Precio</th>
                                    <th>Agregar</th>
                                </tr>
                            </thead>
                            <tbody id="tablaProductos-{{ $mesa->idmesa }}">
                                @foreach($productos as $producto)
                                <tr>
                                    <td>{{ $producto->nombre }}</td>
                                    <td>{{ $producto->precio }}</td>
                                    <td>
                                        <button class="btn btn-success btn-sm agregar-producto"
                                            data-id="{{ $producto->idproducto }}"
                                            data-nombre="{{ $producto->nombre }}"
                                            data-precio="{{ $producto->precio }}"
                                            data-mesa="{{ $mesa->idmesa }}">
                                            Agregar
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        {{-- ✅ MESAS DE CONSUMO --}}
        @foreach($mesas_consumos as $mesa)
        <div class="col-md-3 mb-3">
            <div class="card {{ $mesa->estado == 'ocupada' ? 'card-danger' : ($mesa->estado == 'reservada' ? 'card-info' : 'card-success') }}">
                <div class="card-header text-center">
                    <h3 class="card-title">Mesa Consumo #{{ $mesa->idmesaconsumo }}</h3>
                </div>
                <div class="card-body text-center">
                    <img src="{{ asset('img/mesas/mesaconsumo.png') }}" style="height:120px;">
                    <p><strong>Estado:</strong> {{ $mesa->estado }}</p>

                    <div class="d-flex justify-content-center gap-2 flex-wrap">
                        <form action="{{ route('mesasconsumo.estado', $mesa->idmesaconsumo) }}" method="POST" class="d-flex gap-1">
                            @csrf
                            <select name="estado" class="form-control form-control-sm">
                                <option {{ $mesa->estado=='disponible'?'selected':'' }}>Libre</option>
                                <option {{ $mesa->estado=='ocupada'?'selected':'' }}>Ocupada</option>
                                <option {{ $mesa->estado=='reservada'?'selected':'' }}>Reservada</option>
                            </select>
                            <button class="btn btn-primary btn-sm"><i class="fas fa-sync"></i></button>
                        </form>

                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#productosModalConsumo-{{ $mesa->idmesaconsumo }}">
                            <i class="fas fa-cart-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- ✅ MODAL PARA MESAS DE CONSUMO --}}
        <div class="modal fade" id="productosModalConsumo-{{ $mesa->idmesaconsumo }}" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Agregar Productos a Mesa Consumo #{{ $mesa->idmesaconsumo }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Precio</th>
                                    <th>Agregar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($productos as $producto)
                                <tr>
                                    <td>{{ $producto->nombre }}</td>
                                    <td>{{ $producto->precio }}</td>
                                    <td>
                                        <button class="btn btn-success btn-sm agregar-producto"
                                            data-id="{{ $producto->idproducto }}"
                                            data-nombre="{{ $producto->nombre }}"
                                            data-precio="{{ $producto->precio }}"
                                            data-mesa="{{ $mesa->idmesaconsumo }}">
                                            Agregar
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

    </div>
</div>
@stop

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.agregar-producto').forEach(btn => {
        btn.addEventListener('click', function() {
            const nombre = this.dataset.nombre;
            const mesa = this.dataset.mesa;
            console.log(`Producto ${nombre} agregado a mesa ${mesa}`);

            const modal = this.closest('.modal');
            const modalInstance = bootstrap.Modal.getOrCreateInstance(modal);
            modalInstance.hide();
        });
    });
});
</script>
@stop
