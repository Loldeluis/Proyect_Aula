<?php
session_start();

// Verifica que el usuario es docente
if (!isset($_SESSION['nombre_usuario']) || $_SESSION['rol'] !== 'docente') {
    header('Location: login.html');
    exit();
}

$nombre_docente = $_SESSION['nombre_usuario'];

// Conexión a la base de datos
$conn = mysqli_connect("localhost", "root", "root", "bd_sistemaeducativo");
if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Consulta para obtener los estudiantes
$sql = "SELECT id_usuario, nombre_usuario, correo, cedula, estado FROM usuarios WHERE rol = 'estudiante'";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Estudiantes</title>
    <link rel="stylesheet" href="../CSS/aprendizaje.css">
</head>
<body>
    <header>
        <h2>Estudiantes Registrados</h2>
        <p>Docente: <?php echo htmlspecialchars($nombre_docente); ?></p>
    </header>

    <div class="container">
        <table border="1" cellpadding="10" cellspacing="0">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Cédula</th>
                <th>Correo</th>
                <th>Estado</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td><?php echo $row['id_usuario']; ?></td>
                    <td><?php echo htmlspecialchars($row['nombre_usuario']); ?></td>
                    <td><?php echo $row['cedula']; ?></td>
                    <td><?php echo $row['correo']; ?></td>
                    <td><?php echo $row['estado'] ? 'Activo' : 'Inactivo'; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>

        <button class="btn-back" onclick="window.location.href='docente.php'">
            <i class="fas fa-arrow-left"></i> Volver
        </button>
    </div>

</body>
</html>

<?php
mysqli_close($conn);
?>
