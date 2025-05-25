<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Adiós...</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
  <script>
    Swal.fire({
      title: 'Cuenta eliminada',
      text: 'Lamentamos verte partir. ¡Esperamos verte de nuevo pronto!',
      icon: 'success',
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true
    });

    setTimeout(() => {
      window.location.href = 'Principal.php';
    }, 3200);
  </script>
</body>
</html>