<?php
session_start();
date_default_timezone_set('America/Bogota'); // Establecer zona horaria

require_once __DIR__ . '../../../Model/utilidades/bd/ConexionBD.php';


// Crear conexión
$conexion = new ConexionBD();
$conn = $conexion->conectar();

$id_usuario = $_SESSION['usuario_id'] ?? null;

if ($id_usuario && $conn) {
    $fecha_salida = date('Y-m-d H:i:s');

    // Usar consulta segura con prepared statement
    $query = "UPDATE accesos_usuario 
              SET fecha_salida = ? 
              WHERE id_usuario = ? 
              ORDER BY id_acceso DESC 
              LIMIT 1";

    // Como ORDER BY + LIMIT no es permitido directamente en UPDATE en MySQL,
    // necesitas una subconsulta o hacerlo en dos pasos.
    // Aquí va una forma alternativa segura en dos pasos:

    $subquery = "SELECT id_acceso FROM accesos_usuario WHERE id_usuario = ? ORDER BY id_acceso DESC LIMIT 1";
    $stmt = $conn->prepare($subquery);
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $stmt->bind_result($id_acceso);
    $stmt->fetch();
    $stmt->close();

    if ($id_acceso) {
        $update = "UPDATE accesos_usuario SET fecha_salida = ? WHERE id_acceso = ?";
        $stmt2 = $conn->prepare($update);
        $stmt2->bind_param("si", $fecha_salida, $id_acceso);
        $stmt2->execute();
        $stmt2->close();
    }
}

session_destroy();
mysqli_close($conn);
header("Location: ../../View/Principal.php");
exit();
?>
