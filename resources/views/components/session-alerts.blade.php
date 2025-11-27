{{-- Mostrar Alertas de Sesión Estandarizadas --}}

@if ($errors->any())
    <x-alert 
        type="error" 
        title="Errores de Validación"
        message="Por favor, revisa los siguientes errores:"
        dismissible="true"
    />
    <div class="alert alert-danger mb-4">
        <ul class="mb-0 pl-4">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <x-alert 
        type="success"
        title="¡Éxito!"
        message="{{ session('success') }}"
        dismissible="true"
    />
@endif

@if (session('error'))
    <x-alert 
        type="error"
        title="Error"
        message="{{ session('error') }}"
        dismissible="true"
    />
@endif

@if (session('warning'))
    <x-alert 
        type="warning"
        title="Advertencia"
        message="{{ session('warning') }}"
        dismissible="true"
    />
@endif

@if (session('info'))
    <x-alert 
        type="info"
        title="Información"
        message="{{ session('info') }}"
        dismissible="true"
    />
@endif

@if (session('status'))
    <x-alert 
        type="info"
        title="Estado"
        message="{{ session('status') }}"
        dismissible="true"
    />
@endif