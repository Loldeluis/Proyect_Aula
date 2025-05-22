<?php
session_start();

if (!isset($_SESSION['nombre_usuario']) || $_SESSION['rol'] !== 'estudiante') {
    header('Location: ../../login.html');
    exit();
}

require_once __DIR__ . '/../../Controller/Estudiante/CalificacionController.php';

$controller = new CalificacionController();
$calificaciones = $controller->verCalificaciones($_SESSION['usuario_id']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Calificaciones</title>
    <link rel="stylesheet" href="../CSS/calificaciones.css">
    <link rel="stylesheet" href="../CSS/boton_flotante.css">
</head>
<body>
    <div class="container">
        <h2>Mis Calificaciones</h2>

        <?php if (!empty($calificaciones)): ?>
            <table border="1" cellpadding="10" cellspacing="0">
                <tr>
                    <th>Desafío</th>
                    <th>Calificación</th>
                    <th>Comentario</th>
                </tr>
                <?php foreach ($calificaciones as $fila): ?>
                    <tr>
                        <td><?= htmlspecialchars($fila['titulo']) ?></td>
                        <td><?= $fila['calificacion'] !== null ? htmlspecialchars($fila['calificacion']) : 'Pendiente' ?></td>
                        <td><?= $fila['retroalimentacion'] !== null ? htmlspecialchars($fila['retroalimentacion']) : 'Sin comentarios' ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No has recibido calificaciones aún.</p>
        <?php endif; ?>
    </div>

    <a href="aprendizaje.php" class="btn-flotante">← Volver</a>
</body>
</html>
