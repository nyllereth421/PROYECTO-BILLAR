@extends('adminlte::page')

@section('title', 'Gestión de Productos')

@section('content_header')
    <div class="container-fluid">
        <div class="row align-items-center justify-content-between py-3">
            <div class="col-md-8">
                <h1 class="text-dark font-weight-bold mb-2">
                    <i class="fas fa-boxes mr-3 text-primary"></i> 
                    Gestión de Productos
                </h1>
                <p class="text-muted mb-0 ml-5 pl-2">
                    <i class="fas fa-box mr-2 text-info"></i>
                    Administra tu catálogo de productos e inventario
                </p>
            </div>
            <div class="col-md-4 text-right">
                <span class="badge badge-info badge-lg px-4 py-2">
                    <i class="fas fa-boxes mr-2"></i>
                    {{ count($productosAll) }} Productos
                </span>
            </div>
        </div>
    </div>
@stop

@section('content')
<div class="container-fluid">

    {{-- ALERTAS --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-check-circle fa-2x mr-3"></i>
            <div>
                <h5 class="alert-heading mb-1">¡Operación Exitosa!</h5>
                <p class="mb-0">{{ session('success') }}</p>
            </div>
        </div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-exclamation-circle fa-2x mr-3"></i>
            <div>
                <h5 class="alert-heading mb-1">¡Error!</h5>
                <p class="mb-0">{{ session('error') }}</p>
            </div>
        </div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if(session('alerta_stock'))
    <div class="alert alert-warning alert-dismissible fade show shadow-sm" id="alertaStockAutomatica" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-exclamation-triangle fa-2x mr-3"></i>
            <div>
                <h5 class="alert-heading mb-1">Alerta de Stock</h5>
                <p class="mb-0">{{ session('alerta_stock') }}</p>
            </div>
        </div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    {{-- ESTADÍSTICAS RÁPIDAS --}}
    <div class="row mb-4">
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="info-card bg-gradient-info">
                <div class="info-card-icon">
                    <i class="fas fa-boxes"></i>
                </div>
                <div class="info-card-content">
                    <h3 class="mb-0">{{ count($productosAll) }}</h3>
                    <p class="mb-0">Productos Totales</p>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-3">
            <div class="info-card bg-gradient-success">
                <div class="info-card-icon">
                    <i class="fas fa-warehouse"></i>
                </div>
                <div class="info-card-content">
                    <h3 class="mb-0">{{ $productosAll->sum('stock') }}</h3>
                    <p class="mb-0">Stock Total en Inventario</p>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-3">
            <div class="info-card bg-gradient-warning">
                <div class="info-card-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="info-card-content">
                    <h3 class="mb-0">{{ $productosAll->where('stock', '<', 10)->count() }}</h3>
                    <p class="mb-0">Stock Bajo</p>
                </div>
            </div>
        </div>
    </div>

    {{-- BARRA DE ACCIONES --}}
    <div class="card border-0 shadow-lg mb-4">
        <div class="card-body py-3">
            <div class="row align-items-center">
                <div class="col-md-3 mb-2 mb-md-0">
                    <a href="{{ route('inventario.index') }}" class="btn btn-outline-secondary btn-lg btn-block">
                        <i class="fas fa-arrow-left mr-2"></i> Volver
                    </a>
                </div>
                <div class="col-md-6 mb-2 mb-md-0">
                    <div class="input-group shadow-sm">
                        <span class="input-group-text bg-white">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text"
                            id="buscarProducto"
                            class="form-control form-control-lg"
                            placeholder="Buscar por ID, Nombre, Descripción..."
                            autocomplete="off">
                        <button type="button" class="btn btn-outline-danger" id="btnLimpiar">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-3 text-md-right">
                    <a href="{{ route('productos.create') }}" class="btn btn-primary btn-lg btn-block"> 
                        <i class="fas fa-plus-circle mr-2"></i> Nuevo
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- TABLA DE PRODUCTOS MEJORADA --}}
    <div id="contenedorTablaProductos">
        @include('productos._tabla', ['productos' => $productos])
    </div>



    
