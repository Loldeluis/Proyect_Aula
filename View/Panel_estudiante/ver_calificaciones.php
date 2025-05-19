<?php
session_start();

// Verificación de sesión y rol
if (!isset($_SESSION['nombre_usuario']) || $_SESSION['rol'] !== 'estudiante') {
    header('Location: login.html');
    exit();
}
require_once __DIR__ . '/../../Model/utilidades/bd/ConexionBD.php';

$nombre_estudiante = $_SESSION['nombre_usuario'];
$id_estudiante = $_SESSION['usuario_id']; // Este debe estar guardado en login

// Conexión
$conexion = new ConexionBD();
$conn = $conexion->conectar();


// Consulta de calificaciones para el estudiante
$sql = "SELECT d.titulo, e.calificacion, e.retroalimentacion
        FROM entregas_desafios e
        INNER JOIN desafios d ON e.id_desafio = d.id_desafio
        WHERE e.id_estudiante = ?";



$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    die("Error al preparar la consulta: " . mysqli_error($conn));
}
mysqli_stmt_bind_param($stmt, "i", $id_estudiante);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Calificaciones</title>
    <link rel="stylesheet" href="../CSS/aprendizaje.css">
    <link rel="stylesheet" href="../CSS/boton_flotante.css">

</head>
<body>
    <div class="container">
        <h2>Mis Calificaciones</h2>

        <?php if (mysqli_num_rows($result) > 0): ?>
            <table border="1" cellpadding="10" cellspacing="0">
                <tr>
                    <th>Desafío</th>
                    <th>Calificación</th>
                    <th>Comentario</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['titulo']); ?></td>
                        <td><?php echo $row['calificacion'] !== null ? htmlspecialchars($row['calificacion']) : 'Pendiente'; ?></td>
                        <td><?php echo $row['retroalimentacion'] !== null ? htmlspecialchars($row['retroalimentacion']) : 'Sin comentarios'; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No has recibido calificaciones aún.</p>
        <?php endif; ?>
      

    </div>

<a href="aprendizaje.php" class="btn-flotante">← Volver</a>


</body>

</html>
