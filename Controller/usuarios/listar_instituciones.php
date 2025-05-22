<?php
$baseDir = dirname(dirname(__DIR__));
require_once($baseDir . '/Model/entity/Conexion.php'); 

try {
    $conexion = Conexion::obtenerConexion(); 

    $sql = "SELECT id_institucion, nombre FROM instituciones WHERE estado = 1";
    $result = $conexion->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . htmlspecialchars($row['id_institucion']) . "'>" . htmlspecialchars($row['nombre']) . "</option>";
        }
    } else {
        echo "<option value=''>No hay instituciones disponibles</option>";
    }
} catch (Exception $e) {
    echo "<option value=''>Error al cargar instituciones</option>";
}
?>