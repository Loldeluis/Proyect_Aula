<?php
// Evitar acceso directo a la vista
if (!isset($nombre_docente) || !isset($estudiantes)) {
    header('Location: ../../Controller/Docente/Ver_estudiantesController.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Estudiantes</title>
    <link rel="stylesheet" href="../../View/CSS/aprendizaje.css">

</head>
<body>
    <header>
        <h2>Estudiantes Registrados</h2>
        <p>Docente: <?= htmlspecialchars($nombre_docente) ?></p>
    </header>

    <div class="container">
        <table border="1" cellpadding="10" cellspacing="0">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Cédula</th>
                <th>Correo</th>
                <th>Estado</th>
            </tr>
            <?php foreach ($estudiantes as $row) : ?>
                <tr>
                    <td><?= $row['id_usuario'] ?></td>
                    <td><?= htmlspecialchars($row['nombre_usuario']) ?></td>
                    <td><?= $row['cedula'] ?></td>
                    <td><?= $row['correo'] ?></td>
                    <td><?= $row['estado'] ? 'Activo' : 'Inactivo' ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <button class="btn-back" onclick="window.location.href='../../View/Panel_docente/docente.php'">Volver</button>
    </div>
</body>
</html>
