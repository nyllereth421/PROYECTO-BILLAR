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
            <label for="idproducto">id Producto</label>
            <input type="integer" name="idproducto" id="idproducto" class="form-control" placeholder="Ingrese el ID del producto" required>
        </div>


        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ingrese el nombre del producto" required>
        </div>

        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control" placeholder="Ingrese la descripción del producto"></textarea>
        </div>

        <div class="form-group">
            <label for="precio">Precio</label>
            <input type="number" step="0.01" name="precio" id="precio" class="form-control" placeholder="Ingrese el precio del producto" required>
        </div>

        <div class="form-group">
            <label for="stock">Stock</label>
            <input type="number" name="stock" id="stock" class="form-control" placeholder="Ingrese el stock del producto" required>
        </div>

        <button type="submit" class="btn btn-success mt-3">Guardar</button>
        <a href="{{ route('productos.index') }}" class="btn btn-secondary mt-3">Cancelar</a>
    </form>
</div>
@stop
