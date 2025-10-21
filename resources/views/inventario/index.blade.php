@extends('adminlte::page')

@section('title', $title ?? 'Dashboard Ejecutivo')

{{-- Usamos content_header para un título más limpio en AdminLTE --}}
@section('content_header')
    <div class="container-fluid text-center">
        <h1 class="text-dark"><i class="fas fa-chart-line mr-2"></i> inventario Billar Nexus</h1>
        <p class="text-muted">Vista genral del inventario</p>
    </div>
@stop

@section('content')

<div class="container-fluid">
    {{-- 1. Fila de Indicadores Clave (Small Boxes) --}}
    <div class="row">
        
        {{-- productos--}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info"> {{-- Cambiamos a 'info' para un azul profesional --}}
                <div class="inner">
                    <h3>$450<sup style="font-size: 20px">/Hoy</sup></h3>
                    <p>productos disponibles</p>
                </div>
                <div class="icon">
                    {{-- Icono nativo de Font Awesome para dinero --}}
                    <i class="fas fa-dollar-sign"></i> 
                </div>
                <a href="{{ route('productos.index') }}" class="small-box-footer">
                    Ver listado de productos <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        {{-- MESAS ACTIVAS/TOTAL --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    {{-- Suponemos 4 activas de 12 total --}}
                    <h3>4<sup style="font-size: 20px">/12</sup></h3> 
                    <p>mesas registradas</p>
                </div>
                <div class="icon">
                    {{-- ¡CAMBIO AQUÍ! Usamos 'fa-hockey-puck' (que se parece a una bola de billar) o 'fa-circle' --}}
                    <i class="fas fa-hockey-puck billar-icon"></i> 
                </div>
                <a href="{{ route('mesas.index') }}" class="small-box-footer">Ver estado de mesas <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        </div>

        {{-- proveedores --}}
        <div class="col-md-6">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>$20<sup style="font-size: 20px">/proveedores</sup></h3>
                    <p>activos</p>
                </div>
                <div class="icon">
                    <i class="fas fa-bus"></i>
                </div>
                <a href="{{ route('proveedores.index') }}" class="small-box-footer">
                    ver proveedores <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
<div>

     <a href="{{ route('welcome') }}" class="btn btn-secondary float-end">Volver al Inicio</a>
 </div>     
 @stop       