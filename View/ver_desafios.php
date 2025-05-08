<?php
session_start();
if (!isset($_SESSION['nombre_usuario']) || $_SESSION['rol'] !== 'estudiante') {
    header('Location: login.html');
    exit();
}

$id_estudiante = $_SESSION['usuario_id'];

$conn = mysqli_connect("localhost", "root", "root", "bd_sistemaeducativo");
if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Consulta de desafíos
$sql = "
SELECT 
    d.id_desafio AS id_desafio,
    d.titulo, 
    d.descripcion, 
    d.fecha_limite, 
    d.fecha_creacion,
    c.nombre AS nombre_curso
FROM desafios d
JOIN cursos c ON d.id_curso = c.id_curso
JOIN estudiantes_cursos ec ON c.id_curso = ec.id_curso
WHERE ec.id_estudiante = ?
ORDER BY d.fecha_limite ASC
";



$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    die("Error en la preparación de la consulta: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "i", $id_estudiante);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$desafios = [];
while ($row = mysqli_fetch_assoc($result)) {
    $desafios[] = $row;
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Desafíos</title>
    <link rel="stylesheet" href="../CSS/aprendizaje.css">
    <style>
        .desafio-box {
            border-left: 8px solid #6f42c1;
            padding: 15px;
            margin-bottom: 15px;
            background:rgb(189, 13, 13);
            border-radius: 8px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
        }
        .btn-entrega {
            background: #28a745;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }
        .btn-entrega:hover {
            background: #218838;
        }
    </style>
</head>
<body>
    <header>
        <h2>Desafíos Asignados</h2>
    </header>

    <div class="container">
        <?php if (empty($desafios)): ?>
            <p>No tienes desafíos asignados por el momento.</p>
        <?php else: ?>
            <?php foreach ($desafios as $desafio): ?>
                <div class="desafio-box">
                    <h3><?php echo htmlspecialchars($desafio['titulo']); ?></h3>
                    <p><strong>Curso:</strong> <?php echo htmlspecialchars($desafio['nombre_curso']); ?></p>
                    <p><strong>Descripción:</strong><br> <?php echo nl2br(htmlspecialchars($desafio['descripcion'])); ?></p>
                    <p><strong>Fecha límite:</strong> <?php echo htmlspecialchars($desafio['fecha_limite']); ?></p>
                    <p><strong>Asignado el:</strong> <?php echo htmlspecialchars($desafio['fecha_creacion']); ?></p>
                    <!-- Opción de entrega futura -->
                    <form action="entregar_desafio.php" method="get" style="margin-top:10px;">
                        <input type="hidden" name="id_desafio" value="<?php echo $desafio['id_desafio']; ?>">
                        <button type="submit" class="btn-entrega">Entregar Desafío</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <button class="btn-back" onclick="window.location.href='aprendizaje.php'">
            <i class="fas fa-arrow-left"></i> Volver
        </button>
    </div>
</body>
</html>
