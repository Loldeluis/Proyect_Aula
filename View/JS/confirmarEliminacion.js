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


