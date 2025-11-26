# Guía de Estandarización de Alertas

## Descripción General

Este documento describe cómo usar las alertas estandarizadas en todo el proyecto PROYECTO-BILLAR.

## Componentes Disponibles

### 1. Componente `<x-alert>`

Componente Blade reutilizable para mostrar alertas individuales.

**Ubicación:** `resources/views/components/alert.blade.php`

**Uso en Vistas:**

```blade
<x-alert 
    type="success"
    title="¡Éxito!"
    message="El registro fue creado correctamente."
    dismissible="true"
/>
```

**Parámetros:**

- `type` (requerido): `success`, `error`, `warning`, `info`
- `title` (opcional): Título de la alerta. Si no se proporciona, usa el predeterminado
- `message` (requerido): Mensaje a mostrar
- `dismissible` (opcional): `true/false` - permite cerrar la alerta
- `icon` (opcional): Clase de icono personalizado (ej: `fas fa-custom`)

**Ejemplos:**

```blade
<!-- Alerta de Éxito -->
<x-alert 
    type="success"
    message="Usuario creado exitosamente."
/>

<!-- Alerta de Error con icono personalizado -->
<x-alert 
    type="error"
    title="Operación Fallida"
    message="No se pudo guardar el registro."
    icon="fas fa-exclamation"
/>

<!-- Alerta de Advertencia -->
<x-alert 
    type="warning"
    message="Por favor revisa los datos antes de continuar."
    dismissible="false"
/>
```

---

### 2. Componente `<x-session-alerts>`

Componente que automáticamente muestra todas las alertas de sesión (flash messages).

**Ubicación:** `resources/views/components/session-alerts.blade.php`

**Uso en Vistas:**

```blade
@extends('adminlte::page')

@section('content')
    <!-- Muestra todas las alertas de sesión -->
    <x-session-alerts />
    
    <!-- Tu contenido aquí -->
@endsection
```

**Mensajes de Sesión Soportados:**

- `session('success')` - Alerta verde de éxito
- `session('error')` - Alerta roja de error
- `session('warning')` - Alerta amarilla de advertencia
- `session('info')` - Alerta azul informativa
- `session('status')` - Alerta informativa
- Errores de validación - Muestra todos los errores en rojo

---

### 3. AlertHelper - Helper en Controladores

Helper PHP para estandarizar respuestas en todos los controladores.

**Ubicación:** `app/Helpers/AlertHelper.php`

**Métodos Disponibles:**

#### `AlertHelper::success($route, $message)`
Redirecciona a una ruta con mensaje de éxito.

```php
return AlertHelper::success('users.index', 'Usuario creado correctamente.');
```

#### `AlertHelper::error($route, $message)`
Redirecciona con mensaje de error. Si `$route` es `null`, usa `back()`.

```php
return AlertHelper::error('users.index', 'Error al crear el usuario.');
// O
return AlertHelper::error(null, 'Error: Stock insuficiente');
```

#### `AlertHelper::warning($route, $message)`
Redirecciona con mensaje de advertencia.

```php
return AlertHelper::warning(null, 'Cantidad mínima no alcanzada.');
```

#### `AlertHelper::info($route, $message)`
Redirecciona con mensaje informativo.

```php
return AlertHelper::info('users.index', 'Información actualizada.');
```

#### `AlertHelper::getMessage($key)`
Obtiene un mensaje estandarizado predefinido.

```php
return AlertHelper::success('users.index', AlertHelper::getMessage('create_success'));
```

**Mensajes Predefinidos Disponibles:**

- `create_success` - Registro creado exitosamente.
- `update_success` - Registro actualizado exitosamente.
- `delete_success` - Registro eliminado exitosamente.
- `create_error` - Error al crear el registro.
- `update_error` - Error al actualizar el registro.
- `delete_error` - Error al eliminar el registro.
- `not_found` - El registro no fue encontrado.
- `unauthorized` - No tienes permiso para realizar esta acción.
- `invalid_data` - Los datos proporcionados son inválidos.
- `operation_success` - Operación completada exitosamente.
- `operation_error` - Ha ocurrido un error en la operación.

---

## Ejemplos Prácticos

### Ejemplo 1: Controlador Actualizado

**Antes:**
```php
public function store(Request $request)
{
    $request->validate([...]);
    User::create($request->all());
    return redirect()->route('users.index')->with('success', 'Usuario creado correctamente.');
}
```

**Después:**
```php
use App\Helpers\AlertHelper;

public function store(Request $request)
{
    $request->validate([...]);
    User::create($request->all());
    return AlertHelper::success('users.index', AlertHelper::getMessage('create_success'));
}
```

### Ejemplo 2: Vista con Alertas

**Antes:**
```blade
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <h4 class="alert-heading">¡Éxito!</h4>
        <p>{{ session('success') }}</p>
        <button type="button" class="close" data-dismiss="alert">×</button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <!-- Mostrar errores -->
    </div>
@endif
```

**Después:**
```blade
<x-session-alerts />
```

### Ejemplo 3: Controlador con Manejo de Errores

```php
use App\Helpers\AlertHelper;

public function delete(User $user)
{
    try {
        $user->delete();
        return AlertHelper::success('users.index', AlertHelper::getMessage('delete_success'));
    } catch (\Exception $e) {
        return AlertHelper::error('users.index', 'Error al eliminar: ' . $e->getMessage());
    }
}
```

---

## Estilos de Alertas

Cada tipo de alerta tiene su propio diseño estandarizado:

### Éxito (Verde)
- Icono: ✓
- Fondo: Verde claro
- Borde: Verde oscuro
- Cierre automático: Sí (5 segundos)

### Error (Rojo)
- Icono: ⚠
- Fondo: Rojo claro
- Borde: Rojo oscuro
- Cierre automático: No

### Advertencia (Amarillo)
- Icono: △
- Fondo: Amarillo claro
- Borde: Amarillo oscuro
- Cierre automático: No

### Información (Azul)
- Icono: ⓘ
- Fondo: Azul claro
- Borde: Azul oscuro
- Cierre automático: Sí (5 segundos)

---

## Guía de Migración

Para actualizar un controlador existente a usar AlertHelper:

1. **Agregar import:**
   ```php
   use App\Helpers\AlertHelper;
   ```

2. **Reemplazar redirecciones:**
   ```php
   // Antes
   return redirect()->route('users.index')->with('success', 'Operación exitosa.');
   
   // Después
   return AlertHelper::success('users.index', 'Operación exitosa.');
   ```

3. **Usar en vistas:**
   ```blade
   <!-- Reemplazar todas las alertas individuales con: -->
   <x-session-alerts />
   ```

---

## Notas Importantes

1. **Automatización:** Las alertas de éxito e información se cierran automáticamente después de 5 segundos
2. **Validación:** Los errores de validación se muestran automáticamente con `<x-session-alerts />`
3. **Consistencia:** Siempre usa AlertHelper en controladores para consistencia
4. **Mensajes:** Usa `AlertHelper::getMessage()` para reutilizar mensajes estandarizados
5. **Personalización:** Puedes personalizar los estilos editando `resources/views/components/alert.blade.php`

---

## Checklist para Implementación Completa

- [ ] Actualizar todos los controladores para usar `AlertHelper`
- [ ] Reemplazar todas las alertas en vistas con `<x-session-alerts />`
- [ ] Probar los diferentes tipos de alertas
- [ ] Verificar que el cierre automático funciona
- [ ] Revisar estilos en diferentes navegadores
- [ ] Documentar cualquier alerta personalizada

---

**Última actualización:** Noviembre 25, 2025
