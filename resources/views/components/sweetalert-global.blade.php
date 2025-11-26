{{-- Scripts SweetAlert2 Global para toda la aplicación --}}

{{-- CDN de SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- Script de confirmaciones SweetAlert2 --}}
<script src="{{ asset('js/sweetalert-confirmations.js') }}"></script>

{{-- Script que muestra alertas de sesión --}}
@if(session()->has('swal_type') && session()->has('swal_message'))
<script>
    console.log('SweetAlert detectado:', '{{ session("swal_type") }}', '{{ session("swal_message") }}');
    
    document.addEventListener('DOMContentLoaded', function() {
        const titleMap = {
            'success': '✅ ¡Éxito!',
            'error': '❌ ¡Error!',
            'warning': '⚠️ ¡Advertencia!',
            'info': 'ℹ️ Información'
        };
        
        const iconMap = {
            'success': 'success',
            'error': 'error',
            'warning': 'warning',
            'info': 'info'
        };
        
        const colorMap = {
            'success': '#28a745',
            'error': '#dc3545',
            'warning': '#ffc107',
            'info': '#17a2b8'
        };
        
        const alertType = '{{ session("swal_type") }}';
        const alertMessage = '{{ session("swal_message") }}';
        
        Swal.fire({
            icon: iconMap[alertType] || 'info',
            title: titleMap[alertType] || 'Información',
            text: alertMessage,
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false,
            confirmButtonColor: colorMap[alertType] || '#3085d6',
            background: '#fff',
            customClass: {
                popup: 'swal-alert-popup'
            },
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });
    });
</script>
@else
<script>
    console.log('SweetAlert NO DETECTADO. Session keys disponibles:', {!! json_encode(session()->all()) !!});
</script>
@endif

<style>
    .swal-alert-popup {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        border-radius: 8px;
    }
    
    .swal-alert-popup .swal2-title {
        font-weight: 600;
        margin-bottom: 10px;
    }
    
    .swal-alert-popup .swal2-html-container {
        font-size: 15px;
        color: #666;
    }
</style>

