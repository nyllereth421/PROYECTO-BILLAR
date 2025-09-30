@extends('adminlte::page')

@section('title', 'Lista de Productos')

@section('content')
<div class="container">
    <h1>Productos</h1>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('productos.create') }}" class="btn btn-primary mb-3">Nuevo Producto</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productos as $producto)
            <tr>
                <td>{{ $producto->idproducto }}</td>
                <td>{{ $producto->nombre }}</td>
                <td>{{ $producto->descripcion }}</td>
                <td>${{ number_format($producto->precio, 2) }}</td>
                <td>{{ $producto->stock }}</td>
                <td>
                    <a href="{{ route('productos.edit', $producto->idproducto) }}" class="btn btn-sm btn-warning">Editar</a>

                    <form action="{{ route('productos.destroy', $producto->idproducto) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('¿Eliminar este producto?');">
                        @csrf
                       
                        <button class="btn btn-sm btn-danger" type="submit">Eliminar</button>
                    </form>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@stop
