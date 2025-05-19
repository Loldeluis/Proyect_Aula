<?php
session_start();
require_once __DIR__ . '/../../Model/utilidades/bd/ConexionBD.php';

// Crear conexión
$conexion = new ConexionBD();
$conn = $conexion->conectar();

// Verificar conexión
if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Consulta para obtener accesos
$query = "SELECT u.nombre_usuario, a.fecha_entrada, a.fecha_salida, a.estado_acceso
          FROM accesos_usuario a
          INNER JOIN usuarios u ON a.id_usuario = u.id_usuario
          ORDER BY a.fecha_entrada DESC";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Historial de Accesos</title>
    <link rel="stylesheet" href="../../CSS/css_admin/ver_accesos.css">
</head>
<body>
    <h2 style="text-align:center;">Historial de Accesos</h2>
    <table>
        <tr>
            <th>Usuario</th>
            <th>Fecha de Entrada</th>
            <th>Fecha de Salida</th>
            <th>Estado</th>
        </tr>
        <?php if ($result && mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= htmlspecialchars($row['nombre_usuario']) ?></td>
                    <td><?= htmlspecialchars($row['fecha_entrada']) ?></td>
                    <td><?= htmlspecialchars($row['fecha_salida'] ?? '---') ?></td>
                    <td><?= htmlspecialchars($row['estado_acceso']) ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="4" style="text-align:center;">No hay registros disponibles</td></tr>
        <?php endif; ?>
    </table>
    <a href="paneladmin.php">Volver</a>
</body>
</html>

<?php
// Cerrar conexión
mysqli_close($conn);
?>
