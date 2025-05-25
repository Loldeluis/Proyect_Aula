<?php
session_start();

if (!isset($_SESSION['nombre_usuario']) || $_SESSION['rol'] !== 'Estudiante') {
    header('Location: ../login.php');
    exit();
}

$nombre_estudiante = $_SESSION['nombre_usuario'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Aprende Programación</title>
    <link rel="stylesheet" href="../CSS/aprendizaje.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
</head>
<body>
    <header>
        <div class="logo">
        <i class="fas fa-code"></i>
        <span>Aprende Programación</span>
    </div>
    <div class="auth-buttons">
    <?php if (isset($usuario) && !empty($usuario)): ?>  
            <a href="perfil.php" class="auth-btn login-btn">
                <i class="fas fa-user"></i>
                <span>Hola, <?php echo htmlspecialchars($usuario); ?></span>
            </a>
            <a href="../Controller/usuarios/cerrar_sesion.php" class="auth-btn register-btn">
                <i class="fas fa-sign-out-alt"></i>
                <span>Cerrar sesión</span>
            </a>
    <?php endif; ?>
    </div>
</header>
    
    <div class="container">
        <h2>Selecciona un lenguaje de programación</h2>
        <p class="welcome-message">Elige un lenguaje y nivel para comenzar tu aprendizaje</p>
        <div class="grid" id="languages-container"></div>

        <button class="btn-back" onclick="window.location.href='../Principal.php'">
            <i class="fas fa-arrow-left"></i> Volver al inicio
        </button>

        <button class="btn" onclick="window.location.href='../../Controller/Estudiante/DesafioController.php'">
            <i class="fas fa-tasks"></i> Ver Desafíos Completados
        
        </button>

    </div>
    <div class="language-box" style="border-left: 8px solid #20c997;">
        <h3>Inscribirse a Curso</h3>
        <p>Explora cursos disponibles y únete para comenzar a aprender.</p>
        <button class="btn" onclick="location.href='inscribirse_curso.php'">Ver Cursos</button>
        <button class="btn" onclick="location.href='ver_calificaciones.php'">Ver Calificaciones</button>
    </div>
    <script src ="../JS/aprendizaje.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
