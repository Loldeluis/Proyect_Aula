function pedirContrasena() {
  Swal.fire({
    title: 'Confirma tu contraseña',
    input: 'password',
    inputLabel: 'Ingresa tu contraseña para continuar',
    inputPlaceholder: 'Contraseña',
    inputAttributes: {
      autocapitalize: 'off',
      autocorrect: 'off'
    },
    showCancelButton: true,
    confirmButtonText: 'Eliminar cuenta',
    confirmButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    preConfirm: (password) => {
      if (!password) {
        Swal.showValidationMessage('La contraseña es requerida');
      }
      return {password: password};
    }
  }).then((result) => {
    if (result.isConfirmed && result.value) {
      eliminarCuenta(result.value.password);
    }
  });
}

<<<<<<< HEAD:JS/confirmarEliminacion.js
function eliminarCuenta(password) {
  fetch('/Controller/usuarios/eliminar_usuario.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: `password=${encodeURIComponent(password)}`
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      Swal.fire({
        title: 'Cuenta eliminada',
        text: 'Tu cuenta ha sido eliminada exitosamente',
        icon: 'success'
      }).then(() => {
        window.location.href = '../View/principal.php';
      });
    } else {
      Swal.fire({
        title: 'Error',
        text: data.message || 'No se pudo eliminar la cuenta',
        icon: 'error'
      });
    }
  })
  .catch(error => {
    Swal.fire({
      title: 'Error',
      text: 'Ocurrió un error al comunicarse con el servidor',
      icon: 'error'
    });
  });
}
=======
function pedirContrasenaEliminar() {
  Swal.fire({
    title: 'Eliminar cuenta',
    input: 'password',
    inputLabel: 'Ingresa tu contraseña para confirmar',
    inputPlaceholder: 'Contraseña',
    inputAttributes: {
      autocapitalize: 'off',
      autocorrect: 'off'
    },
    showCancelButton: true,
    confirmButtonText: 'Eliminar',
    confirmButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    preConfirm: (password) => {
      if (!password) {
        Swal.showValidationMessage('La contraseña es obligatoria');
        return false;
      }
      // Crea y envía el formulario
      const form = document.createElement('form');
      form.method = 'POST';
      form.action = '../Controller/usuarios/eliminar_usuario.php';

      const input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'password';
      input.value = password;
      form.appendChild(input);

      document.body.appendChild(form);
      form.submit();
    }
  });
}


>>>>>>> b.Luis:View/JS/confirmarEliminacion.js
