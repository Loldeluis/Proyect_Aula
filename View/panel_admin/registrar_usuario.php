<?php
session_start();
if ($_SESSION['rol'] != 'admin') {
    header("Location: ../login.html");
    exit();
}
?>

<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger">
        <?php echo htmlspecialchars($_GET['error']); ?>
    </div>
<?php endif; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Usuario</title>
    <link rel="stylesheet" href="../CSS/registrarAdmin.css">

</head>
<body>
    <div class="container">
        <h1>Registrar Nuevo Usuario</h1>
        <?php if (isset($_GET['error'])): ?>
            <div class="error"><?= htmlspecialchars($_GET['error']) ?></div>
        <?php endif; ?>
            <form action="../../Route/registrar_usuario.php" method="post">
            <input type="text" name="nombre" placeholder="Nombre" required>
            <input type="text" name="cedula" placeholder="Cédula" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <select name="rol" required>
                <!--<option value="admin">Administrador</option>-->
                <option value="docente">Docente</option>
                <option value="estudiante">Estudiante</option>
            </select>
            <button type="submit">Registrar</button>
        </form>
        <a href="usuarios.php">Volver a la lista</a>
        <a href="paneladmin.php">Volver</a>
    </div>
</body>
</html> 