@extends('adminlte::page')
@section('title', $title ?? 'Página principal')

@section('content')
    
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <h1 class="text-center font-weight-bold">Bienvenido a Billar Nexus</h1>
                <p class="text-center text-muted">Panel de gestión del sistema</p>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">

                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-secondary">
                            <div class="inner">
                                <h3>7</h3>
                                <p>Empleados</p>
                            </div>
                            <div class="icon">
                                {{-- Icono de Personas con Colores Vivos --}}
                                <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" viewBox="0 0 24 24" fill="none">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" fill="#c0c0c0" stroke="#606060" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <circle cx="9" cy="7" r="4" fill="#ffcc99" stroke="#606060" stroke-width="2"></circle>
                                    <path d="M22 21v-2a4 4 0 0 0-3-3.87" stroke="#606060" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75" stroke="#ffcc99" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </div>
                            <a href="#" class="small-box-footer">
                                Ver empleados <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>12</h3>
                                <p>Mesas de Billar</p>
                            </div>
                            <div class="icon">
                                {{-- Icono de Mesa de Billar con Colores Vivos --}}
                                <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" viewBox="0 0 120 80">
                                    <rect x="10" y="15" width="100" height="50" rx="8" ry="8" fill="#4CAF50" stroke="#4E342E" stroke-width="3"/>
                                    <rect x="15" y="20" width="90" height="40" rx="4" ry="4" fill="#66BB6A" stroke="#4CAF50" stroke-width="2"/>
                                    
                                    <circle cx="35" cy="40" r="5" fill="#fff" stroke="#333" stroke-width="0.5"/>
                                    <circle cx="50" cy="35" r="5" fill="#FFC107" stroke="#333" stroke-width="0.5"/>
                                    <circle cx="50" cy="45" r="5" fill="#2196F3" stroke="#333" stroke-width="0.5"/>
                                    <circle cx="65" cy="40" r="5" fill="#F44336" stroke="#333" stroke-width="0.5"/>
                                    <circle cx="80" cy="40" r="5" fill="#000" stroke="#fff" stroke-width="1.5"/>
                                    
                                    <rect x="15" y="60" width="4" height="15" fill="#8D6E63"/>
                                    <rect x="101" y="60" width="4" height="15" fill="#8D6E63"/>
                                </svg>
                            </div>
                            <a href="#" class="small-box-footer">Ver mesas <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h3>35</h3>
                                <p>Productos</p>
                            </div>
                            <div class="icon">
                                {{-- Icono de Comida / Bandeja con alimentos --}}
                                <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" viewBox="0 0 24 24" fill="none">
                                    {{-- Bandeja - Gris metalico --}}
                                    <rect x="2" y="10" width="20" height="10" rx="2" ry="2" fill="#B0BEC5" stroke="#78909C" stroke-width="2"></rect>
                                    {{-- Borde superior de la bandeja --}}
                                    <path d="M2 10h20c-1 0-2 1-2 2s1 2 2 2" fill="none" stroke="#78909C" stroke-width="2" stroke-linecap="round"></path>

                                    {{-- Comida 1 (ej. papas) - Amarillo --}}
                                    <circle cx="8" cy="14" r="3" fill="#FFC107" stroke="#FF8F00" stroke-width="1"></circle>
                                    <circle cx="11" cy="17" r="2.5" fill="#FFC107" stroke="#FF8F00" stroke-width="1"></circle>

                                    {{-- Comida 2 (ej. hamburguesa/sándwich) - Marrón/rojo --}}
                                    <rect x="13" y="12" width="7" height="4" rx="1" fill="#D32F2F" stroke="#B71C1C" stroke-width="1"></rect>
                                    <rect x="14" y="13" width="5" height="2" fill="#FFEB3B"></rect> {{-- para simular queso/pan --}}

                                    {{-- Comida 3 (ej. bebida/vaso) - Azul claro --}}
                                    <rect x="5" y="6" width="4" height="6" rx="1" ry="1" fill="#B2EBF2" stroke="#4DD0E1" stroke-width="1"></rect>
                                    <rect x="5.5" y="6.5" width="3" height="1" fill="#FFFFFF" opacity="0.7"></rect> {{-- brillo --}}
                                </svg>
                            </div>
                            <a href="{{ route('productos.index') }}" class="small-box-footer">Ver productos <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-secondary">
                            <div class="inner">
                                <h3>5</h3>
                                <p>Torneos</p>
                            </div>
                            <div class="icon">
                                {{-- Icono de Trofeo con Colores Vivos --}}
                                <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" viewBox="0 0 24 24" fill="none">
                                    <path d="M18 2H6v7a6 6 0 0 0 12 0V2Z" fill="#FFD700" stroke="#B8860B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6" stroke="#FFD700" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18" stroke="#FFD700" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M4 22h16" stroke="#8B4513" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22" stroke="#FFD700" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22" stroke="#FFD700" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <circle cx="12" cy="5" r="1.5" fill="#CD7F32"></circle>
                                </svg>
                            </div>
                            <a href="#" class="small-box-footer">Ver torneos <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>$450</h3>
                                <p>Ingresos</p>
                            </div>
                            <div class="icon">
                                {{-- Icono de Dinero con Colores Vivos --}}
                                <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" viewBox="0 0 24 24" fill="none">
                                    <path d="M2 12s2-4 10-4 10 4 10 4-2 4-10 4-10-4-10-4Z" fill="#8B4513" stroke="#5D4037" stroke-width="2"></path>
                                    <path d="M12 2a4 4 0 0 0-4 4h8a4 4 0 0 0-4-4Z" fill="#A0522D" stroke="#5D4037" stroke-width="2"></path>
                                    <line x1="12" y1="1" x2="12" y2="23" stroke="#4CAF50" stroke-width="2.5" stroke-linecap="round"></line>
                                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" stroke="#4CAF50" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" fill="none"></path>
                                    <circle cx="12" cy="12" r="1.5" fill="#FFD700"></circle>
                                </svg>
                            </div>
                            <a href="#" class="small-box-footer">Ver reportes <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h3>18</h3>
                                <p>Pagos</p>
                            </div>
                            <div class="icon">
                                {{-- Icono de Tarjeta de Crédito con Colores Vivos --}}
                                <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" viewBox="0 0 24 24" fill="none">
                                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2" fill="#1E88E5" stroke="#0D47A1" stroke-width="2"></rect>
                                    <line x1="1" y1="8" x2="23" y2="8" stroke="#333" stroke-width="3"></line>
                                    <rect x="3" y="14" width="4" height="3" rx="1" fill="#FFD700" stroke="#B8860B" stroke-width="1"></rect>
                                    <line x1="9" y1="14.5" x2="15" y2="14.5" stroke="#fff" stroke-width="1.5" stroke-linecap="round"></line>
                                    <line x1="9" y1="17" x2="18" y2="17" stroke="#fff" stroke-width="1.5" stroke-linecap="round"></line>
                                </svg>
                            </div>
                            <a href="{{ route('metodopago.index') }}" class="small-box-footer">Ver pagos <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-secondary">
                            <div class="inner">
                                <h3>7</h3>
                                <p>Informes</p>
                            </div>
                            <div class="icon">
                                {{-- Icono de Gráfico de Barras con Colores Vivos --}}
                                <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" viewBox="0 0 24 24" fill="none">
                                    <rect x="16" y="10" width="4" height="10" fill="#4CAF50" stroke="#2D5016" stroke-width="2"></rect>
                                    <rect x="10" y="4" width="4" height="16" fill="#2196F3" stroke="#0D47A1" stroke-width="2"></rect>
                                    <rect x="4" y="14" width="4" height="6" fill="#FFC107" stroke="#F57C00" stroke-width="2"></rect>
                                    <line x1="2" y1="21" x2="22" y2="21" stroke="#333" stroke-width="2" stroke-linecap="round"></line>
                                </svg>
                            </div>
                            <a href="#" class="small-box-footer">Ver informes <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>35</h3>
                                <p>Proveedores</p>
                            </div>
                            <div class="icon">
                                {{-- Icono de Camión de Reparto con Colores Vivos --}}
                                <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" viewBox="0 0 24 24" fill="none">
                                    <rect x="1" y="3" width="15" height="13" fill="#66BB6A" stroke="#2D5016" stroke-width="2"></rect>
                                    <polygon points="16 8 20 8 23 11 23 16 16 16 16 8" fill="#A5D6A7" stroke="#2D5016" stroke-width="2"></polygon>
                                    <circle cx="5.5" cy="18.5" r="2.5" fill="#333" stroke="#000" stroke-width="1.5"></circle>
                                    <circle cx="18.5" cy="18.5" r="2.5" fill="#333" stroke="#000" stroke-width="1.5"></circle>
                                    <circle cx="5.5" cy="18.5" r="1" fill="#888"></circle>
                                    <circle cx="18.5" cy="18.5" r="1" fill="#888"></circle>
                                    <rect x="17" y="10" width="4" height="4" fill="#E3F2FD" opacity="0.8" stroke="#2D5016" stroke-width="1"></rect>
                                </svg>
                            </div>
                            <a href="{{ route('proveedores.index') }}" class="small-box-footer">Ver proveedores <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>
