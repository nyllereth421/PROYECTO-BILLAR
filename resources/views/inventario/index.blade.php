@extends('adminlte::page')

@section('title', $title ?? 'Dashboard Ejecutivo')

@section('content_header')
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="text-dark mb-1">
                    <i class="fas fa-boxes mr-2 text-primary"></i> 
                    Inventario Billar Nexus
                </h1>
                <p class="text-muted mb-0">Vista general del inventario y recursos</p>
            </div>
            <div class="col-md-4 text-right">
                <a href="{{ route('welcome') }}" class="btn btn-outline-secondary btn-lg">
                    <i class="fas fa-arrow-left mr-2"></i>Volver
                </a>
            </div>
        </div>
    </div>
@stop

@section('content')
<div class="container-fluid">
    {{-- Indicadores Principales --}}
    <div class="row">
        {{-- Productos Disponibles --}}
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="small-box bg-gradient-info shadow-sm hover-card">
                <div class="inner">
                    <h3 class="animate-number">
                        {{ $productos->count() }}
                        <sup class="sup-text">productos</sup>
                    </h3>
                    <p class="card-subtitle">Productos Disponibles</p>
                    <div class="progress mt-2" style="height: 4px;">
                        <div class="progress-bar bg-white" role="progressbar" style="width: 85%"></div>
                    </div>
                </div>
                <div class="icon">
                    <i class="fas fa-box-open"></i>
                </div>
                <a href="{{ route('productos.index') }}" class="small-box-footer">
                    Ver listado completo <i class="fas fa-arrow-circle-right ml-1"></i>
                </a>
            </div>
        </div>

        {{-- Mesas Registradas --}}
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="small-box bg-gradient-success shadow-sm hover-card">
                <div class="inner">
                    <h3 class="animate-number">
                        {{ $mesas->count() }}<span class="text-light opacity-75"></span>
                        <sup class="sup-text">mesas</sup>
                    </h3>
                    <p class="card-subtitle">Mesas Registradas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-hockey-puck"></i>
                </div>
                <a href="{{ route('mesas.index') }}" class="small-box-footer">
                    Ver estado de mesas <i class="fas fa-arrow-circle-right ml-1"></i>
                </a>
            </div>
        </div>

        {{-- Proveedores Activos --}}
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="small-box bg-gradient-warning shadow-sm hover-card">
                <div class="inner">
                    <h3 class="animate-number">
                        {{ $proveedoresActivos ?? 0 }}
                        <sup class="sup-text">proveedores</sup>
                    </h3>
                    <p class="card-subtitle">Proveedores Activos</p>
                </div>
                <div class="icon">
                    <i class="fas fa-truck"></i>
                </div>
                <a href="{{ route('proveedores.index') }}" class="small-box-footer">
                    Ver proveedores <i class="fas fa-arrow-circle-right ml-1"></i>
                </a>
            </div>
        </div>
    </div>

    {{--  " Clases de Tiempo que se manejan" --}}
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-table mr-1"></i> Clases de Tiempo que manejamos</h3>
                </div>
                <div class="card-body">
                    @php
                        $colors = ['#FF5733','#33FF57','#3357FF','#FF33A8','#FFC300','#8D33FF'];
                    @endphp
                    <table class="table table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th># </th>
                                <th>Tipos de Tiempo</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($productosTiempo as $index => $producto)
                                <tr style="background-color: {{ $colors[$index % count($colors)] }}20;">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $producto->nombre }}</td>
                                    
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">No hay productos con "Tiempo"</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    .small-box { border-radius: 12px; transition: all 0.3s ease; overflow: hidden; }
    .hover-card:hover { transform: translateY(-5px); box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important; }
    .small-box .inner { padding: 20px; }
    .small-box h3 { font-size: 2.5rem; font-weight: 700; margin-bottom: 5px; }
    .sup-text { font-size: 0.9rem !important; font-weight: 500; opacity: 0.9; margin-left: 5px; }
    .card-subtitle { font-size: 1rem; font-weight: 500; margin-bottom: 0; opacity: 0.95; }
    .small-box .icon { font-size: 4rem; opacity: 0.2; transition: all 0.3s ease; }
    .small-box:hover .icon { font-size: 4.5rem; opacity: 0.3; }
    .small-box-footer { padding: 10px 20px; background: rgba(0,0,0,0.1); transition: all 0.3s ease; font-weight: 500; }
    .small-box-footer:hover { background: rgba(0,0,0,0.15); color: white !important; }
    .animate-number { animation: countUp 0.6s ease-out; }
    @keyframes countUp { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:translateY(0); } }
    .table-hover tbody tr:hover { opacity: 0.8; transition: 0.3s; }
</style>
@stop
