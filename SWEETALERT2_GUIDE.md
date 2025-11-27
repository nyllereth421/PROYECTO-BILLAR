# 🎉 Guía SweetAlert2 - Sistema Billar Nexus

## 📋 Resumen

SweetAlert2 está configurado globalmente en el proyecto. Ahora todas las alertas son estandarizadas y hermosas.

---

## 🚀 ¿Cómo Funciona?

### 1. **Middleware de Conversión Automática**

El middleware `ConvertToSweetAlert` intercepta automáticamente todos los `redirect()->with()` y los convierte a SweetAlert2:

```php
// ANTES (Alerta tradicional)
return redirect()->route('proveedores.index')->with('success', 'Proveedor creado correctamente.');

// DESPUÉS (Automáticamente convertido a SweetAlert2)
// El middleware convierte 'success' en 'swal_type' y el mensaje en 'swal_message'
```

### 2. **View Composer Compartido**

El `SweetAlertComposer` comparte automáticamente los datos de SweetAlert con todas las vistas:

- `$hasSweetAlert` - Boolean para verificar si hay alerta
- `$sweetAlertType` - Tipo de alerta (success, error, warning, info)
- `$sweetAlertMessage` - Mensaje a mostrar

### 3. **Script Global en Vistas**

Agregar a cualquier vista (generalmente en `@section('js')`):

```blade
{{-- SweetAlert2 --}}
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
```

---

## 💡 Uso en Controladores

### Opción 1: Usando `redirect()->with()` (Recomendado)

```php
// En cualquier controlador
public function store(Request $request)
{
    // Tu lógica aquí
    Model::create($data);
    
    // El middleware automáticamente convertirá esto a SweetAlert
    return redirect()->route('model.index')
        ->with('success', 'Registro creado exitosamente!');
}
```

### Opción 2: Usando `SweetAlertHelper` (Alternativa)

```php
use App\Helpers\SweetAlertHelper;

public function store(Request $request)
{
    Model::create($data);
    
    return SweetAlertHelper::success('model.index', 'Registro creado exitosamente!');
}
```

---

## 🎯 Tipos de Alertas

| Tipo | Icono | Color | Uso |
|------|-------|-------|-----|
| `success` | ✓ | Verde | Operación exitosa |
| `error` | ✗ | Rojo | Error o fallo |
| `warning` | ⚠ | Amarillo | Advertencia |
| `info` | ℹ | Azul | Información |

---

## 📝 Ejemplos Prácticos

### Ejemplo 1: Crear Registro

```php
public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
    ]);
    
    Model::create($validated);
    
    return redirect()->route('model.index')
        ->with('success', '¡Registro creado exitosamente!');
}
```

**Resultado:** Alerta verde con título "¡Éxito!" que desaparece en 3 segundos.

---

### Ejemplo 2: Error de Validación

```php
public function store(Request $request)
{
    $validated = $request->validate([
        'email' => 'required|email|unique:users',
    ]);
    
    // Si hay error de validación, automáticamente se muestra...
}
```

**Resultado:** Los errores de validación se muestran automáticamente en una alerta de error.

---

### Ejemplo 3: Operación con Múltiples Estados

```php
public function update(Request $request, $id)
{
    try {
        $model = Model::findOrFail($id);
        $model->update($request->all());
        
        return redirect()->route('model.index')
            ->with('success', 'Registro actualizado correctamente.');
            
    } catch (Exception $e) {
        return redirect()->back()
            ->with('error', 'Error al actualizar: ' . $e->getMessage());
    }
}
```

---

## 🛠️ Agregar a Nueva Vista

Para agregar SweetAlert2 a una nueva vista:

1. **Agregar el script al final de `@section('js')`:**

```blade
@section('js')
    {{-- Tu código JavaScript existente --}}
    
    {{-- SweetAlert2 --}}
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
@endsection
```

2. **Ya está configurado automáticamente** gracias al middleware `ConvertToSweetAlert`.

---

## 🔗 Flujo Completo

```
1. Controlador ejecuta: redirect()->with('success', 'Mensaje')
   ↓
2. Middleware ConvertToSweetAlert intercepta
   ↓
3. Convierte a: session('swal_type', 'success') + session('swal_message', 'Mensaje')
   ↓
4. SweetAlertComposer comparte datos con vista
   ↓
5. Vista renderiza: $hasSweetAlert = true, $sweetAlertType = 'success', $sweetAlertMessage = 'Mensaje'
   ↓
6. JavaScript ejecuta: Swal.fire({...})
   ↓
7. Se muestra alerta hermosa en pantalla ✨
```

---

## 📦 Archivos Involucrados

- `app/Http/Middleware/ConvertToSweetAlert.php` - Convierte alertas automáticamente
- `app/Http/Composers/SweetAlertComposer.php` - Comparte datos con vistas
- `app/Helpers/SweetAlertHelper.php` - Helper para uso manual
- `app/Providers/AppServiceProvider.php` - Registra todo
- `bootstrap/app.php` - Registra el middleware
- Vistas individuales - Incluyen el script de SweetAlert2

---

## ✅ Vistas Actualizadas

Las siguientes vistas ya incluyen SweetAlert2:

- ✅ `resources/views/welcome.blade.php`
- ✅ `resources/views/proveedores/index.blade.php`
- ⏳ `resources/views/productos/index.blade.php` (pendiente)
- ⏳ `resources/views/mesas/index.blade.php` (pendiente)
- ⏳ `resources/views/mesasventas/index.blade.php` (pendiente)
- ⏳ `resources/views/compras/index.blade.php` (pendiente)

> Para agregar a más vistas, seguir las instrucciones de la sección "Agregar a Nueva Vista"

---

## 🎨 Personalización

### Cambiar Colores de Botones

```blade
<script>
    Swal.fire({
        confirmButtonColor: '#28a745',    // Verde
        cancelButtonColor: '#dc3545',     // Rojo
        // ... resto de opciones
    });
</script>
```

### Cambiar Tiempo de Auto-cierre

```blade
<script>
    Swal.fire({
        timer: 5000,  // 5 segundos en lugar de 3
        // ... resto de opciones
    });
</script>
```

---

## 🐛 Troubleshooting

### "SweetAlert2 no se muestra"

1. Verifica que en el controlador haya `redirect()->with('success', ...)`
2. Verifica que la vista tenga el script de SweetAlert2
3. Abre DevTools (F12) y busca errores de JavaScript
4. Asegúrate de que `{{ $hasSweetAlert ?? false }}` sea `true`

### "El mensaje no aparece"

- Revisa que `session('swal_message')` tenga el contenido correcto
- Verifica que no hay caracteres especiales que causen problema en el JavaScript

---

## 📞 Soporte

Para agregar SweetAlert2 a más vistas o personalizar, contacta al equipo de desarrollo.

**Estado:** ✅ LISTO PARA PRODUCCIÓN

