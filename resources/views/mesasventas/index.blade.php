@extends('adminlte::page')

@section('title', 'Gestión de Mesas')

@section('content_header')
    <h1><i class="fas fa-table"></i> Mesas y Mesas de Consumo</h1>
@stop

@section('content')
<!-- Bootstrap 5 CSS (AdminLTE ya lo carga normalmente) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS + Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<style>
    .modal-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-bottom: none;
    }
    
    .modal-header .btn-close {
        filter: brightness(0) invert(1);
    }
    
    .modal-body {
        padding: 1.5rem;
        background-color: #f8f9fa;
    }
    
    .search-box {
        position: relative;
        margin-bottom: 1.5rem;
    }
    
    .search-box input {
        padding-left: 2.5rem;
        border-radius: 25px;
        border: 2px solid #e0e0e0;
        transition: all 0.3s ease;
    }
    
    .search-box input:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    
    .search-box i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #999;
    }
    
    .productos-table {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .productos-table thead {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .productos-table thead th {
        border: none;
        padding: 1rem;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }
    
    .productos-table tbody tr {
        transition: all 0.2s ease;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .productos-table tbody tr:hover {
        background-color: #f8f9ff;
        transform: scale(1.01);
    }
    
    .productos-table tbody td {
        padding: 1rem;
        vertical-align: middle;
    }
    
    .producto-nombre {
        font-weight: 600;
        color: #333;
    }
    
    .producto-precio {
        color: #28a745;
        font-weight: 700;
        font-size: 1.1rem;
    }
    
    .cantidad-input {
        border-radius: 8px;
        border: 2px solid #e0e0e0;
        text-align: center;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .cantidad-input:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    
    .btn-agregar {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border: none;
        border-radius: 8px;
        padding: 0.5rem 1.5rem;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 2px 5px rgba(40, 167, 69, 0.3);
    }
    
    .btn-agregar:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(40, 167, 69, 0.4);
        background: linear-gradient(135deg, #20c997 0%, #28a745 100%);
    }
    
    .modal-footer {
        background-color: #f8f9fa;
        border-top: 1px solid #e0e0e0;
    }
    
    .table-container {
        max-height: 400px;
        overflow-y: auto;
    }
    
    .table-container::-webkit-scrollbar {
        width: 8px;
    }
    
    .table-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .table-container::-webkit-scrollbar-thumb {
        background: #667eea;
        border-radius: 10px;
    }
    
    .table-container::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
</style>

<div class="container-fluid">

    <div class="mb-3">
        <a href="{{ route('welcome') }}" class="btn btn-secondary">Volver al Inicio</a>
        <a href="{{ route('mesas.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Agregar Mesa</a>
    </div>

    <div class="row">
        {{-- MESAS NORMALES --}}
        @foreach($mesas as $mesa)
        <div class="col-md-3 mb-3">
            <div class="card {{ $mesa->estado == 'ocupada' ? 'card-danger' : ($mesa->estado == 'reservada' ? 'card-info' : 'card-success') }}">
                <div class="card-header text-center">
                    <h3 class="card-title">Mesa #{{ $mesa->numeromesa }}</h3>
                </div>
                <div class="card-body text-center">
                    <img src="{{ asset('img/mesas/' . $mesa->tipo . '.png') }}" style="height:120px;">
                    <p><strong>Estado:</strong> {{ $mesa->estado }}</p>

                    {{-- Botones --}}
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
                                <button class="btn btn-danger btn-sm"><i class="fas fa-stop"></i> Fin de tiempo</button>
                            </form>
                        @endif

                        @if($mesa->fechainicio)
                            <p class="mt-2">
                                ⏱ <strong>Tiempo:</strong>
                                <span id="timer-{{ $mesa->idmesa }}" data-inicio="{{ $mesa->fechainicio }}">
                                    <span class="tiempo">00:00:00</span>
                                </span>
                            </p>
                        @endif

                        @if($mesa->fechainicio)
                            <p class="mt-2">
                                ⏱ <strong>Tiempo:</strong>
                                <span id="timer-{{ $mesa->idmesa }}" data-inicio="{{ $mesa->fechainicio }}">
                                    <span class="tiempo">00:00:00</span>
                                </span>
                            </p>
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

                        {{-- Botón abrir modal --}}
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#productosModal-{{ $mesa->idmesa }}">
                            <i class="fas fa-cart-plus"></i>
                        </button>
                    </div>

                    {{-- Mostrar tiempos --}}
                    @if($mesa->fechainicio)
                        <p class="mt-2">⏱ <strong>Inicio:</strong> {{ $mesa->fechainicio }}</p>
                    @endif
                    @if($mesa->fechafin)
                        <p>🕓 <strong>Fin:</strong> {{ $mesa->fechafin }}</p>
                        <p><strong>Total:</strong> {{ $mesa->total }} minutos</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- MODAL PRODUCTOS PARA CADA MESA --}}
        <div class="modal fade" id="productosModal-{{ $mesa->idmesa }}" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-utensils me-2"></i>Agregar Productos a Mesa #{{ $mesa->numeromesa }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="search-box">
                            <i class="fas fa-search"></i>
                            <input type="text" class="form-control" placeholder="Buscar producto por nombre..." id="buscarProducto-{{ $mesa->idmesa }}">
                        </div>
                        <div class="table-container">
                            <table class="table productos-table mb-0">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Precio</th>
                                        <th>Cantidad</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody id="tablaProductos-{{ $mesa->idmesa }}">
                                    @foreach($productos as $producto)
                                    <tr>
                                        <td class="producto-nombre">{{ $producto->nombre }}</td>
                                        <td class="producto-precio">${{ number_format($producto->precio, 0, ',', '.') }}</td>
                                        <td>
                                            <input type="number" class="form-control form-control-sm cantidad-input" value="1" min="1" id="cantidad-{{ $mesa->idmesa }}-{{ $producto->idproducto }}">
                                        </td>
                                        <td>
                                            <form action="{{ route('mesasventas.agregarProductos') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="idmesa" value="{{ $mesa->idmesa }}">
                                                <input type="hidden" name="idproducto" value="{{ $producto->idproducto }}">
                                                <input type="hidden" name="cantidad" class="cantidad-input">
                                                <button type="submit" class="btn btn-agregar btn-sm agregar-producto-btn" data-mesa="{{ $mesa->idmesa }}" data-producto="{{ $producto->idproducto }}">
                                                    <i class="fas fa-plus me-1"></i>Agregar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        {{-- MESAS DE CONSUMO --}}
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
                                <option {{ $mesa->estado=='disponible'?'selected':'' }}>Disponible</option>
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

        {{-- MODAL MESAS DE CONSUMO --}}
        <div class="modal fade" id="productosModalConsumo-{{ $mesa->idmesaconsumo }}" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-glass-cheers me-2"></i>Agregar Productos a Mesa Consumo #{{ $mesa->idmesaconsumo }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="search-box">
                            <i class="fas fa-search"></i>
                            <input type="text" class="form-control" placeholder="Buscar producto por nombre..." id="buscarProductoConsumo-{{ $mesa->idmesaconsumo }}">
                        </div>
                        <div class="table-container">
                            <table class="table productos-table mb-0">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Precio</th>
                                        <th>Cantidad</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody id="tablaProductosConsumo-{{ $mesa->idmesaconsumo }}">
                                    @foreach($productos as $producto)
                                    <tr>
                                        <td class="producto-nombre">{{ $producto->nombre }}</td>
                                        <td class="producto-precio">${{ number_format($producto->precio, 0, ',', '.') }}</td>
                                        <td>
                                            <input type="number" class="form-control form-control-sm cantidad-input" value="1" min="1" id="cantidad-consumo-{{ $mesa->idmesaconsumo }}-{{ $producto->idproducto }}">
                                        </td>
                                        <td>
                                            <form action="{{ route('mesasventas.agregarProductos') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="idmesaconsumo" value="{{ $mesa->idmesaconsumo }}">
                                                <input type="hidden" name="idproducto" value="{{ $producto->idproducto }}">
                                                <input type="hidden" name="cantidad" class="cantidad-input">
                                                <button type="submit" class="btn btn-agregar btn-sm agregar-producto-btn" data-mesa="{{ $mesa->idmesaconsumo }}" data-producto="{{ $producto->idproducto }}">
                                                    <i class="fas fa-plus me-1"></i>Agregar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Cerrar
                        </button>
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
    // Filtrar productos en mesas normales
    document.querySelectorAll('[id^=buscarProducto-]').forEach(input => {
        const mesaId = input.id.split('-')[1];
        input.addEventListener('keyup', function() {
            const filter = this.value.toLowerCase();
            document.querySelectorAll(`#tablaProductos-${mesaId} tr`).forEach(row => {
                const nombre = row.querySelector('td:first-child').textContent.toLowerCase();
                row.style.display = nombre.includes(filter) ? '' : 'none';
            });
        });
    });

    // Filtrar productos en mesas de consumo
    document.querySelectorAll('[id^=buscarProductoConsumo-]').forEach(input => {
        const mesaId = input.id.split('-')[1];
        input.addEventListener('keyup', function() {
            const filter = this.value.toLowerCase();
            document.querySelectorAll(`#tablaProductosConsumo-${mesaId} tr`).forEach(row => {
                const nombre = row.querySelector('td:first-child').textContent.toLowerCase();
                row.style.display = nombre.includes(filter) ? '' : 'none';
            });
        });
    });

    // ------------------------------
    // PASO 5: Asignar cantidad al enviar formulario
    // ------------------------------
    document.querySelectorAll('.agregar-producto-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const mesaId = this.dataset.mesa;
            const productoId = this.dataset.producto;

            // Buscar cantidad en mesas normales
            let cantidadInput = document.getElementById(`cantidad-${mesaId}-${productoId}`);
            // Si no existe, buscar en mesas de consumo
            if (!cantidadInput) {
                cantidadInput = document.getElementById(`cantidad-consumo-${mesaId}-${productoId}`);
            }

            if (cantidadInput) {
                // Asignar el valor al input oculto dentro del formulario
                this.closest('form').querySelector('.cantidad-input').value = cantidadInput.value;
            }
        });
    });
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll('[id^="timer-"]').forEach(timer => {
        const startTime = new Date(timer.dataset.inicio);
        const span = timer.querySelector(".tiempo");

        function actualizar() {
            const ahora = new Date();
            const diff = Math.floor((ahora - startTime) / 1000); // segundos
            const horas = Math.floor(diff / 3600);
            const minutos = Math.floor((diff % 3600) / 60);
            const segundos = diff % 60;
            span.textContent = 
                `${horas.toString().padStart(2, '0')}:${minutos.toString().padStart(2, '0')}:${segundos.toString().padStart(2, '0')}`;
        }

        actualizar();
        setInterval(actualizar, 1000);
    });
    
});
<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll('[id^="timer-"]').forEach(timer => {
        const startTime = new Date(timer.dataset.inicio);
        const span = timer.querySelector(".tiempo");

        function actualizar() {
            const ahora = new Date();
            const diff = Math.floor((ahora - startTime) / 1000); // segundos
            const horas = Math.floor(diff / 3600);
            const minutos = Math.floor((diff % 3600) / 60);
            const segundos = diff % 60;
            span.textContent =
                `${horas.toString().padStart(2, '0')}:${minutos.toString().padStart(2, '0')}:${segundos.toString().padStart(2, '0')}`;
        }

        actualizar();
        setInterval(actualizar, 1000);
    });
});
</script>
</script>
@stop
