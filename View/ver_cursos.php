<?php
session_start();

// Verificación de sesión y rol
if (!isset($_SESSION['nombre_usuario']) || $_SESSION['rol'] !== 'estudiante') {
    header('Location: login.html');
    exit();
}

$nombre_estudiante = $_SESSION['nombre_usuario'];
$id_estudiante = $_SESSION['usuario_id']; // Este debe estar guardado en login

// Conexión
$conn = mysqli_connect("localhost", "root", "root", "bd_sistemaeducativo");
if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Consulta de calificaciones para el estudiante
$sql = "SELECT e.calificacion, e.comentario
        FROM entregas_desaios e
        JOIN desafios d ON e.id_desafio = d.id_desafio
        WHERE e.id_estudiante = ?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_estudiante);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Cursos</title>
    <link rel="stylesheet" href="../CSS/aprendizaje.css">
</head>
<body>
    <header>
        <h2>Mis Cursos - Docente: <?php echo htmlspecialchars($nombre_docente); ?></h2>
    </header>

    <div class="container">
        <table border="1" cellpadding="10" cellspacing="0">
            <tr>
                <th>Código</th>
                <th>Nombre del Curso</th>
                <th>Nivel</th>
                <th>Acciones</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['codigo']); ?></td>
                    <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($row['nivel']); ?></td>
                    <td>
                        <a href="detalle_curso.php?id=<?php echo $row['id_curso']; ?>">Ver Detalles</a>
                    </td>
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
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
