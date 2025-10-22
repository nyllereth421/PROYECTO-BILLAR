@extends('adminlte::page')

@section('title', 'Editar Mesa de Consumo')

@section('content_header')
    <h1><i class="fas fa-edit"></i> Editar Mesa de Consumo </h1>
@stop

@section('content')
<div class="container">
    <form action="{{ route('mesasconsumo.update', $mesa->idmesaconsumo) }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="consumos">Nombre o Descripción del Consumo</label>
            <input type="text" class="form-control" name="consumos" value="{{ $mesa->consumos }}" required>
        </div>

        <div class="form-group">
            <label for="estado">Estado</label>
            <select class="form-control" name="estado" required>
                <option value="disponible" {{ $mesa->estado == 'disponible' ? 'selected' : '' }}>Disponible</option>
                <option value="ocupada" {{ $mesa->estado == 'ocupada' ? 'selected' : '' }}>Ocupada</option>
                <option value="reservada" {{ $mesa->estado == 'reservada' ? 'selected' : '' }}>Reservada</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Actualizar
        </button>
        <a href="{{ route('mesasconsumo.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@stop
