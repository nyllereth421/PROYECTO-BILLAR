@extends('adminlte::page')

@section('title', 'Gestión de Mesas')

@section('content_header')
    <h1><i class="fas fa-table"></i> Gestión de Mesas y Mesas de Consumo</h1>
@stop

@section('content')
<div class="container-fluid">

    {{-- 🔙 BARRA DE ACCIONES CON BUSCADOR --}}
    <div class="mb-4">
        <div class="row align-items-center">
            <div class="col-md-3 mb-2 mb-md-0">
                <a href="{{ route('inventario.index') }}" class="btn btn-secondary btn-lg btn-block">
                    <i class="fas fa-arrow-left mr-2"></i> Volver
                </a>
            </div>

            {{-- 🔍 BUSCADOR CENTRAL --}}
            <div class="col-md-6 mb-2 mb-md-0">
                <div class="input-group">
                    <span class="input-group-text bg-white">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" 
                           id="buscadorMesas" 
                           class="form-control form-control-lg"
                           placeholder="Buscar mesa por número o tipo...">
                </div>
            </div>

            {{-- ✅ Botón Nueva Mesa --}}
            <div class="col-md-3 text-md-right">
                <a href="{{ route('mesas.create') }}" class="btn btn-success btn-lg btn-block">
                    <i class="fas fa-plus mr-2"></i> Nueva Mesa
                </a>
            </div>
        </div>
    </div>

    <div class="row" id="contenedorMesas">

        {{-- 🟢 LISTADO DE MESAS --}}
        @foreach($mesas as $mesa)
            <div class="col-md-4 mesa-item mb-4">

                <div class="card 
                    {{ $mesa->estado == 'ocupada' ? 'card-danger' : 
                       ($mesa->estado == 'reservada' ? 'card-info' : 'card-success') }}">

                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">Mesa #{{ $mesa->numeromesa }}</h3>
                        <span class="badge bg-secondary">{{ ucfirst($mesa->tipo) }}</span>
                    </div>

                    <div class="card-body text-center">

                        {{-- Imagen --}}
                        <img src="{{ asset('img/mesas/' . $mesa->tipo . '.png') }}"
                             alt="{{ $mesa->tipo }}"
                             class="img-fluid mb-3"
                             style="height: 150px; object-fit: contain;">

                        {{-- ⭐ Botones --}}
                        <div class="d-flex justify-content-center">

                            <a href="{{ route('mesas.edit', $mesa->idmesa) }}" 
                               class="btn btn-warning btn-sm mx-1">
                                <i class="fas fa-edit"></i> Editar
                            </a>

                            <form action="{{ route('mesas.destroy', $mesa->idmesa) }}" 
                                  method="POST"
                                  data-confirm="¿Deseas eliminar esta mesa?"
                                  data-action-type="delete"
                                  class="mx-1">
                                @csrf
                                <button class="btn btn-danger btn-sm" type="submit">
                                    <i class="fas fa-trash"></i> Eliminar
                                </button>
                            </form>

                        </div>

                    </div>
                </div>
            </div>
        @endforeach

    </div>
</div>
@stop

@section('js')

{{-- 🔎 Buscador en tiempo real --}}
<script>
document.getElementById('buscadorMesas').addEventListener('keyup', function() {
    let filtro = this.value.toLowerCase();
    let mesas = document.querySelectorAll('.mesa-item');

    mesas.forEach(mesa => {
        let texto = mesa.innerText.toLowerCase();
        mesa.style.display = texto.includes(filtro) ? '' : 'none';
    });
});
</script>

@include('components.sweetalert-global')

@stop
