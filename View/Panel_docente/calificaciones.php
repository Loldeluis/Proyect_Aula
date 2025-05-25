<?php
session_start();
if (!isset($_SESSION['nombre_usuario']) || $_SESSION['rol'] !== 'docente') {
    header('Location: ../../login.php');
    exit();
}
require_once __DIR__ . '/../../Model/utilidades/bd/ConexionBD.php';

$id_docente = $_SESSION['usuario_id'];
$conexion = new ConexionBD();
$conn = $conexion->conectar(); // Aquí tienes el objeto mysqli listo para usar

// Obtener entregas de desafíos asignados por este docente
$sql = "
SELECT ed.id_entrega, u.nombre_usuario AS nombre_estudiante, d.titulo AS titulo_desafio, 
ed.contenido, ed.fecha_entrega, ed.calificacion, ed.retroalimentacion, ed.archivo
FROM entregas_desafios ed
JOIN desafios d ON ed.id_desafio = d.id_desafio
JOIN usuarios u ON ed.id_estudiante = u.id_usuario
WHERE d.id_docente = ?
ORDER BY ed.fecha_entrega DESC
";



$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    die("Error en la preparación de la consulta: " . $conn->error);
}
mysqli_stmt_bind_param($stmt, "i", $id_docente);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$entregas = [];
while ($row = mysqli_fetch_assoc($result)) {
    $entregas[] = $row;
}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Calificaciones</title>
    <link rel="stylesheet" href="../CSS/aprendizaje.css">
</head>
<body>
<header>
    <h2>Calificaciones y Retroalimentación</h2>
</header>

<div class="container">
    <?php if (empty($entregas)): ?>
        <p>No hay entregas disponibles para calificar.</p>
    <?php else: ?>
        <?php foreach ($entregas as $entrega): ?>
            <form method="post" action="../../Controller/Docente/GuardarCalificacionController.php" class="language-box" style="border-left: 8px solid #ffc107;">
                <h3><?php echo htmlspecialchars($entrega['titulo_desafio']); ?></h3>
                <p><strong>Estudiante:</strong> <?php echo htmlspecialchars($entrega['nombre_estudiante']); ?></p>
                <p><strong>Entrega:</strong><br><?php echo nl2br(htmlspecialchars($entrega['contenido'])); ?></p>
                <p><strong>Fecha de Entrega:</strong> <?php echo $entrega['fecha_entrega']; ?></p>

                <input type="hidden" name="id_entrega" value="<?php echo $entrega['id_entrega']; ?>">

                <label>Calificación:</label>
                <input type="number" name="calificacion" step="0.1" min="0" max="100" 
                       value="<?php echo htmlspecialchars($entrega['calificacion'] ?? ''); ?>" required>

                <label>Retroalimentación:</label>
                <textarea name="retroalimentacion" rows="3" required><?php echo htmlspecialchars($entrega['retroalimentacion'] ?? ''); ?></textarea>

                <button type="submit" class="btn">Guardar Calificación</button>
                 <?php if (!empty($entrega['archivo'])): ?>
    <p><strong>Archivo adjunto:</strong>
        <a href="../../Controller/Peticiones/descargar_archivo.php?nombre=<?php echo urlencode($entrega['archivo']); ?>" class="btn" target="_blank">Descargar</a>
    </p>
<?php endif; ?>

            </form>
           

        <?php endforeach; ?>
    <?php endif; ?>
    <button class="btn-back" onclick="location.href='../../View/Panel_docente/docente.php'">
        <i class="fas fa-arrow-left"></i> Volver
    </button>
</div>
<?php if (isset($_GET['ok']) && $_GET['ok'] == 1): ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
        title: '¡Calificación guardada!',
        icon: 'success',
        confirmButtonText: 'OK',
        timer: 2000,
        timerProgressBar: true
    });
</script>
<?php endif; ?>

</body>
</html>
