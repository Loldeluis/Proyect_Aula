<?php
session_start();

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
    <title>Panel del Docente</title>
    <link rel="stylesheet" href="../CSS/docente.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<header>
    <i class="fas fa-chalkboard-teacher"></i>
    <span>Bienvenido docente: <?php echo htmlspecialchars($nombre_docente); ?></span>
</header>

<div class="container">
    <h2>Panel de Control del Docente</h2>
    <p class="welcome-message">Gestiona tu labor educativa desde un solo lugar.</p>

    <div class="grid">
        <div class="language-box" style="border-left: 8px solid #28a745;">
            <h3><i class="fas fa-book"></i> Mis Cursos</h3>
            <p>Visualiza los cursos que tienes asignados.</p>
            <button class="btn" onclick="location.href='ver_cursos.php'">Ver Cursos</button>
        </div>

        <div class="language-box" style="border-left: 8px solid #007bff;">
            <h3><i class="fas fa-users"></i> Estudiantes</h3>
            <p>Consulta tus estudiantes inscritos.</p>
            <button class="btn" onclick="location.href='ver_estudiantes.php'">Ver Estudiantes</button>
        </div>

        <div class="language-box" style="border-left: 8px solid #ffc107;">
            <h3><i class="fas fa-edit"></i> Calificaciones</h3>
            <p>Registrar y modificar notas.</p>
            <button class="btn" onclick="location.href='calificaciones.php'">Gestionar Calificaciones</button>
        </div>

        <div class="language-box" style="border-left: 8px solid #17a2b8;">
            <h3><i class="fas fa-file-alt"></i> Reportes de Desempeño</h3>
            <p>Consulta y descarga el historial de desempeño.</p>
            <button class="btn" onclick="location.href='reporte_desempeno.php'">Ver Reportes</button>
        </div>

        <div class="language-box" style="border-left: 8px solid #dc3545;">
            <h3><i class="fas fa-tasks"></i> Asignar Desafíos</h3>
            <p>Envía nuevos desafíos a tus estudiantes.</p>
            <button class="btn" onclick="location.href='asignar_desafios.php'">Asignar Desafíos</button>
        </div>

       
    </div>

    <button class="btn-back" onclick="location.href='../../Controller/Peticiones/logout.php'">
        <i class="fas fa-sign-out-alt"></i> Cerrar sesión
    </button>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
