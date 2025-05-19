<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'docente') {
    header('Location: login.html');
    exit();
}
require_once __DIR__ . '/../../Model/utilidades/bd/ConexionBD.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_entrega = $_POST['id_entrega'];
    $calificacion = $_POST['calificacion'];
    $retroalimentacion = $_POST['retroalimentacion'];

$conexion = new ConexionBD();
$conn = $conexion->conectar();


    // Actualizamos la consulta para que los tipos de los parámetros sean correctos
    $sql = "UPDATE entregas_desafios SET calificacion = ?, retroalimentacion = ? WHERE id_entrega = ?";
    $stmt = mysqli_prepare($conn, $sql);
    
    // Vinculamos los parámetros con el tipo adecuado
    mysqli_stmt_bind_param($stmt, "dss", $calificacion, $retroalimentacion, $id_entrega);

    // Ejecutamos la consulta
    if (mysqli_stmt_execute($stmt)) {
        header("Location: ../../View/Panel_docente/calificaciones.php?ok=1");
        exit(); // Aseguramos que no siga ejecutándose el script
    } else {
        echo "Error al guardar la calificación.";
    }

    // Cerramos la conexión
    mysqli_close($conn);
}
?>
