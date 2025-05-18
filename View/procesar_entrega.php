<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'estudiante') {
    header('Location: login.html');
    exit();
}

$id_estudiante = $_SESSION['usuario_id'];
$id_desafio = $_POST['id_desafio'];
$contenido = isset($_POST['contenido']) ? $_POST['contenido'] : '';
$archivoNombre = null;

if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
    $archivoTmp = $_FILES['archivo']['tmp_name'];
    $archivoNombre = basename($_FILES['archivo']['name']);
    move_uploaded_file($archivoTmp, "../archivos/" . $archivoNombre);
}

$conn = mysqli_connect("localhost", "root", "", "bd_sistemaeducativo");
if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

$sql = "INSERT INTO entregas_desafios (id_desafio, id_estudiante, contenido, archivo) VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "iiss", $id_desafio, $id_estudiante, $contenido, $archivoNombre);

if (mysqli_stmt_execute($stmt)) {
    echo "Entrega registrada correctamente.";
    echo "<br><a href='ver_desafios.php'>Volver a desafíos</a>";
} else {
    echo "Error al registrar la entrega: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
