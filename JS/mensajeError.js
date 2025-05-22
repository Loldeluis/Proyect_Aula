document.addEventListener('DOMContentLoaded', function() {
    // Mostrar mensaje de éxito si existe
    if (window.mensajeExito) {
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: window.mensajeExito,
            confirmButtonText: 'Entendido'
        }).then(() => {
            // Redirigir al login después de mostrar el mensaje
            if (window.redirectUrl) {
                window.location.href = window.redirectUrl;
            }
        });
    }

    // Mostrar error de registro si existe
    if (window.errorData && window.errorData.error) {
        Swal.fire({
            icon: 'error',
            title: 'Error en el registro',
            text: window.errorData.error,
            confirmButtonText: 'Entendido'
        }).then(() => {
            // Resaltar el campo con error si está especificado
            if (window.errorData.campo_error) {
                const campo = document.querySelector(`[name="${window.errorData.campo_error}"]`);
                if (campo) {
                    campo.classList.add('campo-error');
                    campo.focus();
                }
            }
        });
    }

    // Rellenar datos del formulario si existen
    if (window.formData) {
        // Campos normales
        ['nombre', 'cedula', 'email', 'password'].forEach(field => {
            const elemento = document.querySelector(`[name="${field}"]`);
            if (elemento && window.formData[field]) {
                elemento.value = window.formData[field];
            }
        });

        // Selects especiales
        if (window.formData.rol) {
            const selectRol = document.getElementById('rol');
            if (selectRol) selectRol.value = window.formData.rol;
        }

        if (window.formData.institucion) {
            const selectInstitucion = document.getElementById('institucion');
            if (selectInstitucion) selectInstitucion.value = window.formData.institucion;
        }
    }
});