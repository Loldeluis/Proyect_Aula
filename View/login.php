<?php
session_start();
require_once '../Model/entity/Conexion.php';
if (isset($_SESSION['usuario_id'])) {
    // Si ya está logueado, lo redirige a la página principal
    header('Location: ' . BASE_URL . '/View/aprendizaje.php');
    exit();
}
$mensajeExito = $_SESSION['mensaje_exito'] ?? '';
unset($_SESSION['mensaje_exito']);
?>
<?php if ($mensajeExito): ?>
<script>
    Swal.fire({
        icon: 'success',
        title: '¡Éxito!',
        text: <?= json_encode($mensajeExito) ?>,
        confirmButtonText: 'Aceptar'
    });
</script>
<?php endif; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="../CSS/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>
    <a href="principal.php" class="back-button">
  <i class="fas fa-arrow-left"></i>
  <span>Volver</span>
</a>
    <div id = "login"> 
    <form action = "../Controller/usuarios/iniciar_sesion.php" method="post">
    <h2>LOGIN</h2>
    <div class="input-group">
        <label for="email"><i class="fas fa-envelope"></i> Email</label>
        <input type="text" name="email" id="email" required />
        </div>

        <div class="input-group">
        <label for="password"><i class="fas fa-lock"></i> Contraseña</label>
        <input type="password" name="password" id="password" required />
        </div>

        <input type="submit" value="Ingresar">
    </form>

    <p class="small-text">¿No tienes cuenta?</p>
        <a href="../View/formulario_registro.php">Regístrate aquí</a></p>
    </div>
    <?php if (!empty($_SESSION['error_login'])): ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error al iniciar sesión',
            text: '<?= $_SESSION['error_login'] ?>'
        });
    </script>
    <?php unset($_SESSION['error_login']); ?>
<?php endif; ?>
<?php unset($_SESSION['form_login']); ?>
</body>
</html>