<?php
session_start();

// Conectar a la base de datos
$connection_obj = mysqli_connect("localhost", "root", "", "bd_sistemaeducativo");
if (!$connection_obj) {
    die("Error de conexión: " . mysqli_connect_error());
}

$id_usuario = $_SESSION['usuario_id'] ?? null;

if ($id_usuario) {
    $fecha_salida = date('Y-m-d H:i:s');
    $query = "UPDATE accesos_usuario 
              SET fecha_salida = '$fecha_salida' 
              WHERE id_usuario = $id_usuario 
              ORDER BY id_acceso DESC LIMIT 1";
    mysqli_query($connection_obj, $query);
}

session_destroy();
mysqli_close($connection_obj);

header("Location: principal.php");
exit();
