@extends('adminlte::page')

@section('title', $title ?? 'Dashboard Ejecutivo')

{{-- Usamos content_header para un título más limpio en AdminLTE --}}
@section('content_header')
    <div class="container-fluid text-center">
        <h1 class="text-dark"><i class="fas fa-chart-line mr-2"></i> Panel de Gestión Billar Nexus</h1>
        <p class="text-muted">Vista genral del negocio.</p>
    </div>
@stop

@section('content')
<div class="container-fluid">
    {{-- 1. Fila de Indicadores Clave (Small Boxes) --}}
    <div class="row">

        {{-- INGRESO DIARIO/ACTUAL --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info"> {{-- Cambiamos a 'info' para un azul profesional --}}
                <div class="inner">
                    <h3>$450<sup style="font-size: 20px">/Hoy</sup></h3>
                    <p>Ingresos del Día</p>
                </div>
                <div class="icon">
                    {{-- Icono nativo de Font Awesome para dinero --}}
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
                    {{-- Suponemos 4 activas de 12 total --}}
                    <h3>4<sup style="font-size: 20px">/12</sup></h3> 
                    <p>Mesas Ocupadas</p>
                </div>
                <div class="icon">
                    {{-- ¡CAMBIO AQUÍ! Usamos 'fa-hockey-puck' (que se parece a una bola de billar) o 'fa-circle' --}}
                    <i class="fas fa-hockey-puck billar-icon"></i> 
                </div>
                <a href="#" class="small-box-footer">Ver estado de mesas <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        {{-- PRODUCTOS BAJO STOCK --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning"> {{-- Usamos 'warning' para alerta de stock --}}
                <div class="inner">
                    <h3>35</h3>
                    <p>Productos en Almacén</p>
                </div>
                <div class="icon">
                    <i class="fas fa-boxes"></i> 
                </div>
                <a href="{{ route('productos.index') }}" class="small-box-footer">
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
                <a href="{{ route('empleados.index') }}" class="small-box-footer">Ver empleados <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
    
    ---

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
                    {{-- Aquí iría un canvas para un gráfico (Chart.js recomendado) --}}
                    <p class="text-center text-muted">*(Espacio para gráfico de ingresos por día/semana)*</p>
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
                <div class="card-body p-0">
    <ul class="products-list product-list-in-card pl-2 pr-2">
        
        <li class="item">
            {{-- CERVEZA: Usamos el ícono de cerveza --}}
            <div class="product-img"><i class="fas fa-beer text-warning"></i></div>
            <div class="product-info">Cerveza <span class="badge bg-primary float-right">25 Unidades</span></div>
        </li>
        
        <li class="item">
            {{-- EMPANADAS: Usamos el ícono de taco/comida (o drumstick) --}}
            <div class="product-img"><i class="fas fa-cookie-bite text-warning"></i></div>
            <div class="product-info">Empanadas <span class="badge bg-primary float-right">18 Unidades</span></div>
        </li>
        
        <li class="item">
            {{-- GASEOSA COLA-COLA: Usamos el ícono de taza de café para representar una bebida simple o un vaso --}}
            <div class="product-img"><i class="fas fa-cocktail text-info"></i></div>
            <div class="product-info">Gaseosa Cola-cola <span class="badge bg-primary float-right">15 Unidades</span></div>
        </li>
        
        <li class="item">
            {{-- TINTO (VINO O CAFÉ): Usamos el ícono de copa de vino, que es más representativo de un bar/lounge --}}
            <div class="product-img"><i class="fas fa-mug-hot text-info"></i></div>
            <div class="product-info">Tinto <span class="badge bg-primary float-right">10 Unidades</span></div>
        </li>
        
    </ul>
</div>
                <div class="card-footer text-center">
                <a href="{{ route('productos.index') }}" class="uppercase">Ver Todos los Productos</a>
                </div>

            </div>
        </div>
    </div>

    ---

    {{-- 3. Fila de Listas y Métricas Adicionales --}}
    <div class="row">
        
        {{-- Tareas Pendientes o Eventos --}}
        <div class="col-md-6">
            <div class="card card-outline card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-calendar-alt mr-1"></i> Próximos Eventos/Torneos</h3>
                </div>
                <div class="card-body p-0">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                Torneo Semanal de Bola 8
                                <span class="float-right text-warning"><i class="far fa-calendar-alt"></i> 15/Oct/2025</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                Reunión de Inventario con Provedores
                                <span class="float-right text-muted"><i class="far fa-calendar-alt"></i> 20/Oct/2025</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- proveedores --}}
        <div class="col-md-6">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>$20<sup style="font-size: 20px">/proveedores</sup></h3>
                    <p>activos</p>
                </div>
                <div class="icon">
                    <i class="fas fa-bus"></i>
                </div>
                <a href="{{ route('proveedores.index') }}" class="small-box-footer">
                    ver proveedores <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
            
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
        /* Eliminamos el fondo de imagen del content-wrapper para un look más limpio */
        /* .content-wrapper { background: none !important; } */

        /* Ajustes finos a los Small Boxes para look ejecutivo */
        .small-box {
            border-radius: 0.5rem; /* Bordes ligeramente redondeados */
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .small-box:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0,0,0,0.1);
        }

        .small-box .inner h3 {
            font-weight: 700; /* Más audaz */
        }

        /* Usar colores de AdminLTE, pero puedes refinar más */
        .small-box.bg-info { background-color: #17a2b8 !important; }
        .small-box.bg-success { background-color: #28a745 !important; }
        .small-box.bg-warning { 
            background-color: #ffc107 !important; 
            color: #333 !important; /* Texto oscuro para la tarjeta amarilla */
        }
        .small-box.bg-primary { background-color: #007bff !important; }
        .small-box.bg-danger { background-color: #dc3545 !important; }
        .small-box.bg-secondary { background-color: #6c757d !important; }

        .small-box .icon { 
            font-size: 80px; /* Tamaño del icono grande */
            color: rgba(0, 0, 0, 0.15) !important; /* Icono gris más sutil */
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

        /* Estilo para la lista de productos (Products List - AdminLTE) */
        .products-list .product-img i {
            font-size: 24px;
            text-align: center;
            line-height: 49px;
            width: 50px;
            height: 50px;
            background-color: #f8f9fa;
            border-radius: 4px;
        }
    </style>
@stop

@section('js')
    @stack('scripts')
    {{-- Aquí iría la inicialización de Chart.js si lo usas --}}
    {{-- <script> /* Tu código de Chart.js aquí */ </script> --}}
@stop