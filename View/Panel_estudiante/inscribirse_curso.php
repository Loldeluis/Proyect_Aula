<?php
if (!isset($nombreEstudiante) || !isset($cursos)) {
    header('Location: ../../Controller/Estudiante/InscripcionController.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inscribirse a un curso</title>
    <link rel="stylesheet" href="../../View/CSS/aprendizaje.css">
</head>
<body>
    <header>
        <h2>Inscribirse a un Curso</h2>
        <p>Estudiante: <?= htmlspecialchars($nombreEstudiante) ?></p>
    </header>

    <div class="container">
        <?php if ($mensaje): ?>
            <p><?= htmlspecialchars($mensaje) ?></p>
        <?php endif; ?>

        <form method="POST">
            <label for="id_curso">Selecciona un curso:</label>
            <select name="id_curso" required>
                <?php while ($curso = mysqli_fetch_assoc($cursos)): ?>
                    <option value="<?= $curso['id_curso'] ?>">
                        <?= htmlspecialchars($curso['nombre']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <button class="btn" type="submit">Inscribirse</button>
        </form>

        <button class="btn-back" onclick="window.location.href='../../View/Panel_estudiante/aprendizaje.php'">Volver</button>
    </div>
</body>
</html>
