@extends('adminlte::page')

@section('title', ' Pagos')

@section('content')
<div class="container">
    <h1>metodo de pago</h1>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="" class="btn btn-primary mb-3"> Método de Pago</a>
     

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>formadepago</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            @foreach($metodopagos as $metodopago)
            <tr>
                <td>{{ $metodopago->idmetodopago }}</td>
                <td>{{ $metodopago->formadepago }}</td>
                <td>{{ $metodopago->descripcion }}</td>
               
                <td>
                    <a href="" class="btn btn-sm btn-warning">Editar</a>
                    

                    <form action="" method="POST" style="display:inline-block;" onsubmit="return confirm('¿Eliminar este producto?');">
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
