<?php
session_start();

// Verificación de rol
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'docente') {
    header("Location: ../login.html");
    exit();
}

require_once __DIR__ . '/../../Controller/DesafioController.php';

// Inicializar controlador
$controller = new DesafioController();
$mensaje = "";

// Procesar envío del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $fecha_limite = $_POST['fecha_limite'] ?? '';
    $id_docente = $_SESSION['id_usuario']; // O la variable que uses

    if ($controller->crearDesafio($titulo, $descripcion, $fecha_limite, $id_docente)) {
        $mensaje = "✅ Desafío asignado correctamente.";
    } else {
        $mensaje = "❌ Error al asignar el desafío.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asignar Desafío</title>
    <link rel="stylesheet" href="../../CSS/css_docente/asignarDesafio.css">
</head>
<body>
    <div class="container">
        <h1>Asignar Nuevo Desafío</h1>

        <?php if ($mensaje): ?>
            <div class="mensaje"><?= htmlspecialchars($mensaje) ?></div>
        <?php endif; ?>

        <form method="POST" action="asignar_desafios.php">
            <label for="titulo">Título:</label>
            <input type="text" name="titulo" required>

            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" required></textarea>

            <label for="fecha_limite">Fecha Límite:</label>
            <input type="date" name="fecha_limite" required>

            <button type="submit">Asignar</button>
        </form>

        <a href="paneldocente.php" class="btn">Volver al Panel</a>
    </div>
</body>
</html>
