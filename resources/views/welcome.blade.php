@extends('adminlte::page')

@section('title', $title ?? 'Dashboard Ejecutivo')

{{-- Usamos content_header para un título más limpio en AdminLTE --}}
@section('content_header')
    <div class="container-fluid text-center">
        <h1 class="text-dark"><i class="fas fa-chart-line mr-2"></i> Panel de Gestión Billar Nexus</h1>
        <p class="text-muted">Vista general del negocio.</p>
    </div>
@stop

@section('content')
<div class="container-fluid">
    {{-- 1. Fila de Indicadores Clave (Small Boxes) --}}
    <div class="row">

        {{-- INGRESO DIARIO/ACTUAL --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>$450<sup style="font-size: 20px">/Hoy</sup></h3>
                    <p>Ingresos del Día</p>
                </div>
                <div class="icon">
                    <i class="fas fa-dollar-sign"></i> 
                </div>
                <a href="#" class="small-box-footer">
                    Ver reportes financieros <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        {{-- MESAS ACTIVAS/TOTAL --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>4<sup style="font-size: 20px">/12</sup></h3> 
                    <p>Mesas Ocupadas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-hockey-puck billar-icon"></i> 
                </div>
                <a href="{{ route('mesasventas.index')}}" class="small-box-footer">
                    Gestión de mesas <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        {{-- PRODUCTOS BAJO STOCK --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>35</h3>
                    <p>Inventario</p>
                </div>
                <div class="icon">
                    <i class="fas fa-boxes"></i> 
                </div>
                <a href="{{ route('inventario.index')}}" class="small-box-footer">
                    Gestión de Inventario <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        {{-- EMPLEADOS --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary"> 
                <div class="inner">
                    <h3>7</h3>
                    <p>Personal Activo</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="{{route ('empleados.index') }}" class="small-box-footer">
                    Ver empleados <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- 2. Fila de Gráficos y Tendencias --}}
    <div class="row">
        {{-- CARD para Gráfico de Ventas --}}
        <div class="col-md-7">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-bar mr-1"></i>
                        Rendimiento de Ventas (Últimos 7 Días)
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="salesChart" style="height:250px; min-height:250px"></canvas>
                </div>
            </div>
        </div>

        {{-- CARD para Productos Más Vendidos --}}
        <div class="col-md-5">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-fire mr-1"></i>
                        Top 5 Productos Vendidos (Hoy)
                    </h3>
                </div>

                @php
                    // Función para asignar iconos según el nombre del producto
                    function iconoProductoDashboard($nombre) {
                        $nombre = strtolower($nombre);

                        if (str_contains($nombre, 'cerveza')) return 'fa-beer text-warning';
                        if (str_contains($nombre, 'gaseosa') || str_contains($nombre, 'cola')) return 'fa-cocktail text-info';
                        if (str_contains($nombre, 'empanada')) return 'fa-cookie-bite text-warning';
                        if (str_contains($nombre, 'tinto') || str_contains($nombre, 'café') || str_contains($nombre, 'cafe')) return 'fa-mug-hot text-danger';
                        if (str_contains($nombre, 'agua')) return 'fa-tint text-primary';
                        if (str_contains($nombre, 'papas') || str_contains($nombre, 'snack')) return 'fa-drumstick-bite text-success';

                        return 'fa-box-open text-secondary'; // genérico
                    }
                @endphp

                <div class="card-body p-0">
                    <ul class="products-list product-list-in-card pl-2 pr-2">
                        @forelse ($productos as $producto)
                            <li class="item">
                                <div class="product-img">
                                    <i class="fas {{ iconoProductoDashboard($producto->nombre) }}"></i>
                                </div>
                                <div class="product-info">
                                    {{ $producto->nombre }}
                                    <span class="badge bg-primary float-right">
                                        {{ $producto->cantidad_vendida ?? 0 }} Unidades
                                    </span>
                                </div>
                            </li>
                        @empty
                            <li class="item text-center p-3">
                                <span class="text-muted">No hay productos registrados aún.</span>
                            </li>
                        @endforelse
                    </ul>
                </div>

                <div class="card-footer text-center">
                    <a href="{{ route('productos.index') }}" class="uppercase">Ver Todos los Productos</a>
                </div>
            </div>
        </div>
    </div>

    {{-- 3. Fila de Eventos y Mantenimiento --}}
    <div class="row">
        {{-- Próximos Eventos/Torneos --}}
        <div class="col-md-8">
            <div class="card card-outline card-warning">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-calendar-alt mr-1"></i> Próximos Eventos/Torneos
                    </h3>
                </div>
                <div class="card-body p-0">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                Torneo Semanal de Bola 8
                                <span class="float-right text-warning">
                                    <i class="far fa-calendar-alt"></i> 15/Oct/2025
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-footer">
                    <h5 class="mb-2">
                        <i class="fas fa-handshake mr-1 text-warning"></i> Patrocinadores
                    </h5>
                    <a href="#" class="btn btn-outline-warning btn-sm">
                        Ver todos los patrocinadores
                    </a>
                </div>
            </div>
        </div>

        {{-- Mantenimiento --}}
        <div class="col-md-4">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>2<sup style="font-size: 20px">/7</sup></h3>
                    <p>Mesas Requieren Mantenimiento</p>
                </div>
                <div class="icon">
                    <i class="fas fa-tools"></i>
                </div>
                <a href="#" class="small-box-footer">
                    Crear orden de trabajo <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

</div>
@stop

@section('css')
    @stack('styles')
    <style>
        /* Ajustes finos a los Small Boxes para look ejecutivo */
        .small-box {
            border-radius: 0.5rem;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .small-box:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0,0,0,0.1);
        }

        .small-box .inner h3 {
            font-weight: 700;
        }

        /* Colores personalizados */
        .small-box.bg-info { background-color: #17a2b8 !important; }
        .small-box.bg-success { background-color: #28a745 !important; }
        .small-box.bg-warning { 
            background-color: #ffc107 !important; 
            color: #333 !important;
        }
        .small-box.bg-primary { background-color: #007bff !important; }
        .small-box.bg-danger { background-color: #dc3545 !important; }
        .small-box.bg-secondary { background-color: #6c757d !important; }

        .small-box .icon { 
            font-size: 80px;
            color: rgba(0, 0, 0, 0.15) !important;
        }
        
        /* Ajuste para que el texto de las tarjetas warning se vea bien */
        .small-box.bg-warning .inner p,
        .small-box.bg-warning .inner h3,
        .small-box.bg-warning .small-box-footer {
            color: #333 !important;
        }

        .small-box.bg-warning .small-box-footer {
            background: rgba(0,0,0,0.1) !important;
        }

        /* Estilo para los cards */
        .card-outline.card-info { border-top: 3px solid #17a2b8; }
        .card-outline.card-primary { border-top: 3px solid #007bff; }
        .card-outline.card-warning { border-top: 3px solid #ffc107; }

        /* Estilo para la lista de productos */
        .products-list .product-img i {
            font-size: 24px;
            text-align: center;
            line-height: 49px;
            width: 50px;
            height: 50px;
            background-color: #f8f9fa;
            border-radius: 4px;
        }

        /* Espaciado entre filas */
        .row {
            margin-bottom: 20px;
        }
    </style>
@stop

@section('js')
    @stack('scripts')
    {{-- Inicialización de Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script>
        // Datos de ejemplo para el gráfico
        const ctx = document.getElementById('salesChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'],
                    datasets: [{
                        label: 'Ingresos ($)',
                        data: [320, 450, 380, 520, 490, 650, 450],
                        borderColor: '#17a2b8',
                        backgroundColor: 'rgba(23, 162, 184, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return '$' + value;
                                }
                            }
                        }
                    }
                }
            });
        }
    </script>
@stop