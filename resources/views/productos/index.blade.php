@extends('adminlte::page')

@section('title', 'Lista de Productos')

{{-- Incluir estilos si usas DataTables --}}
@section('css')
    {{-- Generalmente DataTables se configura con JS, pero si necesitas estilos específicos, irían aquí --}}
@stop

@section('content_header')
    <h1><i class="fas fa-box-open"></i> Productos</h1>
@stop

@section('content')
<div class="container-fluid">
    {{-- Mensajes de Sesión --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    {{-- Inicio de la Tarjeta AdminLTE --}}
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">Listado de Productos en Inventario</h3>
            <div class="card-tools">
                {{-- Botón de Nuevo Producto --}}
                <a href="{{ route('productos.create') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-plus-circle"></i> Nuevo Producto
                </a>
            </div>
        </div>
        
        <div class="card-body">
            {{-- La clase 'data-table' es una convención para el JS de DataTables --}}
            <table class="table table-bordered table-striped data-table" id="productos-table">
                <thead>
                    <tr>
                        <th style="width: 5%">ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th style="width: 10%">Precio</th>
                        <th style="width: 5%">Stock</th>
                        <th style="width: 15%">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productos as $producto)
                    <tr>
                        <td>{{ $producto->idproducto }}</td>
                        <td>{{ $producto->nombre }}</td>
                        <td>{{ $producto->descripcion }}</td>
                        <td><strong>${{ number_format($producto->precio, 2) }}</strong></td>
                        <td><span class="badge @if($producto->stock > 10) bg-success @elseif($producto->stock > 0) bg-warning @else bg-danger @endif">{{ $producto->stock }}</span></td>
                        <td class="text-center">
                            {{-- Botón Editar --}}
                            <a href="{{ route('productos.edit', $producto->idproducto) }}" class="btn btn-xs btn-warning" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            
                            {{-- Formulario para Eliminar --}}
                            <form action="{{ route('productos.destroy', $producto->idproducto) }}" method="POST" style="display:inline-block; margin-left: 5px;" onsubmit="return confirm('¿Está seguro de eliminar el producto: {{ $producto->nombre }}?');">
                                @csrf
                                @method('DELETE') {{-- Usa el método DELETE --}}
                                <button class="btn btn-xs btn-danger" type="submit" title="Eliminar">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="card-footer clearfix">
            <a href="{{ route('welcome') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-alt-circle-left"></i> Volver al Inicio
            </a>
        </div>
    </div>
    {{-- Fin de la Tarjeta AdminLTE --}}
</div>
@stop

{{-- Script para DataTables y SweetAlert2 (opcional) --}}
@section('js')
    <script>
        $(document).ready(function() {
            // Inicialización de DataTables
            $('#productos-table').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json" // Idioma español
                }
            });
        });
    </script>
@stop