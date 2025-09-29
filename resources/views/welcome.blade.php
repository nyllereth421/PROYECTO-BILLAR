@extends('adminlte::page')
@section('title', $title ?? 'Dashboard')



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
      <div class="row justify-content-center">

        <!-- Tarjeta: Mesas disponibles -->
        <div class="col-lg-3 col-6">
          <div class="small-box bg-success">
            <div class="inner">
              <h3>12</h3>
              <p>Mesas Disponibles</p>
            </div>
            <div class="icon">
              <i class="fas fa-table"></i>
            </div>
            <a href="#" class="small-box-footer">Ver más <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <!-- Tarjeta: Productos -->
        <div class="col-lg-3 col-6">
          <div class="small-box bg-info">
            <div class="inner">
              <h3>35</h3>
              <p>Productos</p>
            </div>
            <div class="icon">
              <i class="fas fa-cocktail"></i>
            </div>
            <a href="3" class="small-box-footer">Ver productos <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <!-- Tarjeta: Partidas activas -->
        <div class="col-lg-3 col-6">
          <div class="small-box bg-warning">
            <div class="inner">
              <h3>5</h3>
              <p>Partidas Activas</p>
            </div>
            <div class="icon">
              <i class="fas fa-play-circle"></i>
            </div>
            <a href="#" class="small-box-footer">Ver partidas <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <!-- Tarjeta: Ingresos de hoy -->
        <div class="col-lg-3 col-6">
          <div class="small-box bg-danger">
            <div class="inner">
              <h3>$450</h3>
              <p>Ingresos Hoy</p>
            </div>
            <div class="icon">
              <i class="fas fa-dollar-sign"></i>
            </div>
            <a href="#" class="small-box-footer">Ver reportes <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

      </div>

      <!-- Más contenido si deseas -->
      <!-- Por ejemplo: últimos movimientos, estadísticas, etc -->

    </div>
  </section>
</div>

@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin-custom.css') }}">
    @stack('styles')
@stop

@section('js')
    @stack('scripts')
@stop


