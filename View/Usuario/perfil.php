
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Perfil</title>
  <link rel="stylesheet" href="../../View/CSS/principal.css">
</head>
<body>
  <div class="container" style="max-width: 400px; margin: 40px auto;">
    <h2 style="text-align:center;">Editar Perfil</h2>
    <form action="../../Controller/Usuario/PerfilController.php" method="post" class="card" style="padding: 2rem;">
      <input type="hidden" name="accion" value="actualizar">
      <input type="hidden" name="id_usuario" value="<?= $usuario['id_usuario'] ?>">

      <label for="nombre">Nombre:</label>
      <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($usuario['nombre_usuario']) ?>" required style="margin-bottom: 1rem;">

      <label for="correo">Correo:</label>
      <input type="email" id="correo" name="correo" value="<?= htmlspecialchars($usuario['correo']) ?>" required style="margin-bottom: 1rem;">

      <button type="submit" class="btn" style="width:100%;">Actualizar perfil</button>
    </form>

    <form action="../../View/Usuario/confirmar_eliminar.php" method="get" style="margin-top: 1rem;">
      
      <button type="submit" class="btn logout-btn" style="width:100%;">Eliminar cuenta</button>

    </form>
      <a href="../../View/principal.php" class="btn" style="width:100%; display:block; text-align:center; margin-top:1rem; background:#888; color:#fff;">
      Volver
    </a>
  </div>
</body>
</html>