@extends('adminlte::page')

@section('title', 'Gestión de Productos')

@section('content_header')
    <h1 class="m-0 text-dark"><i class="fas fa-boxes"></i> Gestión de Productos</h1>
@stop

@section('content')
<div class="container-fluid">

    {{-- ALERTAS --}}
    @if(session('success'))
        <x-adminlte-alert theme="success" title="Éxito" dismissable>
            {{ session('success') }}
        </x-adminlte-alert>
    @endif

    @if(session('error'))
        <x-adminlte-alert theme="danger" title="Error" dismissable>
            {{ session('error') }}
        </x-adminlte-alert>
    @endif

    @if(session('alerta_stock'))
        <x-adminlte-alert theme="warning" title="Alerta de Stock" dismissable>
            <i class="fas fa-box-open"></i> {{ session('alerta_stock') }}
        </x-adminlte-alert>
    @endif

    {{-- FILTROS Y BUSCADOR --}}
    <div class="row">
        <div class="col-12">
            <x-adminlte-card title="Filtros y Acciones" theme="info" icon="fas fa-filter" collapsible>
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div class="d-flex mb-3 mb-md-0 me-md-3 flex-grow-1">
                        <input type="text" id="buscarProducto" class="form-control me-2" placeholder="Buscar por nombre o descripción...">
                        <button type="button" class="btn btn-outline-primary" id="btnLimpiar">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </div>
            
                    <a href="{{ route('productos.create') }}" class="btn btn-success">
                        <i class="fas fa-plus-circle"></i> Agregar Producto
                    </a>
                </div>
            </x-adminlte-card>
        </div>
    </div>

    {{-- TABLA DE PRODUCTOS --}}
    <div class="card shadow-sm">
        <div class="card-header bg-gradient-primary">
            <h3 class="card-title"><i class="fas fa-list-alt"></i> Listado de Productos</h3>
        </div>
        <div class="card-body table-responsive p-0">
            @if(isset($productos) && $productos->count() > 0)
                <table class="table table-striped table-valign-middle" id="tablaProductos">
                    <thead class="bg-light">
                        <tr class="text-center">
                            <th style="width: 5%">ID</th>
                            <th style="width: 30%">Nombre</th>
                            <th style="width: 15%">Precio</th>
                            <th style="width: 20%">Stock Disponible</th>
                            <th style="width: 15%">Cantidad Vendida</th>
                            <th style="width: 15%">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($productos as $producto)
                            <tr>
                                <td class="text-center">{{ $producto->idproducto }}</td>
                                <td>{{ $producto->nombre }}</td>
                                <td class="text-end">${{ number_format($producto->precio, 2) }}</td>
                                <td class="text-center">
                                    @if($producto->stock < 10)
                                        <span class="badge bg-warning text-dark p-2">
                                            <i class="fas fa-exclamation-triangle"></i>
                                            Stock Bajo ({{ $producto->cantidad_disponible }} un.)
                                        </span>
                                    @else
                                        <span class="text-secondary">
                                            {{ $producto->stock }} unidades
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">{{ $producto->cantidad_vendida ?? 0 }}</td>
                                <td class="text-center">
                                    <a href="{{ route('productos.edit', $producto->idproducto) }}" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Editar">
                                        <i class="fa fa-lg fa-fw fa-pen"></i>
                                    </a>
                                    
                                    {{-- Formulario para Eliminar --}}
                            <button class="btn btn-secondary btn-sm" onclick="alert('❌ Este producto NO se puede eliminar');">
                                <i class="fas fa-ban"></i> Eliminar
                            </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-secondary m-3 text-center">
                    <i class="fas fa-info-circle"></i> No hay productos registrados.
                </div>
            @endif
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    console.log('Vista de productos lista 🟢');

    // Filtro en tiempo real
    document.getElementById('buscarProducto').addEventListener('keyup', function() {
        let filtro = this.value.toLowerCase();
        let filas = document.querySelectorAll('#tablaProductos tbody tr');

        filas.forEach(fila => {
            let texto = fila.textContent.toLowerCase();
            fila.style.display = texto.includes(filtro) ? '' : 'none';
        });
    });

    // Botón para limpiar el buscador y mostrar todo de nuevo
    document.getElementById('btnLimpiar').addEventListener('click', function() {
        document.getElementById('buscarProducto').value = '';
        let filas = document.querySelectorAll('#tablaProductos tbody tr');
        filas.forEach(fila => fila.style.display = '');
    });
</script>
@stop
