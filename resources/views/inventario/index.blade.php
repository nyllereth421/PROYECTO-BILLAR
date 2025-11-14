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
                <a href="{{ route('welcome') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left mr-2"></i>Volver al Inicio
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
                        61
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
                        4<span class="text-light opacity-75">/18</span>
                        <sup class="sup-text">mesas</sup>
                    </h3>
                    <p class="card-subtitle">Mesas Registradas</p>
                    <div class="progress mt-2" style="height: 4px;">
                        <div class="progress-bar bg-white" role="progressbar" style="width: 33%"></div>
                    </div>
                    <small class="text-light opacity-90">33% ocupación actual</small>
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
                        5
                        <sup class="sup-text">proveedores</sup>
                    </h3>
                    <p class="card-subtitle">Proveedores Activos</p>
                    <div class="progress mt-2" style="height: 4px;">
                        <div class="progress-bar bg-white" role="progressbar" style="width: 95%"></div>
                    </div>
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
</div>
@stop

@section('css')
<style>
    /* Mejoras generales */
    .content-header {
        padding: 1.5rem 0;
    }

    /* Small boxes mejorados */
    .small-box {
        border-radius: 12px;
        transition: all 0.3s ease;
        border: none;
        overflow: hidden;
    }

    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
    }

    .small-box .inner {
        padding: 20px;
    }

    .small-box h3 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .sup-text {
        font-size: 0.9rem !important;
        font-weight: 500;
        opacity: 0.9;
        margin-left: 5px;
    }

    .card-subtitle {
        font-size: 1rem;
        font-weight: 500;
        margin-bottom: 0;
        opacity: 0.95;
    }

    .small-box .icon {
        font-size: 4rem;
        opacity: 0.2;
        transition: all 0.3s ease;
    }

    .small-box:hover .icon {
        font-size: 4.5rem;
        opacity: 0.3;
    }

    .small-box-footer {
        padding: 10px 20px;
        background: rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .small-box-footer:hover {
        background: rgba(0, 0, 0, 0.15);
        color: white !important;
    }

    /* Animación de números */
    @keyframes countUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-number {
        animation: countUp 0.6s ease-out;
    }

    /* Cards de acceso rápido */
    .quick-access-card {
        display: flex;
        align-items: center;
        padding: 15px;
        background: white;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        text-decoration: none;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .quick-access-card:hover {
        border-color: #007bff;
        transform: translateX(5px);
        box-shadow: 0 4px 15px rgba(0, 123, 255, 0.1);
    }

    .quick-access-icon {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        margin-right: 15px;
        flex-shrink: 0;
    }

    .quick-access-content h6 {
        color: #495057;
        font-weight: 600;
        margin-bottom: 2px;
    }

    .quick-access-arrow {
        margin-left: auto;
        color: #ced4da;
        transition: all 0.3s ease;
    }

    .quick-access-card:hover .quick-access-arrow {
        color: #007bff;
        transform: translateX(5px);
    }

    /* Progress bars mejorados */
    .progress {
        background-color: rgba(255, 255, 255, 0.3);
        border-radius: 10px;
        overflow: hidden;
    }

    .progress-bar {
        transition: width 1s ease;
        border-radius: 10px;
    }

    .progress-group .progress {
        background-color: #e9ecef;
    }

    /* Cards generales */
    .card {
        border: none;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08) !important;
    }

    .card-header {
        border-radius: 12px 12px 0 0 !important;
    }

    /* Badges mejorados */
    .badge-pill {
        padding: 6px 12px;
        font-weight: 600;
        font-size: 0.85rem;
    }

    /* List group items */
    .list-group-item {
        padding-top: 12px;
        padding-bottom: 12px;
        transition: all 0.2s ease;
    }

    .list-group-item:hover {
        background-color: #f8f9fa;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .small-box h3 {
            font-size: 2rem;
        }
        
        .small-box .icon {
            font-size: 3rem;
        }

        .quick-access-card {
            margin-bottom: 10px;
        }
    }

    /* Gradientes personalizados */
    .bg-gradient-info {
        background: linear-gradient(135deg, #17a2b8 0%, #138496 100%) !important;
    }

    .bg-gradient-success {
        background: linear-gradient(135deg, #28a745 0%, #218838 100%) !important;
    }

    .bg-gradient-warning {
        background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%) !important;
    }

    /* Opacidad para texto sobre fondos */
    .opacity-75 {
        opacity: 0.75;
    }

    .opacity-90 {
        opacity: 0.9;
    }
</style>
@stop

@section('js')
<script>
    // Animación de números al cargar
    document.addEventListener('DOMContentLoaded', function() {
        // Aquí puedes agregar lógica para animar los números si lo deseas
        console.log('Vista de inventario cargada');
    });
</script>
@stop