function mostrarMensaje(mensaje, esExito, idContenedor = 'mensaje-registro') {
    const contenedor = document.getElementById(idContenedor);
    if (!contenedor) return;

    contenedor.textContent = mensaje;
    contenedor.style.display = 'block';
    contenedor.style.backgroundColor = esExito ? '#d4edda' : '#f8d7da';
    contenedor.style.color = esExito ? '#155724' : '#721c24';
    contenedor.style.border = esExito ? '1px solid #c3e6cb' : '1px solid #f5c6cb';

    // Redirigir solo si es mensaje de éxito general
    if (esExito && idContenedor === 'mensaje-registro') {
        setTimeout(() => {
            window.location.href = '../View/login.html';
        }, 2000);
    }
}

// Validación del formulario
document.addEventListener('DOMContentLoaded', () => {
    const formulario = document.querySelector('form');

    formulario.addEventListener('submit', function (e) {
        e.preventDefault();

        const cedula = document.getElementById('cedula').value.trim();
        const correo = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value;
        const confirm = document.getElementById('confirm_password').value;

        const mensajeCedula = document.getElementById('mensaje-cedula');
        const mensajeCorreo = document.getElementById('mensaje-correo');
        const mensajeRegistro = document.getElementById('mensaje-registro');

        if (mensajeCedula) mensajeCedula.style.display = 'none';
        if (mensajeCorreo) mensajeCorreo.style.display = 'none';
        if (mensajeRegistro) mensajeRegistro.style.display = 'none';

        let hayError = false;

        // Validar cédula
        if (!/^[0-9]{7,11}$/.test(cedula)) {
            mostrarMensaje('Cédula inválida, debe tener de 7 a 11 dígitos.', false, 'mensaje-cedula');
            hayError = true;
        }

        // Validar correo
        if (!/^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(correo)) {
            mostrarMensaje('Correo inválido.', false, 'mensaje-correo');
            hayError = true;
        }

        // Validar contraseñas
        if (password !== confirm) {
            mostrarMensaje('Las contraseñas no coinciden.', false, 'mensaje-registro');
            hayError = true;
        }

        if (!hayError) {
            this.submit(); // Enviar formulario si no hay errores
        }
    });
});
