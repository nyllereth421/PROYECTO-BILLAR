
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
                @forelse($productos as $producto)
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

                        <a href="{{ route('productos.edit', $producto->idproducto) }}"
                           class="btn btn-sm btn-warning btn-icon"
                           title="Editar"
                           data-toggle="tooltip">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button class="btn btn-sm btn-danger btn-icon"
                                onclick="confirmarEliminacion('{{ $producto->idproducto }}')"
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
            @if(method_exists($productos, 'links'))
            <div class="d-flex justify-content-center my-3">
                {{ $productos->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@section('css')
<style>
    .pagination .page-link {
        padding: 4px 10px !important;
        font-size: 1.3rem !important;
        border-radius: 6px !important;
        background: #2f3542 !important;
        color: #dcdcdc !important;
        border: 1px solid #555 !important;
    }

    .pagination .page-link:hover {
        background: #3d4350 !important;
        color: white !important;
    }

    .pagination .active .page-link {
        background: #007bff !important;
        border-color: #007bff !important;
        color: white !important;
    }

    .pagination .page-item {
        margin: 0 4px !important;
    }

</style>
@endsection

