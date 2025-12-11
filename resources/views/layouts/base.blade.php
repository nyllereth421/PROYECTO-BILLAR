{{-- Layout base que incluye SweetAlert2 --}}
@extends('adminlte::page')

@section('content_header')
    {{-- Override en vistas hijo --}}
@endsection

@section('content')
    {{-- Override en vistas hijo --}}
@endsection

@section('css')
    {{-- Override en vistas hijo --}}
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    @if(session('swal_type') && session('swal_message'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: '{{ session("swal_type") }}',
                title: {
                    'success': '¡Éxito!',
                    'error': '¡Error!',
                    'warning': '¡Advertencia!',
                    'info': 'Información'
                }['{{ session("swal_type") }}'] || 'Información',
                text: '{{ session("swal_message") }}',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: true,
                confirmButtonColor: '#3085d6'
            });
        });
    </script>
    @endif
@endsection
