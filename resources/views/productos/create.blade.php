@extends('adminlte::page')

@section('title', 'Crear Producto')

@section('content')
<div class="container">
    <h1>Crear Producto</h1>

    @if ($errors->any())
      <div class="alert alert-danger">
          <ul class="mb-0">
              @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
    @endif

    <form action="{{ route('productos.store') }}" method="POST">
        @csrf

        {{-- Nombre --}}
        <div class="form-group">
            <label for="nombre">Nombre del Producto</label>
            <input type="text" name="nombre" id="nombre" class="form-control"
                   value="{{ old('nombre') }}" required>
        </div>

        {{-- Descripción --}}
        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control" required>{{ old('descripcion') }}</textarea>
        </div>

        {{-- Precio --}}
        <div class="form-group">
            <label for="precio">Precio</label>
            <input type="number" step="0.01" name="precio" id="precio"
                   class="form-control" value="{{ old('precio') }}" required>
        </div>

        {{-- Stock --}}
        <div class="form-group">
            <label for="stock">Stock</label>
            <input type="number" name="stock" id="stock"
                   class="form-control" value="{{ old('stock') }}" required>
        </div>

        {{-- PROVEEDOR --}}
        <div class="form-group">
            <label for="idproveedor">Proveedor</label>
            <select name="idproveedor" id="idproveedor" class="form-control" required>
                <option value="">Seleccione un proveedor</option>
                @foreach($proveedores as $prov)
                    <option value="{{ $prov->idproveedor }}"
                        {{ old('idproveedor') == $prov->idproveedor ? 'selected' : '' }}>
                        {{ $prov->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success mt-3">Guardar</button>
        <a href="{{ route('productos.index') }}" class="btn btn-secondary mt-3">Cancelar</a>
    </form>
</div>
@stop
