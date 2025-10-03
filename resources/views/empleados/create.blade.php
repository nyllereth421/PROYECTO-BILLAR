@extends('adminlte::page')

@section('title', 'Crear Producto')

@section('content')
<div class="container">
    <h1>Crear Producto</h1>

    @if ($errors->any())
      <div class="alert alert-danger">
          <ul>
              @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
    @endif

    <form action="{{ route('productos.store') }}" method="POST">
        @csrf

         <div class="form-group">
            <label for="numerodocumento">Número de Documento</label>
            <input type="integer" name="numerodocumento" id="numerodocumento" class="form-control" placeholder="Ingrese el número de documento del empleado" required>
        </div>


        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ingrese el nombre del producto" required>
        </div>

        <div class="form-group">
            <label for="cargo">Cargo</label>
            <textarea name="cargo" id="cargo" class="form-control" placeholder="Ingrese el cargo del empleado"></textarea>
        </div>

        <div class="form-group">
            <label for="salario">salario</label>
            <input type="number" step="0.01" name="salario" id="salario" class="form-control" placeholder="Ingrese el salario del producto" required>
        </div>

        <div class="form-group">
            <label for="estado">estado</label>
            <input type="number" name="estado" id="estado" class="form-control" placeholder="Ingrese el estado del producto" required>
        </div>

         <div class="form-group">
            <label for="tipodocumento">Tipo de Documento</label>
            <input type="number" name="tipodocumento" id="tipodocumento" class="form-control" placeholder="Ingrese el tipo de documento del empleado" required>
        </div>

         <div class="form-group">
            <label for="apellidos">Apellidos</label>
            <input type="text" name="apellidos" id="apellidos" class="form-control" placeholder="Ingrese los apellidos del empleado" required>
        </div>

         <div class="form-group">
            <label for="estado">estado</label>
            <input type="number" name="estado" id="estado" class="form-control" placeholder="Ingrese el estado del producto" required>
        </div>

         <div class="form-group">
            <label for="estado">estado</label>
            <input type="number" name="estado" id="estado" class="form-control" placeholder="Ingrese el estado del producto" required>
        </div>

         <div class="form-group">
            <label for="estado">estado</label>
            <input type="number" name="estado" id="estado" class="form-control" placeholder="Ingrese el estado del producto" required>
        </div>

         <div class="form-group">
            <label for="estado">estado</label>
            <input type="number" name="estado" id="estado" class="form-control" placeholder="Ingrese el estado del producto" required>
        </div>

         <div class="form-group">
            <label for="estado">estado</label>
            <input type="number" name="estado" id="estado" class="form-control" placeholder="Ingrese el estado del producto" required>
        </div>

         <div class="form-group">
            <label for="estado">estado</label>
            <input type="number" name="estado" id="estado" class="form-control" placeholder="Ingrese el estado del producto" required>
        </div>

        <button type="submit" class="btn btn-success mt-3">Guardar</button>
        <a href="{{ route('productos.index') }}" class="btn btn-secondary mt-3">Cancelar</a>
    </form>
</div>
@stop