@stop

@section('css')
<style>
    /* Background mejorado */
    body {
        background-color: transparent;
    }

    /* Header mejorado */
    .content-header {
        background: transparent;
        border-radius: 15px;
        margin-bottom: 1.5rem;
        padding: 1rem 0;
    }

    /* Badge mejorado */
    .badge-lg {
        font-size: 1.1rem;
        padding: 10px 20px;
        border-radius: 25px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    /* Info Cards */
    .info-card {
        border-radius: 15px;
        padding: 25px;
        color: white;
        display: flex;
        align-items: center;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
    }

    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
    }

    .info-card-icon {
        width: 70px;
        height: 70px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin-right: 20px;
    }

    .info-card-content h3 {
        font-size: 2rem;
        font-weight: 700;
    }

    .info-card-content p {
        font-size: 0.95rem;
        opacity: 0.95;
    }

    /* Gradientes */
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .bg-gradient-success {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    }

    .bg-gradient-warning {
        background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);
    }

    .bg-gradient-info {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }

    .bg-gradient-danger {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    }

    /* Tabla mejorada */
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.075);
        cursor: pointer;
    }

    .badge {
        font-size: 0.9rem;
    }

    #buscarProducto:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .alert {
        border-left: 4px solid;
    }

    .alert-success {
        border-left-color: #28a745;
    }

    .alert-warning {
        border-left-color: #ffc107;
    }

    .alert-danger {
        border-left-color: #dc3545;
    }

    /* Estilos para el símbolo circular */
    .symbol {
        display: inline-flex;
        flex-shrink: 0;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
    }

    .symbol-label {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
    }

    /* Botones iconos */
    .btn-icon {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 4px;
        margin: 0 2px;
    }

    .btn-icon i {
        font-size: 14px;
    }

    /* Mejoras en la tabla */
    .table thead th {
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table td {
        vertical-align: middle;
    }

    /* Badge pills */
    .badge-pill {
        padding: 0.35em 0.65em;
        font-weight: 600;
    }

    /* Animaciones suaves */
    .fila-producto {
        transition: all 0.3s ease;
    }

    .fila-producto:hover {
        transform: translateX(5px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    /* Tooltips */
    [data-toggle="tooltip"] {
        cursor: pointer;
    }

    /* Botones con sombra */
    .btn-lg {
        padding: 0.75rem 1.5rem;
        font-size: 1rem;
        border-radius: 8px;
    }

    /* Cards con bordes suaves */
    .card {
        border-radius: 12px;
        border: none;
    }

    .card-header {
        border-radius: 12px 12px 0 0;
    }

    .card-body {
        padding: 1.5rem;
    }

    /* Responsivo */
    @media (max-width: 768px) {
        .info-card {
            margin-bottom: 1rem;
        }

        .btn-lg {
            width: 100%;
            margin-bottom: 0.5rem;
        }

        .badge-lg {
            font-size: 0.9rem;
            padding: 8px 16px;
        }
    }
</style>
@stop

@section('js')
<script>
    console.log('Vista de productos mejorada lista 🟢');

    // Ocultar alerta de stock automáticamente
    const alerta = document.getElementById('alertaStockAutomatica');
    if (alerta) {
        setTimeout(() => {
            $(alerta).fadeOut(500, function() {
                $(this).remove();
            });
        }, 5000);
    }

    // Variables globales
    let timeoutBusqueda;
    const inputBuscar = document.getElementById('buscarProducto');
    const tbody = document.getElementById('tablaProductosBody');
    const contadorCantidad = document.getElementById('cantidadMostrada');

    // Búsqueda en tiempo real (filtrado del lado del cliente)
    inputBuscar.addEventListener('keyup', function() {
        clearTimeout(timeoutBusqueda);

        const termino = this.value.trim().toLowerCase();

        // Esperar 300ms después de que el usuario deje de escribir
        timeoutBusqueda = setTimeout(() => {
            filtrarProductos(termino);
        }, 300);
    });

    // Función para filtrar productos en tiempo real
    function filtrarProductos(termino) {
        const filas = document.querySelectorAll('.fila-producto');
        let contadorVisible = 0;

        if (termino === '') {
            // Mostrar todas las filas si no hay búsqueda
            filas.forEach(fila => {
                fila.style.display = '';
                contadorVisible++;
            });
        } else {
            // Filtrar filas según el término de búsqueda
            filas.forEach(fila => {
                const id = fila.getAttribute('data-id');
                const nombre = fila.getAttribute('data-nombre');
                const descripcion = fila.getAttribute('data-descripcion');

                // Buscar en ID, nombre y descripción
                const coincide =
                    id.includes(termino) ||
                    nombre.includes(termino) ||
                    descripcion.includes(termino);

                if (coincide) {
                    fila.style.display = '';
                    contadorVisible++;
                } else {
                    fila.style.display = 'none';
                }
            });
        }

        // Actualizar contador
        if (contadorCantidad) {
            contadorCantidad.textContent = contadorVisible;
        }

        // Mostrar mensaje si no hay resultados
        mostrarMensajeSinResultados(contadorVisible);
    }

    // Mostrar mensaje cuando no hay resultados
    function mostrarMensajeSinResultados(cantidad) {
        const mensajeExistente = document.getElementById('mensajeSinResultados');

        if (cantidad === 0 && !mensajeExistente) {
            const mensaje = `
                <tr id="mensajeSinResultados">
                    <td colspan="7" class="text-center py-5">
                        <div class="text-muted">
                            <i class="fas fa-search fa-3x mb-3"></i>
                            <h5>No se encontraron productos</h5>
                            <p>Intenta con otros términos de búsqueda</p>
                        </div>
                    </td>
                </tr>
            `;
            tbody.insertAdjacentHTML('beforeend', mensaje);
        } else if (cantidad > 0 && mensajeExistente) {
            mensajeExistente.remove();
        }
    }

    // Limpiar búsqueda
    document.getElementById('btnLimpiar').addEventListener('click', function() {
        inputBuscar.value = '';
        filtrarProductos('');
    });

    // Confirmar eliminación
    function confirmarEliminacion(id) {
        // Si tienes SweetAlert2 instalado
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción no se puede revertir",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        'Información',
                        'Este producto no se puede eliminar para proteger el historial de ventas',
                        'info'
                    );
                }
            });
        } else {
            // Fallback si no hay SweetAlert2
            alert('❌ Este producto NO se puede eliminar para proteger el historial de ventas');
        }
    }

    // Hacer la función global para que funcione desde el onclick
    window.confirmarEliminacion = confirmarEliminacion;

    // Si hay un término de búsqueda inicial, aplicar filtro
    @if($buscar)
        filtrarProductos('{{ strtolower($buscar) }}');
    @endif


    document.addEventListener('DOMContentLoaded', function () {
        const inputBuscar = document.getElementById('buscarProducto');
        const btnLimpiar = document.getElementById('btnLimpiar');
        const contenedorTabla = document.getElementById('contenedorTablaProductos'); // div que envuelve la tabla

        let timeout;

        inputBuscar.addEventListener('keyup', function () {
            clearTimeout(timeout);

            timeout = setTimeout(() => {
                const valor = inputBuscar.value;

                fetch(`{{ route('productos.buscar') }}?buscar=` + encodeURIComponent(valor))
                    .then(res => res.text())
                    .then(html => {
                        contenedorTabla.innerHTML = html;
                    })
                    .catch(err => console.error(err));
            }, 300); // pequeño delay para no saturar el servidor
        });

        btnLimpiar.addEventListener('click', function () {
            inputBuscar.value = '';
            inputBuscar.dispatchEvent(new Event('keyup'));
        });
    });


</script>

@include('components.sweetalert-global')
@stop
