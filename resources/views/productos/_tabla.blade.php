{{-- PAGINACIÓN --}}
            <div class="d-flex justify-content-center mt-2 mt-md-0">
                {{ $productos->links('pagination::bootstrap-4') }}
            </div>
{{-- TABLA DE PRODUCTOS ESTILO PROVEEDORES --}}
<div class="card shadow-sm rounded-4">

    {{-- ENCABEZADO --}}
    <div class="card-header bg-gradient-primary text-white rounded-top-4">
        <h3 class="card-title font-weight-bold mb-0">
            <i class="fas fa-boxes mr-2"></i> Listado de Productos
        </h3>
    </div>

    {{-- BODY TABLA --}}
    <div class="card-body p-0 rounded-bottom-4">
        <div class="table-responsive rounded">
            <table class="table table-hover table-striped mb-0">

                <thead class="bg-light text-dark">
                    <tr>
                        <th class="text-center"><i class="fas fa-hashtag text-primary"></i> Id</th>
                        <th class="text-center"><i class=" fas fa-box text-primary mr-2"></i> Producto</th>
                        <th class="text-center"><i class="fas fa-dollar-sign text-success"> </i> Precio</th>
                        <th class="text-center"><i class="fas fa-warehouse text-info"></i> stock</th>
                        <th class="text-center"><i class="fas fa-shopping-cart text-primary"> </i> Ventas</th>
                        <th class="text-center"><i class="fas fa-cogs text-warning"></i></th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($productos as $producto)
                    <tr class="fila-producto">

                        {{-- ID --}}
                        <td class="text-center align-middle">
                            <span class="badge badge-primary badge-pill shadow-sm">
                                {{ $producto->idproducto }}
                            </span>
                        </td>

                        {{-- NOMBRE / DETALLES --}}
                        <td class="align-middle">
                            <div class="d-flex align-items-center">

                                <!-- ICONO REDONDO COMO PROVEEDORES -->
                                <div class="symbol symbol-40 symbol-light-primary mr-3 shadow-sm">
                                    <span class="symbol-label bg-primary text-white rounded-circle">
                                        <i class="fas fa-box fa-lg"></i>
                                    </span>
                                </div>

                                <div>
                                    <strong class="text-dark d-block">{{ $producto->nombre }}</strong>

                                    @if($producto->descripcion)
                                    <small class="text-muted d-block">
                                        <i class="fas fa-align-left"></i>
                                        {{ Str::limit($producto->descripcion, 50) }}
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

                        {{-- PRECIO --}}
                        <td class="text-center align-middle">
                            <strong class="text-success">
                                ${{ number_format($producto->precio, 0, ',', '.') }}
                            </strong>
                        </td>

                        {{-- STOCK --}}
                        <td class="text-center align-middle">
                            <i class="fas fa-warehouse mb-1 
                                {{ $producto->stock < 10 ? 'text-warning' : 'text-info' }}">
                            </i>

                            @if($producto->stock < 10)
                                <span class="badge badge-warning shadow-sm">
                                    <i class="fas fa-exclamation-triangle"></i> {{ $producto->stock }}
                                </span>
                            @else
                                <span class="badge badge-success shadow-sm">{{ $producto->stock }}</span>
                            @endif
                        </td>

                        {{-- VENDIDAS --}}
                        <td class="text-center align-middle">
                            <span class="badge badge-info shadow-sm">
                                <i class="fas fa-shopping-cart"></i> {{ $producto->cantidad_vendida ?? 0 }}
                            </span>
                        </td>

                        {{-- ACCIONES --}}
                        <td class="text-center align-middle">
                            <div class="btn-group">

                                {{-- EDITAR --}}
                                <a href="{{ route('productos.edit', $producto->idproducto) }}"
                                   class="btn btn-sm btn-warning shadow-sm" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>

                                {{-- ELIMINAR --}}
                                <button class="btn btn-sm btn-danger shadow-sm"
                                        onclick="confirmarEliminacion('{{ $producto->idproducto }}')"
                                        title="Eliminar">
                                    <i class="fas fa-trash-alt"></i>
                                </button>

                            </div>
                        </td>

                    </tr>
                    @empty

                    {{-- SIN PRODUCTOS --}}
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div>
                                <i class="fas fa-inbox fa-3x text-secondary mb-3"></i>
                                <h5 class="text-muted">No hay productos registrados</h5>
                                <p class="text-muted">Comienza agregando tu primer producto</p>
                                <a href="{{ route('productos.create') }}" class="btn btn-success shadow-sm">
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

    {{-- FOOTER --}}
    <div class="card-footer bg-light border-top rounded-bottom-4">
        <small class="text-muted">
            <i class="fas fa-info-circle"></i>
            Mostrando <strong>{{ $productos->count() }}</strong> de 
            <strong>{{ $productos->total() }}</strong> productos
        </small>
    </div>

</div>
