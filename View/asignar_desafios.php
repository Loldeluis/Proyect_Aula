<?php
session_start();
if (!isset($_SESSION['nombre_usuario']) || $_SESSION['rol'] !== 'docente') {
    header('Location: login.html');
    exit();
}

$id_docente = $_SESSION['usuario_id'];

$conn = mysqli_connect("localhost", "root", "", "bd_sistemaeducativo");
if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Obtener los cursos asignados al docente
$cursos = [];
$sql = "SELECT id_curso, nombre FROM cursos WHERE id_docente = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_docente);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
while ($row = mysqli_fetch_assoc($result)) {
    $cursos[] = $row;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asignar Desafío</title>
    <link rel="stylesheet" href="../CSS/aprendizaje.css">
</head>
<body>
    <header>
        <h2>Asignar Desafío</h2>
    </header>

    <div class="container">
        <form method="POST" action="guardar_desafio.php">
            <label for="curso">Curso:</label><br>
            <select name="id_curso" required>
                <option value="">Seleccione un curso</option>
                <?php foreach ($cursos as $curso): ?>
                    <option value="<?php echo $curso['id_curso']; ?>">
                        <?php echo htmlspecialchars($curso['nombre']); ?>
                    </option>
                <?php endforeach; ?>
            </select><br><br>

            <label for="titulo">Título del desafío:</label><br>
            <input type="text" name="titulo" required><br><br>

            <label for="descripcion">Descripción:</label><br>
            <textarea name="descripcion" rows="5" required></textarea><br><br>

            <label for="fecha_limite">Fecha límite:</label><br>
            <input type="date" name="fecha_limite"><br><br>

            <input type="submit" value="Guardar desafío" class="btn">
        </form>

        <button class="btn-back" onclick="location.href='docente.php'">
            <i class="fas fa-arrow-left"></i> Volver al panel
        </button>
    </div>
</body>
</html>
