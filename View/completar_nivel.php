<?php
session_start();
include 'informacion.php';

// Verifica que el usuario esté logueado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Recoge datos del formulario
$usuario_id = $_SESSION['usuario_id'];
$lenguaje = $_POST['lenguaje'] ?? '';
$nivel = (int) ($_POST['nivel'] ?? 0);

// Validar los datos
if (empty($lenguaje) || $nivel < 1 || $nivel > 3) {
    echo "<script>alert('Datos inválidos'); window.location.href='aprendizaje.php';</script>";
    exit();
}

try {
    // Verifica si ya existe el registro
    $stmt = $conn->prepare("SELECT * FROM progreso WHERE usuario_id = ? AND lenguaje = ? AND nivel = ?");
    $stmt->execute([$usuario_id, $lenguaje, $nivel]);

    if ($stmt->rowCount() > 0) {
        // Si ya existe, actualiza
        $update = $conn->prepare("UPDATE progreso SET completado = 1 WHERE usuario_id = ? AND lenguaje = ? AND nivel = ?");
        $update->execute([$usuario_id, $lenguaje, $nivel]);
    } else {
        // Si no existe, inserta
        $insert = $conn->prepare("INSERT INTO progreso (usuario_id, lenguaje, nivel, completado) VALUES (?, ?, ?, 1)");
        $insert->execute([$usuario_id, $lenguaje, $nivel]);
    }

    // Redirige al panel
    header("Location: aprendizaje.php");

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
