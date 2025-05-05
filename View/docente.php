<?php
session_start();

// Verificación de rol
if (!isset($_SESSION['nombre_usuario']) || $_SESSION['rol'] !== 'docente') {
    header('Location: login.html');
    exit();
}

$nombre_docente = $_SESSION['nombre_usuario'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel del Docente</title>
    <link rel="stylesheet" href="../CSS/aprendizaje.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header>
        <i class="fas fa-chalkboard-teacher"></i>
        <span>Bienvenido docente: <?php echo htmlspecialchars($nombre_docente); ?></span>
    </header>

    <div class="container">
        <h2>Panel de Control del Docente</h2>
        <p class="welcome-message">Aquí puedes gestionar tus cursos, estudiantes y contenidos.</p>

        <div class="grid">
            <div class="language-box" style="border-left: 8px solid #28a745;">
                <h3>Mis Cursos</h3>
                <p>Visualiza los cursos que tienes asignados.</p>
                <button class="btn" onclick="location.href='ver_cursos.php'">Ver Cursos</button>
            </div>

            <div class="language-box" style="border-left: 8px solid #007bff;">
                <h3>Registrar Calificaciones</h3>
                <p>Accede al módulo de notas.</p>
                <button class="btn" onclick="location.href='calificaciones.php'">Ir a Calificaciones</button>
            </div>

            <div class="language-box" style="border-left: 8px solid #ffc107;">
                <h3>Estudiantes</h3>
                <p>Consulta la lista de tus estudiantes.</p>
                <button class="btn" onclick="location.href='ver_estudiantes.php'">Ver Estudiantes</button>
            </div>
        </div>

        <button class="btn-back" onclick="location.href='logout.php'">
            <i class="fas fa-sign-out-alt"></i> Cerrar sesión
        </button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
