@extends('adminlte::page')

@section('title', ' Pagos')

@section('content')
<div class="container">
    <h1>Proveedores</h1>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('proveedores.create') }}" class="btn btn-primary mb-3"> Crear proveedor</a>
     

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>nombre</th>
                <th>contacto</th>
                <th>direccion</th>
            </tr>
        </thead>
        <tbody>
            @foreach($proveedores as $proveedor)
            <tr>
                <td>{{ $proveedor->idproveedor }}</td>
                <td>{{ $proveedor->nombre }}</td>
                <td>{{ $proveedor->contacto }}</td>
                <td>{{ $proveedor->direccion }}</td>
               
                <td>
                    <a href="{{ route('proveedores.edit', $proveedor->idproveedor) }}" class="btn btn-sm btn-warning">Editar</a>
                    

                    <form action="{{ route('proveedores.destroy', $proveedor->idproveedor) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('¿Eliminar este producto?');">
                        @csrf
                       
                        <button class="btn btn-sm btn-danger" type="submit">Eliminar</button>
                        
                    </form>

                </td>
                
            </tr>
            @endforeach
        </tbody>
    </table>
    <div>
        <a href="{{ route('welcome') }}" class="btn btn-secondary">Volver al Inicio</a>
    </div>
</div>
        
@stop
