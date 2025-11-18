@extends('adminlte::page')

@section('title', 'Acceso Denegado')

@section('content_header')
    <h1 class="text-danger">
        <i class="fas fa-lock mr-2"></i> Acceso Denegado
    </h1>
@stop

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card card-danger card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-exclamation-triangle mr-2"></i> Error 403 - Permiso Denegado
                    </h3>
                </div>
                <div class="card-body text-center">
                    <p class="lead mb-3">Lo sentimos, no tienes permiso para acceder a esta sección.</p>
                    <p class="text-muted">Tu rol de usuario (<strong>{{ auth()->user()->tipo }}</strong>) no tiene acceso a esta funcionalidad.</p>
                    
                    <div class="mt-4">
                        <p class="text-info">
                            <i class="fas fa-info-circle mr-2"></i>
                            Si crees que esto es un error, contacta al administrador.
                        </p>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('welcome') }}" class="btn btn-primary btn-block">
                        <i class="fas fa-arrow-left mr-2"></i> Volver al Inicio
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
