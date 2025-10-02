@extends('adminlte::page')

@section('title', 'Empleados')

@section('content')
<div class="container">
    <h1>Empleados</h1>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('empleados.create') }}" class="btn btn-primary mb-3">Nuevo Empleado</a>
     

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Numero Documento</th>
                <th>Nombre</th>
                <th>Cargo</th>
                <th>Salario</th>
                <th>Estado</th>
                <th>Tipo Documento</th>
                <th>Apellidos</th>
                <th>Email</th>
                <th>Telefono</th>
                <th>Direccion</th>
                <th>Fecha Ingreso</th>
                <th>Fecha Final</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($empleados as $empleado)
            <tr>
                <td>{{ $empleado->numerodocumento }}</td>
                <td>{{ $empleado->nombre }}</td>
                <td>{{ $empleado->cargo }}</td>
                <td>{{ $empleado->salario }}</td>
                <td>{{ $empleado->estado }}</td>
                <td>{{ $empleado->tipodocumento }}</td>
                <td>{{ $empleado->apellidos }}</td>
                <td>{{ $empleado->email }}</td>
                <td>{{ $empleado->telefono }}</td>
                <td>{{ $empleado->direccion }}</td>
                <td>{{ $empleado->fechaingreso }}</td>
                <td>{{ $empleado->fechafinal }}</td>

                <td>
                    <a href="{{ route('empleados.edit', $empleado->numerodocumento) }}" class="btn btn-sm btn-warning">Editar</a>
                    

                    <form action="{{ route('empleados.destroy', $empleado->numerodocumento) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('¿Eliminar este empleado?');">
                        @csrf
                       
                        <button class="btn btn-sm btn-danger" type="submit">Eliminar</button>
                        
                    </form>

                </td>
                
            </tr>
            @endforeach
        </tbody>
    </table>
    <div>
        <a href="{{ route('welcome') }}" class="btn btn-secondary">Volver al Inicio</a>
    </div>
</div>
        
@stop