@stop

@section('css')
    @stack('styles')
    <style>
        /* ... (CSS anterior sin cambios) ... */
        .content-wrapper {
            background: url("{{ asset('vendor/adminlte/dist/img/fondo_blanco.png') }}") no-repeat center center fixed;
            background-size: 109%;
            background-repeat: no-repeat;
            background-position: center center;
        }

        /* 🎨 Colores personalizados */
        .small-box.bg-success { 
            background-color: #C3D55A !important; 
            color: #fff !important;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        
        .small-box.bg-primary { 
            background-color: #0033a0 !important; 
            color: #fff !important;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        
        .small-box.bg-secondary { 
            background-color: #808080 !important; 
            color: #fff !important;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .small-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 12px rgba(0,0,0,0.15);
        }

        .small-box .icon { 
            color: rgba(255, 255, 255, 0.6) !important;
            top: 14px;
            right: 10px;
        }
        
        .small-box .icon svg {
            opacity: 1 !important; 
        }

        .small-box-footer { 
            background: rgba(0,0,0,0.15) !important; 
            color: #fff !important;
            transition: background 0.2s ease;
        }

        .small-box-footer:hover {
            background: rgba(0,0,0,0.25) !important;
            color: #fff !important;
        }

        .small-box .inner h3 {
            font-weight: bold;
            font-size: 2.5rem;
        }

        .small-box .inner p {
            font-size: 1rem;
        }

        .content-header h1 {
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }
    </style>
@stop

@section('js')
    @stack('scripts')
@stop