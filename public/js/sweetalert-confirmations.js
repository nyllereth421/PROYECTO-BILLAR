/**
 * Confirmación SweetAlert2 para Formularios
 * Uso: Agregar data-confirm="Estás seguro?" a cualquier formulario
 */
document.addEventListener('DOMContentLoaded', function() {
    // Confirmación para formularios
    const formsWithConfirm = document.querySelectorAll('form[data-confirm]');
    
    formsWithConfirm.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const message = this.getAttribute('data-confirm') || '¿Estás seguro de esta acción?';
            const actionType = this.getAttribute('data-action-type') || 'default';
            
            // Determinar ícono y título según el tipo de acción
            const config = {
                create: {
                    icon: 'question',
                    title: '¿Crear Registro?',
                    text: message || 'Se creará un nuevo registro en el sistema.',
                    confirmButtonText: 'Sí, crear',
                    confirmButtonColor: '#28a745'
                },
                edit: {
                    icon: 'question',
                    title: '¿Actualizar Registro?',
                    text: message || 'Se actualizarán los datos del registro.',
                    confirmButtonText: 'Sí, actualizar',
                    confirmButtonColor: '#0056b3'
                },
                delete: {
                    icon: 'warning',
                    title: '¡Eliminar Registro!',
                    text: message || 'Esta acción no se puede deshacer.',
                    confirmButtonText: 'Sí, eliminar',
                    confirmButtonColor: '#dc3545'
                },
                default: {
                    icon: 'question',
                    title: '¿Continuar?',
                    text: message || '¿Deseas realizar esta acción?',
                    confirmButtonText: 'Sí, continuar',
                    confirmButtonColor: '#3085d6'
                }
            };
            
            const alertConfig = config[actionType] || config['default'];
            
            Swal.fire({
                icon: alertConfig.icon,
                title: alertConfig.title,
                text: alertConfig.text,
                showCancelButton: true,
                confirmButtonColor: alertConfig.confirmButtonColor,
                cancelButtonColor: '#6c757d',
                confirmButtonText: alertConfig.confirmButtonText,
                cancelButtonText: 'Cancelar',
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit(); // Enviar formulario
                }
            });
        });
    });
    
    // Confirmación para enlaces de eliminación
    const deleteLinks = document.querySelectorAll('a[data-delete-confirm]');
    
    deleteLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            const itemName = this.getAttribute('data-item-name') || 'este registro';
            const formId = this.getAttribute('data-form-id');
            
            Swal.fire({
                icon: 'warning',
                title: '¡Eliminar Registro!',
                text: `¿Estás seguro de que deseas eliminar ${itemName}? Esta acción no se puede deshacer.`,
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then((result) => {
                if (result.isConfirmed) {
                    // Enviar formulario si existe
                    if (formId) {
                        document.getElementById(formId).submit();
                    } else {
                        // O simplemente ir al href
                        window.location.href = this.href;
                    }
                }
            });
        });
    });
    
    // Confirmación para botones genéricos
    const confirmButtons = document.querySelectorAll('button[data-confirm-action]');
    
    confirmButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            const actionType = this.getAttribute('data-confirm-action');
            const message = this.getAttribute('data-confirm-message') || '¿Deseas realizar esta acción?';
            
            e.preventDefault();
            
            const config = {
                create: {
                    icon: 'question',
                    title: '¿Crear Registro?',
                    confirmButtonColor: '#28a745',
                    confirmButtonText: 'Sí, crear'
                },
                edit: {
                    icon: 'question',
                    title: '¿Actualizar Registro?',
                    confirmButtonColor: '#0056b3',
                    confirmButtonText: 'Sí, actualizar'
                },
                delete: {
                    icon: 'warning',
                    title: '¡Eliminar Registro!',
                    confirmButtonColor: '#dc3545',
                    confirmButtonText: 'Sí, eliminar'
                }
            };
            
            const alertConfig = config[actionType] || {
                icon: 'question',
                title: '¿Continuar?',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Sí, continuar'
            };
            
            Swal.fire({
                icon: alertConfig.icon,
                title: alertConfig.title,
                text: message,
                showCancelButton: true,
                confirmButtonColor: alertConfig.confirmButtonColor,
                cancelButtonColor: '#6c757d',
                confirmButtonText: alertConfig.confirmButtonText,
                cancelButtonText: 'Cancelar',
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then((result) => {
                if (result.isConfirmed) {
                    const formId = this.getAttribute('data-form-id');
                    if (formId) {
                        document.getElementById(formId).submit();
                    }
                }
            });
        });
    });
});
