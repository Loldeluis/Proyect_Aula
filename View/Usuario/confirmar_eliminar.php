<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../View/login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Confirmar Eliminación</title>
  <link rel="stylesheet" href="../CSS/principal.css">
</head>
<body>
  <div class="form-container">
    <h2>Confirmar Eliminación de Cuenta</h2>
    <form action="../../Controller/Usuario/eliminar_usuario.php" method="post">
      <input type="hidden" name="accion" value="eliminar">
      <input type="hidden" name="id_usuario" value="<?= $_SESSION['usuario_id'] ?>">
      <label>Confirma tu contraseña:</label>
      <input type="password" name="password" required>
      <button type="submit">Eliminar definitivamente</button>
      <?php if (isset($_GET['error'])): ?>
        <div class="error-msg">Contraseña incorrecta.</div>
      <?php endif; ?>
    </form>
  </div>
</body>
</html>