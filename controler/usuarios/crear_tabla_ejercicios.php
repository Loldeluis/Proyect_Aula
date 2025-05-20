<?php
require_once dirname(dirname(__DIR__)) . '/Model/entity/Conexion.php';

session_start();

if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['usuario_nombre'])) {
    die("Acceso no permitido.");
}

// Obtener la conexión
$conexion = Conexion::obtenerConexion();
$usuario_nombre = strtolower(str_replace(" ", "_", $_SESSION['usuario_nombre']));
$tabla_ejercicios = "ejercicios_" . $usuario_nombre;

// Verificar si la tabla ya existe
$sql_verificar = "SHOW TABLES LIKE ?";
$stmt_verificar = mysqli_prepare($conexion, $sql_verificar);
mysqli_stmt_bind_param($stmt_verificar, "s", $tabla_ejercicios);
mysqli_stmt_execute($stmt_verificar);
mysqli_stmt_store_result($stmt_verificar);

if (mysqli_stmt_num_rows($stmt_verificar) == 0) { // Si la tabla no existe, se crea
    $sql_create = "CREATE TABLE $tabla_ejercicios (
        id INT AUTO_INCREMENT PRIMARY KEY,
        lenguaje ENUM('Java', 'HTML', 'Python') NOT NULL,
        nivel VARCHAR(20) NOT NULL,
        estado ENUM('espera', 'fallido', 'hecho') NOT NULL DEFAULT 'espera'
    )";
    mysqli_query($conexion, $sql_create);

    // Insertar los ejercicios
    $sql_insert = "INSERT INTO $tabla_ejercicios (lenguaje, nivel, estado) VALUES (?, ?, ?)";
    $stmt_insert = mysqli_prepare($conexion, $sql_insert);

    foreach (['Java', 'HTML', 'Python'] as $lenguaje) {
        for ($i = 1; $i <= 30; $i++) {
            mysqli_stmt_bind_param($stmt_insert, "sss", $lenguaje, "Nivel-$i", "espera");
            mysqli_stmt_execute($stmt_insert);
        }
    }

    echo "✔️ Tabla $tabla_ejercicios creada y ejercicios asignados.";
} else {
    echo "⚠️ Tabla ya existe, no se necesita crear.";
}
?>

