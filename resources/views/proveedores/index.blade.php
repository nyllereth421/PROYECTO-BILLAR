@extends('adminlte::page')

@section('title', 'Gestión de Proveedores')

@section('content_header')
    <h1 class="m-0 text-dark"><i class="fas fa-truck"></i> Gestión de Proveedores</h1>
@stop

@section('content')
<div class="container-fluid">

    {{-- ALERTA DE ÉXITO --}}
    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <div class="d-flex justify-content-between mb-3">
        <div>
            <a href="{{ route('inventario.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver a Inventario
            </a>
        </div>
        <a href="{{ route('proveedores.create') }}" class="btn btn-primary"> 
            <i class="fas fa-plus-circle"></i> Crear Proveedor
        </a>
    </div>

    {{-- TABLA DE PROVEEDORES --}}
    <div class="card shadow-sm">
        <div class="card-body table-responsive p-0">
            <table class="table table-bordered table-striped table-valign-middle">
                <thead>
                    <tr>
                        <th style="width: 5%">ID</th>
                        <th style="width: 25%">Nombre</th>
                        <th style="width: 20%">Contacto</th>
                        <th style="width: 30%">Dirección</th>
                        <th style="width: 20%" class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($proveedores as $proveedor)
                    <tr>
                        <td class="text-center">{{ $proveedor->idproveedor }}</td>
                        <td>{{ $proveedor->nombre }}</td>
                        <td>{{ $proveedor->contacto }}</td>
                        <td>{{ $proveedor->direccion }}</td>
                        
                        <td class="text-center">
                            {{-- Botón Editar --}}
                            <a href="{{ route('proveedores.edit', $proveedor->idproveedor) }}" class="btn btn-xs btn-default text-warning mx-1 shadow" title="Editar">
                                <i class="fa fa-lg fa-fw fa-pen"></i>
                            </a>
                            
                            {{-- BOTÓN ELIMINAR MODIFICADO (llama a la función con alert nativo) --}}
                            <button 
                                type="button" 
                                class="btn btn-xs btn-default text-danger mx-1 shadow" 
                                onclick="alertaEliminarProveedor('{{ $proveedor->nombre }}')" 
                                title="Eliminar (restringido)">
                                <i class="fa fa-lg fa-fw fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop 

@section('js')
<script>
    console.log('Vista de proveedores lista 🟢');

    /**
     * Función que muestra una alerta nativa al intentar eliminar un proveedor
     * por tener registros asociados.
     * @param {string} nombre El nombre del proveedor.
     */
    function alertaEliminarProveedor(nombre) {
        alert(`❌ ERROR: El proveedor "${nombre}" no puede ser eliminado. \n\nMotivo: Tiene registros asociados (como productos o compras) en el sistema. Debe eliminar esos registros primero.`);
    }
</script>
@endsection