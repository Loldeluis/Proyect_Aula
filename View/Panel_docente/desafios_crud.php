<?php
session_start();

if (!isset($_SESSION['nombre_usuario']) || $_SESSION['rol'] !== 'docente') {
    header('Location: login.html');
    exit();
}
require_once __DIR__ . '/../../Model/utilidades/bd/ConexionBD.php';

$conexion = new ConexionBD();
$conn = $conexion->conectar();


$id_docente = $_SESSION['usuario_id'];
$accion = $_GET['accion'] ?? 'ver';
$id_desafio = $_GET['id'] ?? null;

// ACTUALIZAR DESAFÍO
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['editar'])) {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $fecha_limite = $_POST['fecha_limite'];
    $id_desafio = $_POST['id_desafio'];

    $sql = "UPDATE desafios SET titulo = ?, descripcion = ?, fecha_limite = ? WHERE id_desafio = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssi", $titulo, $descripcion, $fecha_limite, $id_desafio);
    mysqli_stmt_execute($stmt);
    header("Location: desafios_crud.php");
    exit();
}

// ELIMINAR DESAFÍO
if ($accion === 'eliminar' && is_numeric($id_desafio)) {
    // Primero borra las entregas asociadas
    $sql1 = "DELETE FROM entregas_desafios WHERE id_desafio = ?";
    $stmt1 = mysqli_prepare($conn, $sql1);
    mysqli_stmt_bind_param($stmt1, "i", $id_desafio);
    mysqli_stmt_execute($stmt1);

    // Luego borra el desafío
    $sql2 = "DELETE FROM desafios WHERE id_desafio = ?";
    $stmt2 = mysqli_prepare($conn, $sql2);
    mysqli_stmt_bind_param($stmt2, "i", $id_desafio);
    mysqli_stmt_execute($stmt2);

    header("Location: desafios_crud.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Desafíos</title>
    <link rel="stylesheet" href="../CSS/aprendizaje.css">
</head>
<body>
<div class="container">
    <h2>Gestión de Desafíos</h2>

    <?php if ($accion === 'editar' && $id_desafio): 
        $sql = "SELECT * FROM desafios WHERE id_desafio = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id_desafio);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $desafio = mysqli_fetch_assoc($result);
        
        ?>

        <?php if (!$desafio): ?>
        <p>Desafío no encontrado.</p>
        <?php else: ?>

        <form method="POST">
            <input type="hidden" name="id_desafio" value="<?php echo $desafio['id_desafio']; ?>">
            <label>Título:</label><br>
            <input type="text" name="titulo" value="<?php echo htmlspecialchars($desafio['titulo']); ?>" required><br><br>
            <label>Descripción:</label><br>
            <textarea name="descripcion" required><?php echo htmlspecialchars($desafio['descripcion']); ?></textarea><br><br>
            <label>Fecha Límite:</label><br>
            <input type="date" name="fecha_limite" value="<?php echo $desafio['fecha_limite']; ?>" required><br><br>
            <button type="submit" name="editar">Guardar Cambios</button>
        </form>
        <br>
        <a href="desafios_crud.php" class="btn">Cancelar</a>
     <?php endif; ?>

    <?php else: 
        // VER LISTADO
        $sql = "SELECT d.id_desafio, d.titulo, d.descripcion, d.fecha_limite, c.nombre AS curso
                FROM desafios d
                INNER JOIN cursos c ON d.id_curso = c.id_curso
                WHERE d.id_docente = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id_docente);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        ?>

        <?php if (mysqli_num_rows($result) > 0): ?>
            <table class="table-desafios">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Descripción</th>
                        <th>Curso</th>
                        <th>Fecha límite</th>
                        <th colspan="2">Acciones</th>
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
                            <td>
                                <a href="desafios_crud.php?accion=eliminar&id=<?php echo $row['id_desafio']; ?>" class="btn" onclick="return confirm('¿Seguro que deseas eliminar este desafío?');">Eliminar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No tienes desafíos asignados.</p>
        <?php endif; ?>
    <?php endif; ?>
</div>
 <button class="btn-back" onclick="window.location.href='asignar_desafios.php'">
            <i class="fas fa-arrow-left"></i> Volver
        </button>
</body>
</html>
