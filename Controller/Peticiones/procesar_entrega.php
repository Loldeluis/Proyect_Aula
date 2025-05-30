<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'Estudiante') {
    header('Location: login.html');
    exit();
}
require_once __DIR__ . '/../../Model/utilidades/bd/ConexionBD.php';

$id_estudiante = $_SESSION['usuario_id'];
$id_desafio = $_POST['id_desafio'];
$contenido = isset($_POST['contenido']) ? $_POST['contenido'] : '';
$archivoNombre = null;

if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
    $nombre_original = $_FILES['archivo']['name'];
    $archivoTmp = $_FILES['archivo']['tmp_name'];

    // Crear nombre único para evitar sobrescrituras
    $archivoNombre = uniqid() . "_" . basename($nombre_original);

    // Asegurar que el directorio existe
    $directorio = "../../archivos_entregas/";
    if (!is_dir($directorio)) {
        mkdir($directorio, 0777, true);
    }

    $ruta_destino = $directorio . $archivoNombre;

    // Mover el archivo
    if (!move_uploaded_file($archivoTmp, $ruta_destino)) {
        echo "Error al subir el archivo.";
        exit();
    }
}

$conexion = new ConexionBD();
$conn = $conexion->conectar();


$sql = "INSERT INTO entregas_desafios (id_desafio, id_estudiante, contenido, archivo) VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "iiss", $id_desafio, $id_estudiante, $contenido, $archivoNombre);

if (mysqli_stmt_execute($stmt)) {
    echo "Entrega registrada correctamente.";
    echo "<br><a href='../Estudiante/DesafioController.php'>Volver a desafíos</a>";
} else {
    echo "Error al registrar la entrega: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
