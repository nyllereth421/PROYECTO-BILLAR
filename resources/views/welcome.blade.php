@extends('adminlte::page')
@section('title', $title ?? '  Pagina principal')

@section('content')

    <div class="content-wrapper">
        <!-- Encabezado -->
        <section class="content-header">
            <div class="container-fluid">
                <h1 class="text-center">Bienvenido a Billar Nexus</h1>
                <p class="text-center">Panel de gestión del sistema</p>
            </div>
        </section>

        <!-- Contenido principal -->
        <section class="content-">
            <div class="container-fluid">
                <div class="row ">

                    <!-- Tarjeta: Mesas disponibles -->
                    <div class="col-lg-3 col-4">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>12</h3>
                                <p>Mesas </p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-table"></i>
                            </div>
                            <a href="#" class="small-box-footer">Ver más <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <!-- Tarjeta: Productos -->
                    <div class="col-lg-3 col-4">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>35</h3>
                                <p>Productos</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-cocktail"></i>
                            </div>
                            <a href="{{ route('productos.index') }}" class="small-box-footer">Ver productos <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <!-- Tarjeta: Partidas activas -->
                    <div class="col-lg-3 col-4">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>5</h3>
                                <p>Torneos</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-play-circle"></i>
                            </div>
                            <a href="#" class="small-box-footer">Ver partidas <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <!-- Tarjeta: Ingresos de hoy -->
                    <div class="col-lg-3 col-4">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>$450</h3>
                                <p>Ingresos</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                            <a href="#" class="small-box-footer">Ver reportes <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <!--TARJETA: Pagos -->
                    <div class="col-lg-3 col-4">
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h3>18</h3>
                                <p>Pagos</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-credit-card"></i>
                            </div>
                            <a href="#" class="small-box-footer">Ver pagos <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <!-- Tarjeta: informes -->
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-secondary">
                            <div class="inner">
                                <h3>7</h3>
                                <p>Informes</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <a href="#" class="small-box-footer">Ver informes <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <!-- Tarjeta: Pago -->
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h3>Pagos</h3>
                                <p>pagos</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-credit-card"></i>
                            </div>
                            <a href="#" class="small-box-footer">Ver pagos <i class="fas fa-arrow-circle-right"></i></a>
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
        .content-wrapper {
            background: url("{{ asset('vendor/adminlte/dist/img/fondo.png') }}") no-repeat center center fixed;
            background-size: cover;
        }
    </style>
@stop

@section('js')
    @stack('scripts')
@stop
