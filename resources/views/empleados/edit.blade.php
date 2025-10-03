@extends('adminlte::page')

@section('title', 'Editar Empleado')

@section('content')
<div class="container">
    <h1>Editar Empleado</h1>

    @if ($errors->any())
      <div class="alert alert-danger">
          <ul>
              @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
    @endif

    <form action="{{ route('empleados.update', $empleados->numerodocumento) }}" method="POST">
        @csrf

         
         <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ingrese el nombre del empleado" value="{{ $empleados->nombre }}" >
        </div>
         <div class="form-group">
            <label for="apellidos">Apellidos</label>
            <input type="text" name="apellidos" id="apellidos" class="form-control" placeholder="Ingrese los apellidos del empleado" value="{{ $empleados->apellidos }}" >
        </div>

        
         <div class="form-group">
            <label for="tipodocumento">Tipo de Documento</label>
            <select name="tipodocumento" id="tipodocumento" class="form-control" value="{{ $empleados->tipodocumento }}">
                <option value="" disabled selected>Seleccione el tipo de documento</option>
                <option value="cc" {{ $empleados->tipodocumento == 'cc' ? 'selected' : '' }}>Cédula de Ciudadanía (CC)</option>
                <option value="ti" {{ $empleados->tipodocumento == 'ti' ? 'selected' : '' }}>Tarjeta de Identidad (TI)</option>
                <option value="ce" {{ $empleados->tipodocumento == 'ce' ? 'selected' : '' }}>Cédula de Extranjería (CE)</option>
            </select>
        </div>

        <div class="form-group">
            <label for="numerodocumento">Número de Documento</label>
            <input type="integer" name="numerodocumento" id="numerodocumento" class="form-control" placeholder="Ingrese el número de documento del empleado" value="{{ $empleados->numerodocumento }}" >
        </div>

        <div class="form-group">
            <label for="cargo">Cargo</label>
            <select name="cargo" id="cargo" class="form-control" value="{{ $empleados->cargo }}">
                <option value="" disabled selected>Seleccione un cargo</option>
                <option value="administrador" {{ $empleados->cargo == 'administrador' ? 'selected' : '' }}>Administrador</option>
                <option value="cajero" {{ $empleados->cargo == 'cajero' ? 'selected' : '' }}>Cajero</option>
                <option value="mesero" {{ $empleados->cargo == 'mesero' ? 'selected' : '' }}>Mesero</option>
                <option value="tecnico" {{ $empleados->cargo == 'tecnico' ? 'selected' : '' }}>Técnico de Mesas</option>
                <option value="aseo" {{ $empleados->cargo == 'aseo' ? 'selected' : '' }}>Personal de Aseo</option>
                <option value="seguridad" {{ $empleados->cargo == 'seguridad' ? 'selected' : '' }}>Seguridad</option>
            </select>
        </div>


        <div class="form-group">
            <label for="salario">salario</label>
            <input type="decimal" step="0.01" name="salario" id="salario" class="form-control" placeholder="Ingrese el salario del empleado" value="{{ $empleados->salario }}" >
        </div>

        <div class="form-group">
            <label for="estado">Estado</label>
            <select name="estado" id="estado" class="form-control" value="{{ $empleados->estado }}">
                <option value="" disabled selected>Seleccione el estado</option>
                <option value="activo" {{ $empleados->estado == 'activo' ? 'selected' : '' }}>Activo</option>
                <option value="inactivo" {{ $empleados->estado == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>


         <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Ingrese el email del empleado" value="{{ $empleados->email }}" >
        </div>

         <div class="form-group">
            <label for="telefono">Telefono</label>
            <input type="number" name="telefono" id="telefono" class="form-control" placeholder="Ingrese el telefono del empleado" value="{{ $empleados->telefono }}" >
        </div>

         <div class="form-group">
            <label for="direccion">Direccion</label>
            <input type="text" name="direccion" id="direccion" class="form-control" placeholder="Ingrese la direccion del empleado" value="{{ $empleados->direccion }}" >
        </div>

         <div class="form-group">
            <label for="fechaingreso">Fecha de Ingreso</label>
            <input type="date" name="fechaingreso" id="fechaingreso" class="form-control" placeholder="Ingrese la fecha de ingreso del empleado" value="{{ $empleados->fechaingreso }}" >
        </div>


        <button type="submit" class="btn btn-primary mt-3">Actualizar</button>
        <a href="{{ route('empleados.index') }}" class="btn btn-secondary mt-3">Cancelar</a>
    </form>
</div>
@stop
