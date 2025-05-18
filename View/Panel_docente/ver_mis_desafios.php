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

// Obtener desafíos asignados al docente
$sql = "SELECT d.id_desafio, d.titulo, d.descripcion, d.fecha_limite, c.nombre AS curso
        FROM desafios d
        INNER JOIN cursos c ON d.id_curso = c.id_curso
        WHERE d.id_docente = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_docente);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Desafíos</title>
    <link rel="stylesheet" href="../CSS/aprendizaje.css">
</head>
<body>
    <div class="container">
        <h2>Mis Desafíos</h2>

        <?php if ($result && mysqli_num_rows($result) > 0): ?>
          <table class="table-desafios" style="border-spacing: 0 17px; border-collapse: separate;">

    <thead>
        <tr>
            <th>Título</th>
            <th>Descripción</th>
            <th>Curso</th>
            <th>Fecha límite</th>
            <th>Acciones</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['titulo']); ?></td>
                <td><?php echo htmlspecialchars($row['descripcion']); ?></td>
                <td><?php echo htmlspecialchars($row['curso']); ?></td>
                <td><?php echo htmlspecialchars($row['fecha_limite']); ?></td>
             <td>
  <a href="desafios_crud.php?accion=editar&id=<?php echo $row['id_desafio']; ?>" class="btn">Editar</a>
</td>

   

<td><a href="desafios_crud.php?accion=eliminar&id=<?php echo $row['id_desafio']; ?>" class="btn" onclick="return confirm('¿Seguro que deseas eliminar este desafío?');">Eliminar</a></td>

            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

        <?php else: ?>
            <p>No tienes desafíos asignados.</p>
        <?php endif; ?>
    </div>
      <button class="btn-back" onclick="location.href='asignar_desafios.php'">
            <i class="fas fa-arrow-left"></i> Volver 
        </button>
</body>
</html>
