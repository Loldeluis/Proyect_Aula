<?php
session_start();
if (!isset($_SESSION['nombre_usuario']) || $_SESSION['rol'] !== 'docente') {
    header('Location: login.html');
    exit();
}

$id_docente = $_SESSION['usuario_id'];

$conn = mysqli_connect("localhost", "root", "root", "bd_sistemaeducativo");
if (!$conn) {
    die("Error al conectar: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_curso = $_POST['id_curso'];
    $titulo = trim($_POST['titulo']);
    $descripcion = trim($_POST['descripcion']);
    $fecha_limite = $_POST['fecha_limite'];

    $sql = "INSERT INTO desafios (titulo, descripcion, fecha_limite, id_curso, id_docente)
            VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssii", $titulo, $descripcion, $fecha_limite, $id_curso, $id_docente);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Desafío asignado exitosamente'); window.location.href=' ../../View/Panel_docente/docente.php';</script>";
    } else {
        echo "Error al guardar: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}
mysqli_close($conn);
?>
