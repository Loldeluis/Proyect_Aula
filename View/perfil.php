<?php

define('BASE_DIR', dirname(__DIR__));
require_once(BASE_DIR . '/Model/entity/Conexion.php');
require_once(BASE_DIR . '/Model/crud/Usuario_crud.php');
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

$crud = new Usuario_crud();
$usuario = $crud->obtenerUsuarioPorId($_SESSION['usuario_id']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="../CSS/perfil.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <button class="back-button" onclick="window.history.back()">
        <i class="fas fa-arrow-left"></i>
        Volver
    </button>

    <div class="profile-container">
        <div class="profile-card">
            <h1>Perfil de Usuario</h1>
        

    <form action="actualizar_perfil.php" method="POST">
    <div class="form-group">
        <label for="cedula">Número de Documento:</label>
        <input type="text" id="cedula" name="cedula" disabled 
            value="<?= htmlspecialchars($usuario['cedula']) ?>">
    </div>

    <div class="form-group">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required 
            maxlength="100" value="<?= htmlspecialchars($usuario['nombre_usuario']) ?>">
    </div>

    <div class="form-group">
        <label for="rol">Rol:</label>
        <input type="text" id="rol" name="rol" disabled 
            value="<?= ucfirst(htmlspecialchars($usuario['rol'])) ?>">
    </div>

    <div class="form-group">
        <label for="institucion">Institución:</label>
        <input type="text" id="institucion" name="institucion" disabled 
            value="<?= htmlspecialchars($usuario['institucion']) ?>">
    </div>

    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required 
            value="<?= htmlspecialchars($usuario['correo']) ?>">
    </div>

    <button type="button" onclick="abrirModal()">Cambiar contraseña</button>

<div id="modalPassword" class="modal" style="display:none;">
  <div class="modal-contenido">
    <span onclick="cerrarModal()" style="float:right;cursor:pointer;">&times;</span>
    <h3>Cambiar Contraseña</h3>
    <form id="formPassword" method="POST">
      <label for="actual">Contraseña actual:</label><br>
      <input type="password" name="actual" required><br><br>

      <label for="nueva">Nueva contraseña:</label><br>
      <input type="password" name="nueva" required minlength="6"><br><br>

      <label for="confirmar">Confirmar nueva contraseña:</label><br>
      <input type="password" name="confirmar" required minlength="6"><br><br>

      <button type="submit">Actualizar contraseña</button>
    </form>
  </div>
</div>

    <button type="submit" class="btn-submit">
        <i class="fas fa-save"></i>
        Actualizar Perfil
    </button>
</form>
        </div>
    </div>
    <script src="../JS/abrirCerrarModal.js"></script>
</body>
</html>