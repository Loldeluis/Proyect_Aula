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
    <style>
        /* ===== ESTILOS INTEGRADOS ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
            display: flex;
            min-height: 100vh;
        }

        /* Barra lateral */
        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: white;
            padding: 20px 0;
            position: fixed;
            height: 100vh;
        }

        .sidebar h2 {
            text-align: center;
            padding: 0 20px 20px;
            margin-bottom: 20px;
            border-bottom: 1px solid #34495e;
            font-size: 1.5rem;
        }

        /* Menú */
        nav ul {
            list-style: none;
            padding: 0 20px;
        }

        nav li {
            margin: 8px 0;
        }

        nav a {
            color: #ecf0f1;
            text-decoration: none;
            display: block;
            padding: 10px;
            border-radius: 4px;
            transition: all 0.3s;
        }

        nav a:hover {
            background-color: #34495e;
            transform: translateX(5px);
        }

        /* Contenido principal */
        .main-content {
            margin-left: 250px;
            padding: 30px;
            flex: 1;
        }

        header {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        section {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        /* Efectos para emojis */
        nav a::before {
            margin-right: 10px;
            font-size: 1.1em;
        }
    </style>
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
                <li><a href="../../Controller/Peticiones/logout.php">🚪 Cerrar Sesión</a></li>


                
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