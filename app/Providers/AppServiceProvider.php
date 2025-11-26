<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Evitar conflicto con vistas compiladas que no importan clases
        if (!class_exists('Auth')) {
            class_alias('Illuminate\Support\Facades\Auth', 'Auth');
        }
        if (!class_exists('View')) {
            class_alias('Illuminate\Support\Facades\View', 'View');
        }
        if (!class_exists('Str')) {
            class_alias('Illuminate\Support\Str', 'Str');
        }
        if (!class_exists('Route')) {
            class_alias('Illuminate\Support\Facades\Route', 'Route');
        }
        if (!class_exists('Gate')) {
            class_alias('Illuminate\Support\Facades\Gate', 'Gate');
        }
        if (!class_exists('DB')) {
            class_alias('Illuminate\Support\Facades\DB', 'DB');
        }
        
        // Gates para controlar acceso basado en roles
        Gate::define('view-dashboard', function ($user) {
            return $user->tipo === 'admin';
        });

        Gate::define('view-mesas-ventas', function ($user) {
            return in_array($user->tipo, ['admin', 'empleado']);
        });

        Gate::define('is-admin', function ($user) {
            return $user->tipo === 'admin';
        });
        Paginator::useBootstrap();

    }
}
