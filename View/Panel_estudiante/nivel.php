<?php
session_start();
include 'informacion.php'; // Asegúrate que este archivo conecta a tu BD usando PDO

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: datos.php");
    exit();
}

// Obtener los datos de la URL
$usuario_id = $_SESSION['usuario_id'];
$lenguaje = $_GET['lenguaje'] ?? '';
$nivel = (int) ($_GET['nivel'] ?? 0);

// Validar parámetros
if (empty($lenguaje) || $nivel < 1 || $nivel > 3) {
    echo "<script>alert('Parámetros inválidos'); window.location.href='aprendizaje.php';</script>";
    exit();
}

// Establecer la conexión PDO (verifica que 'informacion.php' tenga el código adecuado para la conexión)
try {
    $conn = new PDO("mysql:host=localhost;dbname=bd_sistemaeducativo", "root", "root");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error en la conexión: " . $e->getMessage();
    exit();
}

// Validar progreso: solo permitir acceso si el nivel anterior está completado
if ($nivel > 1) {
    $nivel_anterior = $nivel - 1;

    $sql = "SELECT completado FROM progreso 
            WHERE usuario_id = :usuario_id AND lenguaje = :lenguaje AND nivel = :nivel_anterior";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':usuario_id' => $usuario_id, 
        ':lenguaje' => $lenguaje, 
        ':nivel_anterior' => $nivel_anterior
    ]);
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$resultado || !$resultado['completado']) {
        echo "<script>
            alert('Debes completar el Nivel $nivel_anterior antes de acceder al Nivel $nivel.');
            window.location.href='aprendizaje.php';
        </script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($lenguaje); ?> - Nivel <?php echo $nivel; ?></title>
    <link rel="stylesheet" href="../CSS/nivel.css">
</head>
<body>
    <header>
        <h1><?php echo htmlspecialchars($lenguaje); ?> - Nivel <?php echo $nivel; ?></h1>
    </header>

    <main>
        <p>¡Bienvenido al nivel <?php echo $nivel; ?> de <?php echo htmlspecialchars($lenguaje); ?>!</p>

        <form action="completar_nivel.php" method="POST">
            <input type="hidden" name="lenguaje" value="<?php echo htmlspecialchars($lenguaje); ?>">
            <input type="hidden" name="nivel" value="<?php echo $nivel; ?>">
            <button type="submit">Finalizar Nivel</button>
        </form>

        <br>
        <button onclick="window.location.href='aprendizaje.php'">← Volver al Panel</button>
    </main>
</body>
</html>
