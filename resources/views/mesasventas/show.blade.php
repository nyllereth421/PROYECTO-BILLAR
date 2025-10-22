@extends('adminlte::page')

@section('title', 'Mesa #' . $mesa->id)

@section('content_header')
<h1>Mesa #{{ $mesa->id }}</h1>
@stop

@section('content')

<!-- Mensajes de éxito -->
@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<!-- Información de la mesa -->
<div class="card mb-3">
    <div class="card-body">
        <h5>Información de la mesa</h5>
        <p><strong>Nombre:</strong> {{ $mesa->nombre ?? 'Mesa ' . $mesa->id }}</p>
        <p><strong>Estado:</strong> {{ $mesa->estado }}</p>
    </div>
</div>

<!-- Botón para agregar productos -->
<button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#productosModal">
    Agregar Productos
</button>

<!-- Tabla de productos en la mesa -->
<h5>Productos en la mesa</h5>
<table class="table table-bordered" id="productosMesa">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        @foreach($productosMesa as $producto)
        <tr>
            <td>{{ $producto->nombre }}</td>
            <td>{{ $producto->precio }}</td>
            <td>
                <input type="number" value="{{ $producto->pivot->cantidad }}" class="form-control cantidad" style="width:80px;">
            </td>
            <td>
                <button class="btn btn-danger btn-sm eliminar">Eliminar</button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Modal de productos -->
<div class="modal fade" id="productosModal" tabindex="-1" aria-labelledby="productosModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productosModalLabel">Selecciona Productos</h5>
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
                                    data-id="{{ $producto->id }}"
                                    data-nombre="{{ $producto->nombre }}"
                                    data-precio="{{ $producto->precio }}">
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

@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Agregar productos a la tabla de la mesa
    const botones = document.querySelectorAll('.agregar-producto');
    botones.forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const nombre = this.dataset.nombre;
            const precio = this.dataset.precio;

            const tabla = document.getElementById('productosMesa');
            const fila = document.createElement('tr');
            fila.innerHTML = `
                <td>${nombre}</td>
                <td>${precio}</td>
                <td><input type="number" value="1" class="form-control cantidad" style="width:80px;"></td>
                <td><button class="btn btn-danger btn-sm eliminar">Eliminar</button></td>
            `;
            tabla.appendChild(fila);

            // Cerrar modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('productosModal'));
            modal.hide();
        });
    });

    // Eliminar producto de la mesa
    document.addEventListener('click', function(e) {
        if(e.target.classList.contains('eliminar')) {
            e.target.closest('tr').remove();
        }
    });
});
</script>
@stop
