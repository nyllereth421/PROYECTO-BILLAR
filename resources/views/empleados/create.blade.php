@extends('adminlte::page')

@section('title', 'Crear nuevo empleado')

@section('content')
<div class="container">
    <h1>Crear nuevo empleado</h1>

    @if ($errors->any())
      <div class="alert alert-danger">
          <ul>
              @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
    @endif

    <form action="{{ route('empleados.store') }}" method="POST">
        @csrf

         

        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ingrese el nombre del empleado" >
        </div>
         <div class="form-group">
            <label for="apellidos">Apellidos</label>
            <input type="text" name="apellidos" id="apellidos" class="form-control" placeholder="Ingrese los apellidos del empleado" >
        </div>

        
         <div class="form-group">
            <label for="tipodocumento">Tipo de Documento</label>
            <select name="tipodocumento" id="tipodocumento" class="form-control" required>
                <option value="" disabled selected>Seleccione el tipo de documento</option>
                <option value="cc">Cédula de Ciudadanía (CC)</option>
                <option value="ti">Tarjeta de Identidad (TI)</option>
                <option value="ce">Cédula de Extranjería (CE)</option>
            </select>
        </div>

        <div class="form-group">
            <label for="numerodocumento">Número de Documento</label>
            <input type="integer" name="numerodocumento" id="numerodocumento" class="form-control" placeholder="Ingrese el número de documento del empleado" >
        </div>

        <div class="form-group">
            <label for="cargo">Cargo</label>
            <select name="cargo" id="cargo" class="form-control">
                <option value="" disabled selected>Seleccione un cargo</option>
                <option value="administrador">Administrador</option>
                <option value="cajero">Cajero</option>
                <option value="mesero">Mesero</option>
                <option value="tecnico">Técnico de Mesas</option>
                <option value="aseo">Personal de Aseo</option>
                <option value="seguridad">Seguridad</option>
            </select>
        </div>


        <div class="form-group">
            <label for="salario">salario</label>
            <input type="decimal" step="0.01" name="salario" id="salario" class="form-control" placeholder="Ingrese el salario del empleado" >
        </div>

        <div class="form-group">
            <label for="estado">Estado</label>
            <select name="estado" id="estado" class="form-control" required>
                <option value="" disabled selected>Seleccione el estado</option>
                <option value="activo">Activo</option>
                <option value="inactivo">Inactivo</option>
            </select>
        </div>


         <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Ingrese el email del empleado" >
        </div>

         <div class="form-group">
            <label for="telefono">Telefono</label>
            <input type="number" name="telefono" id="telefono" class="form-control" placeholder="Ingrese el telefono del empleado" >
        </div>

         <div class="form-group">
            <label for="direccion">Direccion</label>
            <input type="text" name="direccion" id="direccion" class="form-control" placeholder="Ingrese la direccion del empleado" >
        </div>

         <div class="form-group">
            <label for="fechaingreso">Fecha de Ingreso</label>
            <input type="date" name="fechaingreso" id="fechaingreso" class="form-control" placeholder="Ingrese la fecha de ingreso del empleado" >
        </div>


        <button type="submit" class="btn btn-success mt-3">Guardar</button>
        <a href="{{ route('empleados.index') }}" class="btn btn-secondary mt-3">Cancelar</a>
    </form>
</div>
@stop
