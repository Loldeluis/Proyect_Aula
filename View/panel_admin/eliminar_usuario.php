<?php
session_start();
if ($_SESSION['rol'] != 'admin') {
    header("Location: ../../login.html");
    exit();
}

$connection_obj = mysqli_connect("localhost", "root", "root", "bd_sistemaeducativo");
$id = $_GET['id'];

$query = "UPDATE usuarios SET estado = 0 WHERE id_usuario = ?";
$stmt = mysqli_prepare($connection_obj, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

header("Location: ../usuarios.php?success=Usuario+inactivado");
exit();
?>