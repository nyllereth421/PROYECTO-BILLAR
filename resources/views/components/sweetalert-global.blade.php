{{-- Scripts SweetAlert2 Global para toda la aplicación --}}

{{-- CDN de SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- Script de confirmaciones SweetAlert2 --}}
<script src="{{ asset('js/sweetalert-confirmations.js') }}"></script>

{{-- Script que muestra alertas de sesión --}}
@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: '✅ ¡Éxito!',
            text: '{{ session("success") }}',
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false,
            confirmButtonColor: '#28a745',
            background: 'linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%)',
            iconColor: '#28a745',
            titleColor: '#155724',
            customClass: {
                popup: 'swal-alert-popup swal-success-popup'
            },
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });
    });
</script>
@elseif(session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'error',
            title: '❌ ¡Error!',
            text: '{{ session("error") }}',
            timer: 4000,
            timerProgressBar: true,
            showConfirmButton: false,
            confirmButtonColor: '#dc3545',
            background: 'linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%)',
            iconColor: '#dc3545',
            titleColor: '#721c24',
            customClass: {
                popup: 'swal-alert-popup swal-error-popup'
            },
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });
    });
</script>
@elseif(session('warning'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'warning',
            title: '⚠️ ¡Advertencia!',
            text: '{{ session("warning") }}',
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false,
            confirmButtonColor: '#ffc107',
            background: 'linear-gradient(135deg, #fff3cd 0%, #ffeeba 100%)',
            iconColor: '#ffc107',
            titleColor: '#856404',
            customClass: {
                popup: 'swal-alert-popup swal-warning-popup'
            },
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });
    });
</script>
@elseif(session('info'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'info',
            title: 'ℹ️ Información',
            text: '{{ session("info") }}',
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false,
            confirmButtonColor: '#17a2b8',
            background: 'linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%)',
            iconColor: '#17a2b8',
            titleColor: '#0c5460',
            customClass: {
                popup: 'swal-alert-popup swal-info-popup'
            },
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });
    });
</script>
@endif

<style>
    .swal-alert-popup {
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
        border-radius: 12px;
        border: 2px solid rgba(255, 255, 255, 0.3);
    }
    
    .swal-success-popup {
        border-left: 6px solid #28a745;
    }
    
    .swal-error-popup {
        border-left: 6px solid #dc3545;
    }
    
    .swal-warning-popup {
        border-left: 6px solid #ffc107;
    }
    
    .swal-info-popup {
        border-left: 6px solid #17a2b8;
    }
    
    .swal-alert-popup .swal2-title {
        font-weight: 700;
        margin-bottom: 10px;
        font-size: 1.5rem;
    }
    
    .swal-alert-popup .swal2-html-container {
        font-size: 1rem;
        color: #333;
        font-weight: 500;
    }
    
    .swal-alert-popup .swal2-timer-progress-bar {
        background: linear-gradient(to right, #28a745, #20c997);
    }
    
    .swal-error-popup .swal2-timer-progress-bar {
        background: linear-gradient(to right, #dc3545, #e74c3c);
    }
    
    .swal-warning-popup .swal2-timer-progress-bar {
        background: linear-gradient(to right, #ffc107, #ff9800);
    }
    
    .swal-info-popup .swal2-timer-progress-bar {
        background: linear-gradient(to right, #17a2b8, #3498db);
    }
</style>

