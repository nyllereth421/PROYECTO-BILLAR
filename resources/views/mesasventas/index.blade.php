@extends('adminlte::page')

@section('title', 'Gestión de Mesas')

@section('content_header')
    <h1><i class="fas fa-table"></i> Gestión de Mesas y Consumo</h1>
@stop

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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
        box-shadow: 0 0 0 0.2rem rgba(102,126,234,0.25); 
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
    .productos-table tbody tr:hover { 
        background-color: #f8f9ff; 
        transform: scale(1.01); 
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
    } 
    .btn-agregar { 
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%); 
        border: none; 
        color: white; 
        font-weight: 600; 
        border-radius: 8px; 
    } 
    .table-container { 
        max-height: 400px; 
        overflow-y: auto; 
    } 
    .cronometro { 
        font-weight: bold; 
        color: #444; 
        background: #f3f3f3; 
        padding: 6px 12px; 
        border-radius: 8px; 
        margin-bottom: 8px; 
        display: inline-block; 
    }
    .card-mesa {
        border-width: 3px;
        transition: all 0.3s ease;
    }
    .card-mesa:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        transform: translateY(-2px);
    }
</style>

<div class="container-fluid">
    <div class="mb-3">
        <a href="{{ route('welcome') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver al Inicio
        </a>
    </div>

    {{-- Mensajes flash --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        {{-- ================= MESAS NORMALES ================= --}}
        @foreach($mesas as $mesa)
        <div class="col-md-3 mb-3">
            <div class="card card-mesa {{ $mesa->estado == 'ocupada' ? 'border-danger' : ($mesa->estado == 'reservada' ? 'border-info' : 'border-success') }}">
                <div class="card-header text-center">
                    <h4 class="card-title mb-0">Mesa #{{ $mesa->numeromesa }}</h4>
                </div>
                <div class="card-body text-center">
                    <img src="{{ asset('img/mesas/' . ($mesa->tipo ?? 'default') . '.png') }}" alt="mesa" style="height:110px;">
                    <p class="mt-2"><strong>Estado:</strong> {{ ucfirst($mesa->estado) }}</p>

                    <div id="cronometro-{{ $mesa->idmesa }}" class="cronometro">00:00:00</div>

                    <div class="d-flex justify-content-center gap-2 flex-wrap mt-3">
                        {{-- Iniciar / Parar --}}
                        @if($mesa->estado == 'disponible')
                            <form action="{{ route('mesasventas.iniciar', $mesa->idmesa) }}" method="POST" onsubmit="startTimer(event, {{ $mesa->idmesa }})">
                                @csrf
                                <button class="btn btn-success btn-sm" title="Iniciar">
                                    <i class="fas fa-play"></i>
                                </button>
                            </form>
                        @elseif($mesa->estado == 'ocupada')
                            <form action="{{ route('mesasventas.finalizar', $mesa->idmesa) }}" method="POST" onsubmit="stopTimer(event, {{ $mesa->idmesa }})">
                                @csrf
                                <button class="btn btn-danger btn-sm" title="Parar">
                                    <i class="fas fa-stop"></i>
                                </button>
                            </form>
                        @endif

                        {{-- Factura (si existe venta activa) --}}
                        @if(!empty($mesa->ventaActiva) && $mesa->ventaActiva)
                            <a href="{{ route('ventas.factura', $mesa->ventaActiva->id) }}" class="btn btn-info btn-sm" title="Ver factura">
                                <i class="fas fa-file-invoice"></i>
                            </a>
                        @endif

                        {{-- Cambiar estado --}}
                        <form action="{{ route('mesasventas.estado', $mesa->idmesa) }}" method="POST" class="d-flex gap-1">
                            @csrf
                            <select name="estado" class="form-control form-control-sm">
                                <option value="disponible" {{ $mesa->estado=='disponible'?'selected':'' }}>Disponible</option>
                                <option value="ocupada" {{ $mesa->estado=='ocupada'?'selected':'' }}>Ocupada</option>
                                <option value="reservada" {{ $mesa->estado=='reservada'?'selected':'' }}>Reservada</option>
                            </select>
                            <button class="btn btn-primary btn-sm" title="Actualizar estado">
                                <i class="fas fa-sync"></i>
                            </button>
                        </form>

                        {{-- Botón Carrito / Modal --}}
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#productosModal-{{ $mesa->idmesa }}">
                            <i class="fas fa-cart-plus"></i>
                        </button>

                        {{-- Botón para ver productos agregados --}}
                        @if($mesa->ventaActiva && $mesa->ventaActiva->productos->count() > 0)
                          <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#productosAgregadosModal-{{ $mesa->idmesa }}">
                              <i class="fas fa-eye"></i> Ver
                          </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal de productos agregados --}}
        @if(!empty($mesa->ventaActiva) && $mesa->ventaActiva->productos->count() > 0)
        <div class="modal fade" id="productosAgregadosModal-{{ $mesa->idmesa }}" tabindex="-1" aria-labelledby="productosAgregadosLabel-{{ $mesa->idmesa }}" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h5 class="modal-title" id="productosAgregadosLabel-{{ $mesa->idmesa }}">
                            Productos agregados a Mesa #{{ $mesa->numeromesa }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        {{-- Cronómetro --}}
                        <p><strong>Tiempo transcurrido:</strong> 
                            <span id="modal-cronometro-{{ $mesa->idmesa }}" class="badge bg-secondary">00:00:00</span>
                        </p>

                        {{-- Lista de productos --}}
                        <ul class="list-group">
                            @foreach($mesa->ventaActiva->productos as $producto)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $producto->nombre }}
                                    <span class="badge bg-primary rounded-pill">{{ $producto->pivot->cantidad }}</span>
                                </li>
                            @endforeach
                        </ul>
                        {{-- Total de la Venta Activa --}}
                        <h5 class="mt-3 text-end text-success">
                            <strong>Total Acumulado:</strong> ${{ number_format($mesa->ventaActiva->total, 0, ',', '.') }}
                        </h5>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- Modal de productos para mesa normal --}}
        <div class="modal fade" id="productosModal-{{ $mesa->idmesa }}" tabindex="-1" aria-labelledby="productosModalLabel-{{ $mesa->idmesa }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="productosModalLabel-{{ $mesa->idmesa }}">
                            Agregar productos a Mesa #{{ $mesa->numeromesa }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('mesasventas.agregarProductos', $mesa->idmesa) }}" method="POST">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover text-center align-middle">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Producto</th>
                                            <th>Precio</th>
                                            <th>Stock</th>
                                            <th>Cantidad</th>
                                            <th>Seleccionar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       
                                              @foreach($productos as $producto)
                                              <tr>
                                                  <td>{{ $producto->nombre }}</td>
                                                  <td>${{ number_format($producto->precio, 0, ',', '.') }}</td>
                                                  <td>{{ $producto->stock }}</td>
                                                  <td>
                                                      {{-- ¡CORRECCIÓN AQUÍ! Se usa el ID del producto como clave del array --}}
                                                      <input type="number" name="cantidades[{{ $producto->idproducto }}]" min="0" max="{{ $producto->stock }}" class="form-control text-center" value="0">
                                                  </td>
                                                  <td>
                                                      <input type="checkbox" name="productosSeleccionados[]" value="{{ $producto->idproducto }}">
                                                  </td>
                                              </tr>
                                              @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="text-end mt-3">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-check"></i> Agregar Seleccionados
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        {{-- ================= MESAS DE CONSUMO ================= --}}
        @foreach($mesas_consumos as $mesa)
        <div class="col-md-3 mb-3">
            <div class="card card-mesa {{ $mesa->estado == 'ocupada' ? 'border-danger' : ($mesa->estado == 'reservada' ? 'border-info' : 'border-success') }}">
                <div class="card-header text-center">
                    <h4 class="card-title mb-0">Mesa Consumo #{{ $mesa->idmesaconsumo }}</h4>
                </div>
                <div class="card-body text-center">
                    <img src="{{ asset('img/mesas/mesaconsumo.png') }}" alt="mesaconsumo" style="height:110px;">
                    <p class="mt-2"><strong>Estado:</strong> {{ ucfirst($mesa->estado) }}</p>

                    <div class="d-flex justify-content-center gap-2 flex-wrap mt-3">
                        {{-- Factura (si existe venta activa) --}}
                        @if(!empty($mesa->ventaActiva) && $mesa->ventaActiva)
                            <a href="{{ route('ventas.factura', $mesa->ventaActiva->id) }}" class="btn btn-info btn-sm" title="Ver factura">
                                <i class="fas fa-file-invoice"></i>
                            </a>
                        @endif
                        
                        {{-- Cambiar estado --}}
                        <form action="{{ route('mesasconsumo.estado', $mesa->idmesaconsumo) }}" method="POST" class="d-flex gap-1">
                            @csrf
                            <select name="estado" class="form-control form-control-sm">
                                <option value="disponible" {{ $mesa->estado=='disponible'?'selected':'' }}>Disponible</option>
                                <option value="ocupada" {{ $mesa->estado=='ocupada'?'selected':'' }}>Ocupada</option>
                                <option value="reservada" {{ $mesa->estado=='reservada'?'selected':'' }}>Reservada</option>
                            </select>
                            <button class="btn btn-primary btn-sm" title="Actualizar estado">
                                <i class="fas fa-sync"></i>
                            </button>
                        </form>

                        {{-- Botón Carrito / Modal Agregar Productos--}}
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#productosModalConsumo-{{ $mesa->idmesaconsumo }}">
                            <i class="fas fa-cart-plus"></i>
                        </button>
                        
                        {{-- Botón para ver productos agregados --}}
                        @if($mesa->ventaActiva && $mesa->ventaActiva->productos->count() > 0)
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#productosAgregadosModalConsumo-{{ $mesa->idmesaconsumo }}">
                                <i class="fas fa-eye"></i> Ver
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal de productos agregados para mesa consumo --}}
        @if(!empty($mesa->ventaActiva) && $mesa->ventaActiva->productos->count() > 0)
        <div class="modal fade" id="productosAgregadosModalConsumo-{{ $mesa->idmesaconsumo }}" tabindex="-1" aria-labelledby="productosAgregadosConsumoLabel-{{ $mesa->idmesaconsumo }}" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h5 class="modal-title" id="productosAgregadosConsumoLabel-{{ $mesa->idmesaconsumo }}">
                            Productos agregados a Mesa Consumo #{{ $mesa->idmesaconsumo }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        {{-- Lista de productos --}}
                        <ul class="list-group">
                            @foreach($mesa->ventaActiva->productos as $producto)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $producto->nombre }}
                                    <span class="badge bg-primary rounded-pill">{{ $producto->pivot->cantidad }}</span>
                                </li>
                            @endforeach
                        </ul>
                        {{-- Total de la Venta Activa --}}
                        <h5 class="mt-3 text-end text-success">
                            <strong>Total Acumulado:</strong> ${{ number_format($mesa->ventaActiva->total, 0, ',', '.') }}
                        </h5>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- Modal de productos para mesa consumo (Agregar) --}}
        <div class="modal fade" id="productosModalConsumo-{{ $mesa->idmesaconsumo }}" tabindex="-1" aria-labelledby="productosModalConsumoLabel-{{ $mesa->idmesaconsumo }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="productosModalConsumoLabel-{{ $mesa->idmesaconsumo }}">
                            Agregar productos a Mesa Consumo #{{ $mesa->idmesaconsumo }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('mesasventas.agregarProductosConsumo', $mesa->idmesaconsumo) }}" method="POST">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover text-center align-middle">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Producto</th>
                                            <th>Precio</th>
                                            <th>Stock</th>
                                            <th>Cantidad</th>
                                            <th>Seleccionar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($productos as $producto)
                                        <tr>
                                            <td>{{ $producto->nombre }}</td>
                                            <td>${{ number_format($producto->precio, 0, ',', '.') }}</td>
                                            <td>{{ $producto->stock }}</td>
                                            <td>
                                                <input type="number" name="cantidades[{{ $producto->idproducto }}]" min="0" max="{{ $producto->stock }}" class="form-control text-center" value="0">
                                            </td>
                                            <td>
                                                <input type="checkbox" name="productosSeleccionados[]" value="{{ $producto->idproducto }}">
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="text-end mt-3">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-check"></i> Agregar Seleccionados
                                </button>
                            </div>
                        </form>
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
let timers = {};

