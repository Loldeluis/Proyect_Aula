<?php
// Evitar acceso directo a la vista
if (!isset($nombre_docente) || !isset($cursos)) {
    header('Location: ../../Controller/Docente/Ver_cursosController.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Cursos</title>
    <link rel="stylesheet" href="../../View/CSS/ver_cursos.css">
</head>
<body>
    <header>
        <h2>Mis Cursos - Docente: <?= htmlspecialchars($nombre_docente) ?></h2>
    </header>

    <div class="container">
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre del Curso</th>
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
                    <tr><td colspan="3">No hay cursos asignados.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <button class="btn-back" onclick="window.location.href='../../View/Panel_docente/docente.php'">Volver</button>
    </div>
</body>
</html>
