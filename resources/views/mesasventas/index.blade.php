@extends('adminlte::page')

@section('title', 'Gestión de Mesas')

@section('content_header')
    <h1><i class="fas fa-table"></i> Mesas y Mesas de Consumo</h1>
@stop

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<style>
    /* (Tu mismo estilo sin cambios) */
    .modal-header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-bottom: none; }
    .modal-header .btn-close { filter: brightness(0) invert(1); }
    .modal-body { padding: 1.5rem; background-color: #f8f9fa; }
    .search-box { position: relative; margin-bottom: 1.5rem; }
    .search-box input { padding-left: 2.5rem; border-radius: 25px; border: 2px solid #e0e0e0; transition: all 0.3s ease; }
    .search-box input:focus { border-color: #667eea; box-shadow: 0 0 0 0.2rem rgba(102,126,234,0.25); }
    .search-box i { position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #999; }
    .productos-table { background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
    .productos-table thead { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
    .productos-table tbody tr:hover { background-color: #f8f9ff; transform: scale(1.01); }
    .producto-nombre { font-weight: 600; color: #333; }
    .producto-precio { color: #28a745; font-weight: 700; font-size: 1.1rem; }
    .cantidad-input { border-radius: 8px; border: 2px solid #e0e0e0; text-align: center; font-weight: 600; }
    .btn-agregar { background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border: none; color: white; font-weight: 600; border-radius: 8px; }
    .table-container { max-height: 400px; overflow-y: auto; }
    .cronometro {
        font-weight: bold;
        color: #444;
        background: #f3f3f3;
        padding: 6px 12px;
        border-radius: 8px;
        margin-bottom: 8px;
        display: inline-block;
    }
</style>

<div class="container-fluid">
    <div class="mb-3">
        <a href="{{ route('welcome') }}" class="btn btn-secondary">Volver al Inicio</a>
        
    </div>

    <div class="row">
        {{-- ================= MESAS NORMALES ================= --}}
        @foreach($mesas as $mesa)
        

        <div class="col-md-3 mb-3">
            <div class="card {{ $mesa->estado == 'ocupada' ? 'card-danger' : ($mesa->estado == 'reservada' ? 'card-info' : 'card-success') }}">
                <div class="card-header text-center">
                    <h3 class="card-title">Mesa #{{ $mesa->numeromesa }}</h3>
                </div>
                <div class="card-body text-center">
                    <img src="{{ asset('img/mesas/' . $mesa->tipo . '.png') }}" style="height:120px;">
                    <p><strong>Estado:</strong> {{ $mesa->estado }}</p>

                    {{-- 🔹 CRONÓMETRO 🔹 --}}
                    <div id="cronometro-{{ $mesa->idmesa }}" class="cronometro">00:00:00</div>

                    <div class="d-flex justify-content-center gap-2 flex-wrap">
                        @if($mesa->estado == 'disponible')
                        <form action="{{ route('mesasventas.iniciar', $mesa->idmesa) }}" method="POST" onsubmit="startTimer({{ $mesa->idmesa }})">
                            @csrf
                            <button class="btn btn-success btn-sm" title="Iniciar tiempo">
                                <i class="fas fa-play"></i>
                            </button>
                        </form>
                        @endif

                        @if($mesa->estado == 'ocupada')
                        <form action="{{ route('mesasventas.finalizar', $mesa->idmesa) }}" method="POST" onsubmit="stopTimer({{ $mesa->idmesa }})">
                            @csrf
                            <button class="btn btn-danger btn-sm" title="Parar tiempo">
                                <i class="fas fa-stop"></i>
                            </button>
                        </form>
                        @endif
                        @if($mesa->ventaActiva)
                          <a href="{{ route('ventas.factura', ['id' => $mesa->ventaActiva->id]) }}" class="btn btn-info btn-sm">
                              <i class="fas fa-file-invoice"></i> Factura
                          </a>
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

                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#productosModal-{{ $mesa->idmesa }}">
                            <i class="fas fa-cart-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- 🔸 Modal de productos para cada mesa -->
<div class="modal fade" id="productosModal-{{ $mesa->idmesa }}" tabindex="-1" aria-labelledby="productosModalLabel-{{ $mesa->idmesa }}" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      
      <div class="modal-header bg-warning">
        <h5 class="modal-title" id="productosModalLabel-{{ $mesa->idmesa }}">
          <i class="fas fa-cart-plus"></i> Agregar productos a Mesa #{{ $mesa->numeromesa }}
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <div class="modal-body">
        <form action="{{ route('mesasventas.agregarProductos', $mesa->idmesa) }}" method="POST">
          @csrf

          <table class="table table-bordered table-hover text-center align-middle">
            <thead class="table-dark">
              <tr>
                <th>Producto</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Agregar</th>
              </tr>
            </thead>
            <tbody>
              @foreach($productos as $producto)
                <tr>
                  <td>{{ $producto->nombre }}</td>
                  <td>${{ number_format($producto->precio, 0, ',', '.') }}</td>
                  <td>{{ $producto->stock }}</td>
                  <td>
                    <input type="number" name="cantidades[{{ $producto->id }}]" min="1" max="{{ $producto->cantidad }}" class="form-control text-center" value="1">
                  </td>
                  <td>
                    <input type="checkbox" name="productosSeleccionados[]" value="{{ $producto->id }}">
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>

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
<!-- 🔸 Fin modal -->

        @endforeach

        {{-- ================= MESAS DE CONSUMO ================= --}}
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
        @endforeach
    </div>
</div>
@stop

@section('js')
<script>
let timers = {};

function startTimer(id) {
    event.preventDefault();
    const startTime = Date.now();
    localStorage.setItem('startTime-' + id, startTime);
    updateTimer(id);
    timers[id] = setInterval(() => updateTimer(id), 1000);
    event.target.submit();
}

function stopTimer(id) {
    event.preventDefault();
    clearInterval(timers[id]);
    localStorage.removeItem('startTime-' + id);
    document.getElementById('cronometro-' + id).innerText = "00:00:00";
    event.target.submit();
}

function updateTimer(id) {
    const startTime = localStorage.getItem('startTime-' + id);
    if (!startTime) return;
    const diff = Math.floor((Date.now() - startTime) / 1000);
    const hours = String(Math.floor(diff / 3600)).padStart(2, '0');
    const minutes = String(Math.floor((diff % 3600) / 60)).padStart(2, '0');
    const seconds = String(diff % 60).padStart(2, '0');
    document.getElementById('cronometro-' + id).innerText = `${hours}:${minutes}:${seconds}`;
}

// Restaurar cronómetros activos
window.addEventListener('load', () => {
    Object.keys(localStorage).forEach(key => {
        if (key.startsWith('startTime-')) {
            const id = key.split('-')[1];
            updateTimer(id);
            timers[id] = setInterval(() => updateTimer(id), 1000);
        }
    });
});
</script>
@stop
