@php
    $type = session('swal_type');
    $message = session('swal_message');
    
    if (!$type || !$message) {
        return;
    }

    $icon = [
        'success' => 'success',
        'error' => 'error',
        'warning' => 'warning',
        'info' => 'info',
    ][$type] ?? 'info';

    $title = [
        'success' => '¡Éxito!',
        'error' => '¡Error!',
        'warning' => '¡Advertencia!',
        'info' => 'Información',
    ][$type] ?? 'Información';
@endphp

@if($type && $message)
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: '{{ $icon }}',
            title: '{{ $title }}',
            text: '{{ $message }}',
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: true,
            confirmButtonColor: '#3085d6'
        });
    });
</script>
@endif
