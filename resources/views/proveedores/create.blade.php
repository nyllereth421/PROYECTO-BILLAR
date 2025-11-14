@extends('adminlte::page')

@section('title', 'Crear Proveedor')

@section('content_header')
    <h1 class="m-0 text-dark"><i class="fas fa-truck-moving"></i> Crear Nuevo Proveedor</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Formulario de Registro</h3>
        </div>
        
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
            
            <div class="card-body">
                
                {{-- CAMPO ID PROVEEDOR (Editable y Requerido) --}}
                <div class="form-group">
                    <label for="idproveedor">ID Proveedor</label>
                    <input type="text" name="idproveedor" id="idproveedor" 
                           class="form-control @error('idproveedor') is-invalid @enderror" 
                           placeholder="Ingrese el ID único del proveedor" 
                           value="{{ old('idproveedor') }}" 
                           required
                           inputmode="numeric" 
                           pattern="[0-9]*" 
                           title="Solo se permiten números para el ID">
                    @error('idproveedor') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Campo Nombre --}}
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" 
                           placeholder="Ingrese el nombre del proveedor" value="{{ old('nombre') }}" required>
                    @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Campo Contacto (Solo números) --}}
                <div class="form-group">
                    <label for="contacto">Teléfono/Contacto</label>
                    <input type="text" name="contacto" id="contacto" class="form-control @error('contacto') is-invalid @enderror" 
                           placeholder="Ingrese el número de contacto" value="{{ old('contacto') }}" required 
                           inputmode="numeric" pattern="[0-9]*" title="Solo se permiten números">
                    @error('contacto') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Campo Dirección --}}
                <div class="form-group">
                    <label for="direccion">Dirección</label>
                    <input type="text" name="direccion" id="direccion" class="form-control @error('direccion') is-invalid @enderror" 
                           placeholder="Ingrese la dirección" value="{{ old('direccion') }}" required>
                    @error('direccion') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

            </div>
            
            <div class="card-footer">
                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Guardar</button>
                <a href="{{ route('proveedores.index') }}" class="btn btn-secondary"><i class="fas fa-times-circle"></i> Cancelar</a>
            </div>
        </form>
    </div>
</div>
@stop

@section('js')
<script>
    console.log('Vista de creación de proveedor lista 🟢');
</script>
@stop