<?php
session_start();

// Conexión a la base de datos
$connection_obj = mysqli_connect("localhost", "root", "root", "bd_sistemaeducativo");
if (!$connection_obj) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Consulta para obtener accesos
$query = "SELECT u.nombre_usuario, a.fecha_entrada, a.fecha_salida, a.estado_acceso 
          FROM accesos_usuario a 
          INNER JOIN usuarios u ON a.id_usuario = u.id_usuario 
          ORDER BY a.fecha_entrada DESC";

$result = mysqli_query($connection_obj, $query);
if (!$result) {
    die("Error en la consulta: " . mysqli_error($connection_obj)); // ✅ Esto te dirá qué está mal
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Historial de Accesos</title>
    <style>
        table { border-collapse: collapse; width: 80%; margin: 20px auto; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: center; }
        th { background-color: #f2f2f2; }
    </style>
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
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= htmlspecialchars($row['nombre_usuario']) ?></td>
                <td><?= htmlspecialchars($row['fecha_entrada']) ?></td>
                <td><?= htmlspecialchars($row['fecha_salida'] ?? '---') ?></td>
                <td><?= htmlspecialchars($row['estado_acceso']) ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
    <a href="paneladmin.php">Volver</a>
    
</body>
</html>

<?php mysqli_close($connection_obj); ?>

