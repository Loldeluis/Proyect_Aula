<?php
session_start();
require_once __DIR__ . '/../../Model/utilidades/bd/ConexionBD.php';

require_once __DIR__ . '/../../Model/utilidades/bd/ConexionBD.php';
$conexionBD = new ConexionBD();
$connection_obj = $conexionBD->conectar(); // objeto mysqli


if (isset($_SESSION['id_acceso'])) {
    $id_acceso = $_SESSION['id_acceso'];

    // Actualiza la fecha de salida
    $update_query = "UPDATE accesos_usuario SET fecha_salida = NOW() WHERE id_acceso = ?";
    if ($stmt = mysqli_prepare($connection_obj, $update_query)) {
        mysqli_stmt_bind_param($stmt, "i", $id_acceso);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

// Destruir la sesión completamente
session_unset();
session_destroy();

// Redirigir al login
header("Location: ../../View/Principal.php");
exit();
?>