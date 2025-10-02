@extends('adminlte::page')

@section('title', 'Editar proveedor')

@section('content')
<div class="container">
    <h1>Editar proveedor</h1>

    @if ($errors->any())
      <div class="alert alert-danger">
          <ul>
              @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
    @endif

    <form action="{{ route('proveedores.update', $proveedor->idproveedor) }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="idproveedor">ID Proveedor</label>
            <input type="integer" name="idproveedor" id="idproveedor" class="form-control" value="{{ $proveedor->idproveedor }}" required>
        </div>

        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $proveedor->nombre }}" required>
        </div>

        <div class="form-group">
            <label for="contacto">Contacto</label>
            <input type="number" name="contacto" id="contacto" class="form-control" value="{{ $proveedor->contacto }}">
        </div>
        
        <div class="form-group">
            <label for="direccion">Direccion</label>
            <input type="text" name="direccion" id="direccion" class="form-control" value="{{ $proveedor->direccion }}" required>
        </div>


        <button type="submit" class="btn btn-primary mt-3">Actualizar</button>
        <a href="{{ route('proveedores.index') }}" class="btn btn-secondary mt-3">Cancelar</a>
    </form>
</div>
@stop
