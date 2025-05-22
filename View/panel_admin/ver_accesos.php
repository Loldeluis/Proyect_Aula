<!DOCTYPE html>
<html>
<head>
    <title>Historial de Accesos</title>
<link rel="stylesheet" href="/Proyecto_aula/View/CSS/desafios_crud.css">
</head>
<body>
    <h2 style="text-align:center;">Historial de Accesos</h2>

    <!-- Aquí NO hay print_r ni var_dump -->

    <table>
        <tr>
            <th>Usuario</th>
            <th>Fecha de Entrada</th>
            <th>Fecha de Salida</th>
            <th>Estado</th>
        </tr>

        <?php if (!empty($accesos)): ?>
            <?php foreach ($accesos as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['nombre_usuario']) ?></td>
                    <td><?= htmlspecialchars($row['fecha_entrada']) ?></td>
                    <td><?= htmlspecialchars($row['fecha_salida'] ?? '---') ?></td>
                    <td><?= htmlspecialchars($row['estado_acceso']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="4" style="text-align:center;">No hay registros disponibles</td></tr>
        <?php endif; ?>
    </table>

      <button class="btn-back" onclick="location.href='View/panel_admin/paneladmin.php'">
        <i class="fas fa-arrow-left"></i> Volver
    </button>
</body>
</html>
