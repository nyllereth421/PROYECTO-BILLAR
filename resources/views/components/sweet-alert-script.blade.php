{{-- Script SweetAlert2 que se incluye en el layout --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if($hasSweetAlert ?? false)
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const titleMap = {
            'success': '¡Éxito!',
            'error': '¡Error!',
            'warning': '¡Advertencia!',
            'info': 'Información'
        };
        
        Swal.fire({
            icon: '{{ $sweetAlertType ?? "info" }}',
            title: titleMap['{{ $sweetAlertType ?? "info" }}'] || 'Información',
            text: '{{ $sweetAlertMessage ?? "" }}',
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: true,
            confirmButtonColor: '#3085d6'
        });
    });
</script>
@endif
