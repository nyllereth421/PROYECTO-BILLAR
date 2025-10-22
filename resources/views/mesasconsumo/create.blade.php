@extends('adminlte::page')

@section('title', 'Nueva Mesa de Consumo')

@section('content_header')
    <h1><i class="fas fa-plus-circle"></i> Agregar Nueva Mesa de Consumo</h1>
@stop

@section('content')
<div class="container">
    <form action="{{ route('mesasconsumo.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="consumos">Nombre o Descripción del Consumo</label>
            <input type="text" class="form-control" name="consumos" placeholder="Ejemplo: Mesa 1 - Jugadores" required>
        </div>

        <div class="form-group">
            <label for="estado">Estado</label>
            <select class="form-control" name="estado" required>
                <option value="disponible">Disponible</option>
                <option value="ocupada">Ocupada</option>
                <option value="reservada">Reservada</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">
            <i class="fas fa-save"></i> Guardar
        </button>
        <a href="{{ route('mesasconsumo.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@stop
