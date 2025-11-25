@extends('adminlte::page')

@section('title', 'Gestión de Productos')

@section('content_header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">
                        <i class="fas fa-boxes text-primary"></i> Gestión de Productos
                    </h1>
                    <p class="text-muted">Administra tu catálogo de productos e inventario</p>
                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        <span class="badge badge-primary p-2" style="font-size: 1.1rem;">
                            <i class="fas fa-box"></i> {{ count($productos) }} Productos
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
<div class="container-fluid">

    {{-- ALERTA DE ÉXITO MEJORADA --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <h5><i class="icon fas fa-check-circle"></i> ¡Operación Exitosa!</h5>
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <h5><i class="icon fas fa-exclamation-triangle"></i> Error</h5>
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    {{-- ALERTA DE STOCK --}}
    @if(session('alerta_stock'))
        <div class="alert alert-warning alert-dismissible fade show shadow-sm" id="alertaStockAutomatica" role="alert">
            <h5><i class="icon fas fa-box-open"></i> Alerta de Stock</h5>
            {{ session('alerta_stock') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    {{-- BARRA DE ACCIONES --}}
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <a href="{{ route('inventario.index') }}" class="btn btn-outline-secondary mb-2">
                    <i class="fas fa-arrow-left"></i> Volver a Inventario
                </a>
                <a href="{{ route('productos.create') }}" class="btn btn-success mb-2">
                    <i class="fas fa-plus-circle"></i> Nuevo Producto
                </a>
            </div>
        </div>
    </div>

    {{-- ESTADÍSTICAS RÁPIDAS --}}
    <div class="row mb-4">
        <div class="col-lg-4 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ count($productos) }}</h3>
                    <p>Productos Totales</p>
                </div>
                <div class="icon">
                    <i class="fas fa-boxes"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $productos->sum('stock') }}</h3>
                    <p>Stock Total en Inventario</p>
                </div>
                <div class="icon">
                    <i class="fas fa-warehouse"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $productos->where('stock', '<', 10)->count() }}</h3>
                    <p>Productos con Stock Bajo</p>
                </div>
                <div class="icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- BUSCADOR EN TIEMPO REAL --}}
    <div class="row mb-3">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                        </div>
                        <input type="text" 
                               id="buscarProducto" 
                               class="form-control form-control-lg" 
                               placeholder="Buscar por ID, Nombre o Descripción..."
                               autocomplete="off"
                               value="{{ $buscar ?? '' }}">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-outline-secondary" id="btnLimpiar" title="Limpiar Búsqueda">
                                <i class="fas fa-times"></i> Limpiar
                            </button>
                        </div>
                    </div>
                    <small class="text-muted">
                        <i class="fas fa-info-circle"></i> La búsqueda filtra en tiempo real todos los productos registrados
                    </small>
                </div>
            </div>
        </div>
    </div>

    {{-- TABLA DE PRODUCTOS MEJORADA --}}
    <div class="card shadow-sm">
        <div class="card-header bg-gradient-primary">
            <h3 class="card-title">
                <i class="fas fa-list-alt"></i> Listado de Productos
            </h3>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0" id="tablaProductos">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-center" style="width: 40px;">#</th>
                            <th style="width: 35%;">Producto</th>
                            <th class="text-center" style="width: 15%;">Precio</th>
                            <th class="text-center" style="width: 15%;">Stock</th>
                            <th class="text-center" style="width: 15%;">Vendidas</th>
                            <th class="text-center" style="width: 150px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tablaProductosBody">
                        @forelse($productos as $index => $producto)
                            <tr class="fila-producto" 
                                data-id="{{ $producto->idproducto }}" 
                                data-nombre="{{ strtolower($producto->nombre) }}" 
                                data-descripcion="{{ strtolower($producto->descripcion ?? '') }}">
                                <td class="text-center align-middle">
                                    <span class="badge badge-primary badge-pill">{{ $producto->idproducto }}</span>
                                </td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        <div class="symbol symbol-40 symbol-light-primary mr-3">
                                            <span class="symbol-label bg-primary text-white rounded-circle">
                                                <i class="fas fa-box fa-lg"></i>
                                            </span>
                                        </div>
                                        <div>
                                            <strong class="d-block text-dark">{{ $producto->nombre }}</strong>
                                            @if($producto->descripcion)
                                                <small class="text-muted d-block">
                                                    <i class="fas fa-align-left"></i> {{ Str::limit($producto->descripcion, 50) }}
                                                </small>
                                            @endif
                                            @if($producto->proveedor)
                                                <small class="text-info d-block">
                                                    <i class="fas fa-truck"></i> {{ $producto->proveedor->nombre }}
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center align-middle">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="fas fa-dollar-sign text-success mb-1"></i>
                                        <strong class="text-success">${{ number_format($producto->precio, 0, ',', '.') }}</strong>
                                    </div>
                                </td>
                                <td class="text-center align-middle">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="fas fa-warehouse mb-1 {{ $producto->stock < 10 ? 'text-warning' : 'text-info' }}"></i>
                                        @if($producto->stock < 10)
                                            <span class="badge badge-warning">
                                                <i class="fas fa-exclamation-triangle"></i> {{ $producto->stock }}
                                            </span>
                                        @else
                                            <span class="badge badge-success">{{ $producto->stock }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-center align-middle">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="fas fa-shopping-cart text-primary mb-1"></i>
                                        <span class="badge badge-info badge-pill">{{ $producto->cantidad_vendida ?? 0 }}</span>
                                    </div>
                                </td>
                                <td class="text-center align-middle">
                                    <button class="btn btn-sm btn-info btn-icon" 
                                            onclick="verDetalles({{ $producto->idproducto }})" 
                                            title="Ver Detalles"
                                            data-toggle="tooltip">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <a href="{{ route('productos.edit', $producto->idproducto) }}" 
                                       class="btn btn-sm btn-warning btn-icon" 
                                       title="Editar"
                                       data-toggle="tooltip">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-sm btn-danger btn-icon" 
                                            onclick="confirmarEliminacion({{ $producto->idproducto }})" 
                                            title="Eliminar"
                                            data-toggle="tooltip">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr id="noResultados">
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-inbox fa-3x mb-3 text-secondary"></i>
                                        <h5>No hay productos registrados</h5>
                                        <p>Comienza agregando tu primer producto</p>
                                        <a href="{{ route('productos.create') }}" class="btn btn-success mt-2">
                                            <i class="fas fa-plus-circle"></i> Crear Producto
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if(count($productos) > 0)
            <div class="card-footer bg-light">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <p class="text-muted mb-0">
                            <i class="fas fa-info-circle"></i> 
                            Mostrando <strong id="cantidadMostrada">{{ count($productos) }}</strong> producto(s)
                        </p>
                    </div>
                    <div class="col-md-6 text-right">
                        <small class="text-muted">
                            <i class="fas fa-shield-alt"></i> Los productos con ventas asociadas están protegidos
                        </small>
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- MODAL DE DETALLES --}}
    <div class="modal fade" id="modalDetalles" tabindex="-1" role="dialog" aria-labelledby="modalDetallesLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalDetallesLabel">
                        <i class="fas fa-box-open"></i> Detalles del Producto
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">
                                    <i class="fas fa-tag text-primary"></i> Nombre del Producto
                                </label>
                                <p class="form-control-static" id="detalle-nombre">-</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">
                                    <i class="fas fa-barcode text-info"></i> ID Producto
                                </label>
                                <p class="form-control-static" id="detalle-id">-</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="font-weight-bold">
                                    <i class="fas fa-align-left text-secondary"></i> Descripción
                                </label>
                                <p class="form-control-static" id="detalle-descripcion">-</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="font-weight-bold">
                                    <i class="fas fa-dollar-sign text-success"></i> Precio
                                </label>
                                <p class="form-control-static text-success font-weight-bold" id="detalle-precio">-</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="font-weight-bold">
                                    <i class="fas fa-warehouse text-info"></i> Stock
                                </label>
                                <p class="form-control-static" id="detalle-stock">-</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="font-weight-bold">
                                    <i class="fas fa-shopping-cart text-primary"></i> Cantidad Vendida
                                </label>
                                <p class="form-control-static" id="detalle-vendida">-</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="font-weight-bold">
                                    <i class="fas fa-truck text-warning"></i> Proveedor
                                </label>
                                <p class="form-control-static" id="detalle-proveedor">-</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>
@stop

@section('css')
<style>
    /* Mejoras visuales */
    .small-box {
        border-radius: 0.5rem;
        box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(0,123,255,.075);
        cursor: pointer;
    }
    
    .badge {
        font-size: 0.9rem;
    }
    
    #buscarProducto:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
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

    /* Modal personalizado */
    .modal-header.bg-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .form-control-static {
        padding: 8px 12px;
        background-color: #f8f9fa;
        border-radius: 4px;
        min-height: 38px;
        display: flex;
        align-items: center;
    }

    /* Animaciones suaves */
    .fila-producto {
        transition: all 0.3s ease;
    }

    .fila-producto:hover {
        transform: translateX(5px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    /* Tooltips */
    [data-toggle="tooltip"] {
        cursor: pointer;
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
</script>
@stop