{{-- Plantilla Base con Alertas Estandarizadas --}}
@extends('adminlte::page')

@section('content')
    <!-- Contenedor de Alertas Estandarizadas -->
    <div class="container-fluid mt-4">
        <x-session-alerts />
        
        {{-- El contenido específico va aquí --}}
        @yield('page-content')
    </div>
@endsection

@section('css')
    {{-- Estilos personalizados para alertas --}}
    <style>
        /* Estilos para las alertas estandarizadas */
        .alert {
            animation: slideIn 0.3s ease-in-out;
        }

        @keyframes slideIn {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes slideOut {
            from {
                transform: translateY(0);
                opacity: 1;
            }
            to {
                transform: translateY(-20px);
                opacity: 0;
            }
        }

        .alert.fade.out {
            animation: slideOut 0.3s ease-in-out;
        }

        /* Colores específicos para cada tipo */
        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }

        .alert-error {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }

        .alert-warning {
            background-color: #fff3cd;
            border-color: #ffeaa7;
            color: #856404;
        }

        .alert-info {
            background-color: #d1ecf1;
            border-color: #bee5eb;
            color: #0c5460;
        }
    </style>
@endsection

@section('js')
    {{-- Scripts para manejo de alertas --}}
    <script>
        // Cerrar alertas automáticamente después de 5 segundos
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                // Si es success o info, se cierra automáticamente
                if (alert.classList.contains('alert-success') || alert.classList.contains('alert-info')) {
                    setTimeout(() => {
                        alert.classList.add('fade', 'out');
                        setTimeout(() => alert.remove(), 300);
                    }, 5000);
                }
            });
        });
    </script>
@endsection
