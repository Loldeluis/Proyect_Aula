<?php
session_start();
if ($_SESSION['rol'] != 'admin') {
    header("Location: ../login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Admin</title>
    <link rel="stylesheet" href="../../CSS/css_admin/panelAdmin.css">
</head>
<body>
    <!-- Barra lateral -->
    <div class="sidebar">
        <h2>Admin</h2>
        <nav>
            <ul>
                <li><a href="registrar_usuario.php">➕ Registrar Usuario</a></li>
                <li><a href="usuarios.php">👥 Ver Usuarios</a></li>
                 <li><a href="ver_accesos.php">📊 Ver Accesos</a></li>
                <li><a href="../logout.php">🚪 Cerrar Sesión</a></li>


                
            </ul>
        </nav>
    </div>

    <!-- Contenido principal -->
    <div class="main-content">
        <header>
            <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre_usuario']); ?></h1>
        </header>
        
        <section>
            <?php if (isset($_GET['action'])): ?>
                <?php include("acciones/" . $_GET['action'] . ".php"); ?>
            <?php else: ?>
                <p>Seleccione una opción del menú lateral.</p>
            <?php endif; ?>
        </section>
    </div>
</body>
</html>