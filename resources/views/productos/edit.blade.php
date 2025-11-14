@extends('adminlte::page')

@section('title', 'Editar Producto')

@section('content')
<div class="container">
    <h1>Editar Producto</h1>

    @if ($errors->any())
      <div class="alert alert-danger">
          <ul>
              @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
    @endif

    <form action="{{ route('productos.update', $producto->idproducto) }}" method="POST">
        @csrf
        {{-- ID Producto --}}
        <div class="form-group">
            <label for="idproducto">ID Producto</label>
            <input 
                type="text" 
                name="idproducto" 
                id="idproducto" 
                class="form-control" 
                value="{{ $producto->idproducto }}" 
                readonly
            >

            <div class="alert alert-warning mt-2 mb-0" role="alert">
                <strong>Atención:</strong> El ID del producto no se puede editar.
            </div>
        </div>

        {{-- Nombre --}}
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input 
                type="text" 
                name="nombre" 
                id="nombre" 
                class="form-control" 
                value="{{ old('nombre', $producto->nombre) }}" 
                required
            >
        </div>

        {{-- Descripción --}}
        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea 
                name="descripcion" 
                id="descripcion" 
                class="form-control" 
                required
            >{{ old('descripcion', $producto->descripcion) }}</textarea>
        </div>

        {{-- Precio --}}
        <div class="form-group">
            <label for="precio">Precio</label>
            <input 
                type="number" 
                step="0.01" 
                name="precio" 
                id="precio" 
                class="form-control" 
                value="{{ old('precio', $producto->precio) }}" 
                required
            >
        </div>

        {{-- Stock --}}
        <div class="form-group">
            <label for="stock">Stock</label>
            <input 
                type="number" 
                name="stock" 
                id="stock" 
                class="form-control" 
                value="{{ old('stock', $producto->stock) }}" 
                required
            >
        </div>

        {{-- PROVEEDOR --}}
        <div class="form-group">
            <label for="idproveedor">Proveedor</label>
            <select name="idproveedor" id="idproveedor" class="form-control" required>
                <option value="">Seleccione un proveedor</option>
                @foreach($proveedores as $prov)
                    <option 
                        value="{{ $prov->idproveedor }}" 
                        {{ $producto->idproveedor == $prov->idproveedor ? 'selected' : '' }}
                    >
                        {{ $prov->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Actualizar</button>
        <a href="{{ route('productos.index') }}" class="btn btn-secondary mt-3">Cancelar</a>
    </form>
</div>
@stop
