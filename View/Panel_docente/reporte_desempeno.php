<?php
require_once __DIR__ . '/../../Model/utilidades/bd/ConexionBD.php';
$conexion = new ConexionBD();
$conn = $conexion->conectar();

$tipo = $_GET['tipo'] ?? null;
$resultados = [];

if ($tipo === 'estudiante' && isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_estudiante = intval($_GET['id']);

$sql = "SELECT e.id_entrega, d.titulo, u.nombre_usuario AS estudiante, e.calificacion, e.retroalimentacion
        FROM entregas_desafios e
        JOIN desafios d ON e.id_desafio = d.id_desafio
        JOIN usuarios u ON e.id_estudiante = u.id_usuario
        WHERE e.id_estudiante = ?";


    $stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    die("Error en la preparación de la consulta estudiante: " . mysqli_error($conn));
}
mysqli_stmt_bind_param($stmt, "i", $id_estudiante);


} elseif ($tipo === 'curso' && isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_curso = intval($_GET['id']);
    $sql = "SELECT e.id_entrega, d.titulo, u.nombre_usuario AS estudiante, c.nombre AS curso, e.calificacion, e.retroalimentacion
            FROM entregas_desafios e
            JOIN desafios d ON e.id_desafio = d.id_desafio
            JOIN cursos c ON d.id_curso = c.id_curso
            JOIN usuarios u ON e.id_estudiante = u.id_usuario
            WHERE c.id_curso = ?";

    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        die("Error en la preparación de la consulta curso: " . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmt, "i", $id_curso);


} elseif ($tipo === 'general') {
$sql = "SELECT e.id_entrega, d.titulo, u.nombre_usuario AS estudiante, c.nombre AS curso, e.calificacion, e.retroalimentacion
        FROM entregas_desafios e
        JOIN desafios d ON e.id_desafio = d.id_desafio
        JOIN cursos c ON d.id_curso = c.id_curso
        JOIN usuarios u ON e.id_estudiante = u.id_usuario";

    $stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    die("Error en la preparación de la consulta general: " . mysqli_error($conn));
}

}

if (isset($stmt)) {
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
        $resultados[] = $row;
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
        <?php
        $sql_estudiantes = "SELECT id_usuario, nombre_usuario FROM usuarios WHERE rol = 'estudiante'";
        $res_estudiantes = mysqli_query($conn, $sql_estudiantes);
        while ($estudiante = mysqli_fetch_assoc($res_estudiantes)):
        ?>
            <option value="<?php echo $estudiante['id_usuario']; ?>" <?php if (isset($_GET['id']) && $_GET['id'] == $estudiante['id_usuario']) echo 'selected'; ?>>
                <?php echo htmlspecialchars($estudiante['nombre_usuario']); ?>
            </option>
        <?php endwhile; ?>
    </select>
    <button type="submit" class="btn">Ver por Estudiante</button>
</form>


       <form method="GET" style="display: inline;">
    <input type="hidden" name="tipo" value="curso">
    <select name="id" required>
        <option value="">Selecciona un curso</option>
        <?php
        $sql_cursos = "SELECT id_curso, nombre FROM cursos";
        $res_cursos = mysqli_query($conn, $sql_cursos);
        while ($curso = mysqli_fetch_assoc($res_cursos)):
        ?>
            <option value="<?php echo $curso['id_curso']; ?>" <?php if (isset($_GET['id']) && $_GET['id'] == $curso['id_curso']) echo 'selected'; ?>>
                <?php echo htmlspecialchars($curso['nombre']); ?>
            </option>
        <?php endwhile; ?>
    </select>
    <button type="submit" class="btn">Ver por Curso</button>
</form>


        <a href="?tipo=general" class="btn">Reporte General</a>
       
    </div>

    <?php if ($tipo && !empty($resultados)): ?>
        <table class="table-desafios" style="margin-top: 20px;">

            <thead>
                <tr>
                    <?php foreach (array_keys($resultados[0]) as $col): ?>
                        <th><?php echo ucfirst(str_replace("_", " ", $col)); ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resultados as $fila): ?>
                    <tr>
                        <?php foreach ($fila as $valor): ?>
                            <td><?php echo htmlspecialchars($valor); ?></td>
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
        <a href="../../Controller/Peticiones/descargar_reporte.php?tipo=<?php echo urlencode($tipo); ?>&id=<?php echo $_GET['id'] ?? ''; ?>" class="btn">Descargar</a>
    </div>
<?php endif; ?>
</div>


 <button class="btn-back" onclick="window.location.href='docente.php'">
            <i class="fas fa-arrow-left"></i> Volver
        </button>
</body>
</html>
