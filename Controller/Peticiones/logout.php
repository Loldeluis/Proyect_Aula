<?php
session_start();
$connection_obj = mysqli_connect("localhost", "root", "root", "bd_sistemaeducativo");

if (!$connection_obj) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

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