function startTimer(event, id) {
    event.preventDefault();
    const startTime = Date.now();
    localStorage.setItem('startTime-' + id, startTime);
    updateTimer(id);
    timers[id] = setInterval(() => updateTimer(id), 1000);
    event.target.submit();
}

function stopTimer(event, id) {
    event.preventDefault();
    clearInterval(timers[id]);
    localStorage.removeItem('startTime-' + id);
    const el = document.getElementById('cronometro-' + id);
    if (el) el.innerText = "00:00:00";
    event.target.submit();
}

function updateTimer(id) {
    const startTime = localStorage.getItem('startTime-' + id);
    if (!startTime) return;
    const diff = Math.floor((Date.now() - startTime) / 1000);
    const h = String(Math.floor(diff / 3600)).padStart(2, '0');
    const m = String(Math.floor((diff % 3600) / 60)).padStart(2, '0');
    const s = String(diff % 60).padStart(2, '0');
    const el = document.getElementById('cronometro-' + id);
    if (el) el.innerText = `${h}:${m}:${s}`;
}

window.addEventListener('load', () => {
    Object.keys(localStorage).forEach(key => {
        if (key.startsWith('startTime-')) {
            const id = key.split('-')[1];
            updateTimer(id);
            timers[id] = setInterval(() => updateTimer(id), 1000);
        }
    });
});
function syncModalTimer(id) {
    const mainEl = document.getElementById('cronometro-' + id);
    const modalEl = document.getElementById('modal-cronometro-' + id);
    if(mainEl && modalEl) {
        modalEl.innerText = mainEl.innerText;
    }
}

// Llamar cada segundo junto con updateTimer
function updateTimer(id) {
    const startTime = localStorage.getItem('startTime-' + id);
    if (!startTime) return;
    const diff = Math.floor((Date.now() - startTime) / 1000);
    const h = String(Math.floor(diff / 3600)).padStart(2, '0');
    const m = String(Math.floor((diff % 3600) / 60)).padStart(2, '0');
    const s = String(diff % 60).padStart(2, '0');
    const el = document.getElementById('cronometro-' + id);
    if (el) el.innerText = `${h}:${m}:${s}`;

    // Actualizar también el modal
    syncModalTimer(id);
}

</script>
@stop