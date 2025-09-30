@extends('adminlte::page')

@section('title', $title ?? 'Dashboard')

@section('content')
<div class="d-flex align-items-center" 
     style="margin: -1.5rem; min-height: calc(100vh - 3.5rem - 1px); background: url({{ asset('vendor/adminlte/dist/img/fondo.png') }}) no-repeat center center fixed; background-size cover;">
    <section class="content mx-auto" style="max-width: 1140px; width: 100%; background-color: rgba(0,0,0,0.6); border-radius: 10px; padding: 20px;">
        <div class="container text-center text-white">
            <!-- Encabezado -->
            <div class="mb-4">
                <h1>Bienvenido a Billar Nexus</h1>
                <p>Panel de gestión del sistema</p>
            </div>

            <!-- Contenedor con sistema de columnas -->
            <div class="row justify-content-center">

                <!-- Tarjeta: Mesas disponibles -->
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>12</h3>
                            <p>Mesas</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-table"></i>
                        </div>
                        <a href="#" class="small-box-footer">Ver más <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <!-- Tarjeta: Productos -->
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>35</h3>
                            <p>Productos</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-cocktail"></i>
                        </div>
                        <a href="#" class="small-box-footer">Ver productos <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <!-- Tarjeta: Torneos -->
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>5</h3>
                            <p>Torneos</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-play-circle"></i>
                        </div>
                        <a href="#" class="small-box-footer">Ver torneos <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <!-- Tarjeta: Ingresos -->
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
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
@stop

@section('js')
    @stack('scripts')
@stop
