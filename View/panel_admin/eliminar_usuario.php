<?php
session_start();
if ($_SESSION['rol'] != 'admin') {
    header("Location: ../../login.html");
    exit();
}
require_once __DIR__ . '/../../Model/utilidades/bd/ConexionBD.php';

$conexion = new ConexionBD();
$conn = $conexion->conectar();


$id = $_GET['id'];

$query = "UPDATE usuarios SET estado = 0 WHERE id_usuario = ?";
$stmt = mysqli_prepare($connection_obj, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

header("Location: ../usuarios.php?success=Usuario+inactivado");
exit();
?>