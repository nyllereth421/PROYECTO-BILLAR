@extends('adminlte::page')

@section('title', 'Crear proveedor')

@section('content')
<div class="container">
    <h1>Crear proveedor</h1>

    @if ($errors->any())
      <div class="alert alert-danger">
          <ul>
              @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
    @endif

    <form action="{{ route('proveedores.store') }}" method="POST">
        @csrf

         <div class="form-group">
            <label for="idproveedor">ID Proveedor</label>
            <input type="integer" name="idproveedor" id="idproveedor" class="form-control" placeholder="Ingrese el ID" required>
        </div>

        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ingrese el nombre" required>
        </div>

       <div class="form-group">
            <label for="contacto">Contacto</label>
            <input type="number" name="contacto" id="contacto" class="form-control" placeholder="Ingrese el contacto" required>
        </div>

        <div class="form-group">
            <label for="direccion">Direccion</label>
            <input type="text" name="direccion" id="direccion" class="form-control" placeholder="Ingrese la direccion" required>
        </div>



        <button type="submit" class="btn btn-success mt-3">Guardar</button>
        <a href="{{ route('proveedores.index') }}" class="btn btn-secondary mt-3">Cancelar</a>
    </form>
</div>
@stop
