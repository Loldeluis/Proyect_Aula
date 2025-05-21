<?php
require_once __DIR__ . '/../../Controller/Docente/ReporteController.php';

$controller = new ReporteController();
$tipo = $_GET['tipo'] ?? null;
$id = $_GET['id'] ?? null;
$resultado = [];

if ($tipo) {
    $res = $controller->manejarReporte($tipo, $id);
    while ($row = mysqli_fetch_assoc($res)) {
        $resultado[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Desempeño</title>
    <link rel="stylesheet" href="../CSS/aprendizaje.css">
</head>
<body>
<div class="container">
    <h2>Reportes de Desempeño</h2>

    <div class="btn-group">
        <form method="GET" style="display: inline;">
            <input type="hidden" name="tipo" value="estudiante">
            <select name="id" required>
                <option value="">Selecciona un estudiante</option>
                <?php foreach (mysqli_fetch_all($controller->obtenerEstudiantes(), MYSQLI_ASSOC) as $est): ?>
                    <option value="<?= $est['id_usuario'] ?>" <?= isset($_GET['id']) && $_GET['id'] == $est['id_usuario'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($est['nombre_usuario']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn">Ver por Estudiante</button>
        </form>

        <form method="GET" style="display: inline;">
            <input type="hidden" name="tipo" value="curso">
            <select name="id" required>
                <option value="">Selecciona un curso</option>
                <?php foreach (mysqli_fetch_all($controller->obtenerCursos(), MYSQLI_ASSOC) as $curso): ?>
                    <option value="<?= $curso['id_curso'] ?>" <?= isset($_GET['id']) && $_GET['id'] == $curso['id_curso'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($curso['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn">Ver por Curso</button>
        </form>

        <a href="?tipo=general" class="btn">Reporte General</a>
    </div>

    <?php if ($tipo && !empty($resultado)): ?>
        <table class="table-desafios" style="margin-top: 20px;">
            <thead>
                <tr>
                    <?php foreach (array_keys($resultado[0]) as $col): ?>
                        <th><?= ucfirst(str_replace('_', ' ', $col)) ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resultado as $fila): ?>
                    <tr>
                        <?php foreach ($fila as $valor): ?>
                            <td><?= htmlspecialchars($valor) ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php elseif ($tipo): ?>
        <p>No hay resultados disponibles para este criterio.</p>
    <?php endif; ?>

    <?php if ($tipo): ?>
        <div style="margin-top: 30px;">
            <a href="../../Controller/Peticiones/descargar_reporte.php?tipo=<?= urlencode($tipo) ?>&id=<?= $id ?>" class="btn">Descargar</a>
        </div>
    <?php endif; ?>
</div>

<button class="btn-back" onclick="window.location.href='docente.php'">
    <i class="fas fa-arrow-left"></i> Volver
</button>
</body>
</html>
