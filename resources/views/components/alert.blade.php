@props([
    'type' => 'info',
    'title' => '',
    'message' => '',
    'dismissible' => true,
    'icon' => null,
])

@php
    $typeConfig = [
        'success' => [
            'bg' => 'alert alert-success',
            'icon' => 'fas fa-check-circle',
            'defaultTitle' => '¡Operación Exitosa!',
        ],
        'error' => [
            'bg' => 'alert alert-danger',
            'icon' => 'fas fa-exclamation-circle',
            'defaultTitle' => '¡Error!',
        ],
        'warning' => [
            'bg' => 'alert alert-warning',
            'icon' => 'fas fa-exclamation-triangle',
            'defaultTitle' => '¡Advertencia!',
        ],
        'info' => [
            'bg' => 'alert alert-info',
            'icon' => 'fas fa-info-circle',
            'defaultTitle' => 'Información',
        ],
    ];

    $config = $typeConfig[$type] ?? $typeConfig['info'];
    $displayTitle = $title ?: $config['defaultTitle'];
    $displayIcon = $icon ?: $config['icon'];
@endphp

<div class="{{ $config['bg'] }} alert-dismissible fade show" role="alert" data-alert-type="{{ $type }}">
    <div class="d-flex align-items-start">
        <div class="flex-shrink-0 mr-3">
            <i class="{{ $displayIcon }} fa-lg"></i>
        </div>
        
        <div class="flex-grow-1">
            @if($title)
                <h5 class="alert-heading">{{ $title }}</h5>
            @endif
            <p class="mb-0">{{ $message }}</p>
        </div>
        
        @if($dismissible)
            <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                <span aria-hidden="true">&times;</span>
            </button>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('[data-alert-type]');
        alerts.forEach(alert => {
            const type = alert.getAttribute('data-alert-type');
            if (['success', 'info'].includes(type)) {
                setTimeout(() => {
                    alert.classList.remove('show');
                    setTimeout(() => alert.remove(), 300);
                }, 5000);
            }
        });
    });
</script>
