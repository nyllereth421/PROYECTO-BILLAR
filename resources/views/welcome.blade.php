@extends('adminlte::page')

@section('title', $title ?? 'Dashboard Ejecutivo')

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
        @php
            $dias = ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'];
            $nombreDia = $dias[date('w')];
        @endphp

        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>
                        $<span id="ingresoDia">{{ number_format($ingresoDia ?? 0, 2) }}</span>
                        <sup style="font-size: 20px">/{{ $nombreDia }}</sup>
                    </h3>
                    <p>Ingresos del Día</p>
                </div>
                <div class="icon">
                    <i class="fas fa-dollar-sign"></i> 
                </div>
                <a href="{{ route('informes.index')}}" class="small-box-footer">
                    Ver reportes financieros <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        {{-- MESAS ACTIVAS/TOTAL --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3><span id="ocupadasCount">0</span><sup style="font-size: 20px">/<span id="mesasTotal">0</span></sup></h3>
                    <p>Mesas Ocupadas</p>
                    <div class="mt-2"><small id="listaMesasOcupadas" class="text-white">Cargando...</small></div>
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
                    <h3><span id="productosCount">0</span></h3>
                    <p>Productos Registrados</p>
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

    

    {{-- 2. Fila de Gráfico y Top Productos (CORREGIDA) --}}
    <div class="row">
        {{-- CARD para Gráfico de Ventas --}}
        <div class="col-md-7">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-bar mr-1"></i>
                        Rendimiento de Ventas (Semana Actual)
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="ventasSemanaChart" style="height:300px; min-height:300px"></canvas>
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
                    function iconoProductoDashboard($nombre) {
                        $nombre = strtolower($nombre);
                        if (str_contains($nombre, 'cerveza')) return 'fa-beer text-warning';
                        if (str_contains($nombre, 'gaseosa') || str_contains($nombre, 'cola')) return 'fa-cocktail text-info';
                        if (str_contains($nombre, 'empanada')) return 'fa-cookie-bite text-warning';
                        if (str_contains($nombre, 'tinto') || str_contains($nombre, 'café') || str_contains($nombre, 'cafe')) return 'fa-mug-hot text-danger';
                        if (str_contains($nombre, 'agua')) return 'fa-tint text-primary';
                        if (str_contains($nombre, 'papas') || str_contains($nombre, 'snack')) return 'fa-drumstick-bite text-success';
                        return 'fa-box-open text-secondary';
                    }
                @endphp

                <div class="card-body p-0">
                    <ul class="products-list product-list-in-card pl-2 pr-2">
                        @forelse ($productos ?? [] as $producto)
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
<style>
    .small-box {
        border-radius: 0.5rem;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .small-box:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(0,0,0,0.1);
    }

    .small-box .inner h3 { font-weight: 700; }

    .small-box.bg-info { background-color: #17a2b8 !important; }
    .small-box.bg-success { background-color: #28a745 !important; }
    .small-box.bg-warning { background-color: #ffc107 !important; color: #333 !important; }

    .small-box .icon { 
        font-size: 80px;
        color: rgba(0,0,0,0.15) !important;
    }

    /* Asegurar que las cards tengan la misma altura */
    .row > [class*='col-'] .card {
        height: 100%;
    }

    /* Fijar altura de la gráfica para evitar que se alargue */
    #ventasSemanaChart {
        max-height: 300px !important;
        height: 300px !important;
        width: 100% !important;
    }

    .card-body {
        position: relative;
    }
</style>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    let chartInstance = null;

    // === FUNCIÓN PARA ACTUALIZAR LA GRÁFICA ===
    function actualizarGrafica() {
        fetch('/ventas-semana')
            .then(response => response.json())
            .then(data => {
                const canvas = document.getElementById('ventasSemanaChart');
                if (!canvas) return;

                const ctx = canvas.getContext('2d');
                
                // Destruir gráfica anterior si existe
                if (chartInstance) {
                    chartInstance.destroy();
                }

                // Crear nueva gráfica con datos actualizados
                chartInstance = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.labels || [],
                        datasets: [{
                            label: 'Ventas de la Semana ($)',
                            data: data.valores || [],
                            borderColor: '#17a2b8',
                            backgroundColor: 'rgba(23, 162, 184, 0.2)',
                            borderWidth: 3,
                            tension: 0.4,
                            fill: true,
                            pointRadius: 5,
                            pointBackgroundColor: '#17a2b8',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointHoverRadius: 7
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { 
                                display: true, 
                                position: 'top',
                                labels: {
                                    font: { size: 12 }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const v = context.parsed.y ?? 0;
                                        return ' $' + Number(v).toLocaleString('es-CO', {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        });
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return '$' + Number(value).toLocaleString('es-CO');
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            })
            .catch(error => console.error('Error al actualizar gráfica:', error));
    }

    // === FUNCIÓN PARA ACTUALIZAR INGRESO DIARIO ===
    function actualizarIngresoDia() {
        fetch('/ingreso-dia')
            .then(response => response.json())
            .then(data => {
                const ingreso = Number(data.ingresoDia || 0);
                const elemento = document.getElementById('ingresoDia');
                if (elemento) {
                    elemento.textContent = new Intl.NumberFormat('es-CO', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }).format(ingreso);
                }
            })
            .catch(error => console.error('Error al actualizar ingreso diario:', error));
    }

    // === FUNCIÓN PARA ACTUALIZAR MESAS OCUPADAS (TIEMPO REAL) ===
    function actualizarMesasOcupadas() {
        fetch('/mesas-ocupadas')
            .then(response => response.json())
            .then(data => {
                const ocupadas = Number(data.ocupadas || 0);
                const total = Number(data.total || 0);

                const ocupadasEl = document.getElementById('ocupadasCount');
                const totalEl = document.getElementById('mesasTotal');
                const listaEl = document.getElementById('listaMesasOcupadas');

                if (ocupadasEl) ocupadasEl.textContent = ocupadas;
                if (totalEl) totalEl.textContent = total;

                if (listaEl) {
                    const mesas = (data.mesas || []).map(m => m.numeromesa);
                    listaEl.textContent = mesas.length ? 'Mesas: ' + mesas.join(', ') : 'No hay mesas ocupadas';
                }
            })
            .catch(error => console.error('Error al actualizar mesas ocupadas:', error));
    }

    // === FUNCIÓN PARA ACTUALIZAR CANTIDAD DE PRODUCTOS REGISTRADOS ===
    function actualizarProductosRegistrados() {
        fetch('/productos-cantidad')
            .then(response => response.json())
            .then(data => {
                const cantidad = Number(data.cantidad || 0);
                const el = document.getElementById('productosCount');
                if (el) el.textContent = cantidad;
            })
            .catch(error => console.error('Error al obtener cantidad de productos:', error));
    }

    // Llamadas inmediatas al cargar la página
    actualizarGrafica();
    actualizarIngresoDia();
    actualizarMesasOcupadas();
    actualizarProductosRegistrados();

    // Actualizar cada 10 segundos
    setInterval(actualizarGrafica, 10000);
    setInterval(actualizarIngresoDia, 10000);
    setInterval(actualizarMesasOcupadas, 10000);
    setInterval(actualizarProductosRegistrados, 10000);
});
</script>
@stop