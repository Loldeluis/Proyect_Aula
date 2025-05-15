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

$conn = mysqli_connect("localhost", "root", "root", "bd_sistemaeducativo");
if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

$sql = "INSERT INTO entregas_desafios (id_desafio, id_estudiante, contenido, archivo) VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "iiss", $id_desafio, $id_estudiante, $contenido, $archivoNombre);

if (mysqli_stmt_execute($stmt)) {
    echo "Entrega registrada correctamente.";
    echo "<br><a href='../../View/Panel_estudiante/ver_desafios.php'>Volver a desafíos</a>";
} else {
    echo "Error al registrar la entrega: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
