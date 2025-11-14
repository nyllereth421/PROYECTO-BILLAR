@extends('adminlte::page')

@section('title', 'Editar Proveedor')

@section('content_header')
    <h1 class="m-0 text-dark"><i class="fas fa-edit"></i> Editar Proveedor: {{ $proveedor->nombre }}</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">Formulario de Edición</h3>
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

        {{-- Usar el método PUT para la actualización --}}
        <form action="{{ route('proveedores.update', $proveedor->idproveedor) }}" method="POST">
            @csrf
            <div class="card-body">

                {{-- CAMPO ID (SOLO LECTURA) --}}
                <div class="form-group">
                    <label for="idproveedor">ID Proveedor</label>
                    <input type="text" name="idproveedor" id="idproveedor" 
                           class="form-control bg-light" 
                           value="{{ $proveedor->idproveedor }}" 
                           readonly 
                           onclick="alertaID()"
                           placeholder="El ID es inmutable.">
                    <small class="form-text text-danger">El ID no puede ser editado.</small>
                </div>

                {{-- Campo Nombre --}}
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" 
                           placeholder="Ingrese el nombre" value="{{ old('nombre', $proveedor->nombre) }}" required>
                    @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Campo Contacto (Solo números y HTML5) --}}
                <div class="form-group">
                    <label for="contacto">Teléfono/Contacto</label>
                    <input type="text" name="contacto" id="contacto" class="form-control @error('contacto') is-invalid @enderror" 
                           placeholder="Ingrese el número de contacto" value="{{ old('contacto', $proveedor->contacto) }}" required 
                           inputmode="numeric" pattern="[0-9]*" title="Solo se permiten números">
                    @error('contacto') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Campo Dirección --}}
                <div class="form-group">
                    <label for="direccion">Dirección</label>
                    <input type="text" name="direccion" id="direccion" class="form-control @error('direccion') is-invalid @enderror" 
                           placeholder="Ingrese la dirección" value="{{ old('direccion', $proveedor->direccion) }}" required>
                    @error('direccion') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

            </div>
            
            <div class="card-footer">
                <button type="submit" class="btn btn-warning"><i class="fas fa-sync-alt"></i> Actualizar</button>
                <a href="{{ route('proveedores.index') }}" class="btn btn-secondary"><i class="fas fa-times-circle"></i> Cancelar</a>
            </div>
        </form>
    </div>
</div>
@stop

@section('js')
<script>
    console.log('Vista de edición de proveedor lista 🟢');

    /**
     * Muestra una alerta si el usuario intenta interactuar con el campo ID.
     */
    function alertaID() {
        alert('⚠️ ATENCIÓN: El ID del proveedor es una clave única y no puede ser modificado.');
    }
</script>
@stop