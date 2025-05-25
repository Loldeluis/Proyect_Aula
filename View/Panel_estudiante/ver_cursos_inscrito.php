<?php
session_start();
require_once '../../Model/Estudiante/InscripcionModel.php';

$idEstudiante = $_SESSION['usuario_id']; // o el nombre correcto de tu variable de sesión
$model = new InscripcionModel();
$cursos = $model->obtenerCursosPorEstudiante($idEstudiante);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Cursos Inscritos</title>
    <link rel="stylesheet" href="../../View/CSS/asignarDesafio.css">
</head>
<body>
    <div class="container">
        <h2>Cursos a los que estoy inscrito</h2>
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Nivel</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($cursos)) : ?>
                    <?php foreach ($cursos as $curso) : ?>
                        <tr>
                            <td><?= htmlspecialchars($curso['codigo']) ?></td>
                            <td><?= htmlspecialchars($curso['nombre']) ?></td>
                            <td><?= htmlspecialchars($curso['nivel']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="3">No estás inscrito en ningún curso.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        <button onclick="window.location.href='aprendizaje.php'">Volver</button>
    </div>
</body>
</html>