<?php
require_once 'conexion.php';

if (!$connection_obj) {
    echo "Error No: " . mysqli_connect_errno();
    echo "Error Description: " . mysqli_connect_error();
    exit;
}
$sql = "SELECT id_institucion, nombre FROM instituciones WHERE estado = 1";
$result = $connection_obj->query($sql); 

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<option value='" . $row['id_institucion'] . "'>" . $row['nombre'] . "</option>";
    }
} else {
    echo "<option value=''>No hay instituciones disponibles</option>"; // Mensaje si no hay registros
}

mysqli_close($connection_obj); 