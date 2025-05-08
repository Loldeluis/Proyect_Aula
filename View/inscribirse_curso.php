<?php
session_start();
if (!isset($_SESSION['nombre_usuario']) || $_SESSION['rol'] !== 'estudiante') {
    header('Location: login.html');
    exit();
}

$nombre_estudiante = $_SESSION['nombre_usuario'];

$id_estudiante = $_SESSION['usuario_id'];

$conn = mysqli_connect("localhost", "root", "root", "bd_sistemaeducativo");
if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_curso = $_POST['id_curso'];

    // Verifica si ya está inscrito (opcional pero recomendado)
    $query = "SELECT * FROM estudiantes_cursos WHERE id_estudiante = ? AND id_curso = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ii", $id_estudiante, $id_curso);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        echo "<p>Ya estás inscrito en este curso.</p>";
    } else {
        // Insertar inscripción
        $insert = "INSERT INTO estudiantes_cursos (id_estudiante, id_curso) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $insert);
        mysqli_stmt_bind_param($stmt, "ii", $id_estudiante, $id_curso);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "<p>Inscripción exitosa.</p>";
        } else {
            echo "<p>Error al inscribirse: " . mysqli_error($conn) . "</p>";
        }
    }
}


// Obtener todos los cursos
$cursos = mysqli_query($conn, "SELECT * FROM cursos");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inscribirse a un curso</title>
    <link rel="stylesheet" href="../CSS/aprendizaje.css">
</head>
<body>
    <header>
        <h2>Inscribirse a un Curso</h2>
    </header>

    <div class="container">
        <form method="POST">
            <label for="id_curso">Selecciona un curso:</label>
            <select name="id_curso" required>
                <?php while ($curso = mysqli_fetch_assoc($cursos)): ?>
                    <option value="<?= $curso['id_curso'] ?>"><?= htmlspecialchars($curso['nombre']) ?></option>
                <?php endwhile; ?>
            </select>
            <button class="btn" type="submit">Inscribirse</button>
        </form>

        <button class="btn-back" onclick="window.location.href='aprendizaje.php'">Volver</button>
    </div>
</body>
</html>
