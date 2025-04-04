<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$lenguaje = isset($_GET['lenguaje']) ? $_GET['lenguaje'] : 'Desconocido';
$nivel = isset($_GET['nivel']) ? $_GET['nivel'] : '0';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo "Aprendiendo $lenguaje - Nivel $nivel"; ?></title>
    <link rel="stylesheet" href="../CSS/nivel.css">
</head>
<body>
    <header>Bienvenido al Nivel <?php echo htmlspecialchars($nivel); ?> de <?php echo htmlspecialchars($lenguaje); ?></header>
    <div class="container">
        <p>Aquí irá el contenido de aprendizaje para <?php echo htmlspecialchars($lenguaje); ?> en el Nivel <?php echo htmlspecialchars($nivel); ?>.</p>
        <button onclick="window.location.href='aprendizaje.php'">← Volver</button>
    </div>
</body>
</html>
