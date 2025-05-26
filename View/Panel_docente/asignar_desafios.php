<?php
session_start();
if (!isset($_SESSION['nombre_usuario']) || $_SESSION['rol'] !== 'docente') {
    header("Location: ../../login.php");
    exit();
}

require_once __DIR__ . '/../../Controller/Docente/DesafioController.php';
require_once __DIR__ . '/../../Model/Docente/CursoModel.php';

$controller = new DesafioController();
$id_docente = $_SESSION['usuario_id'];
$mensaje = "";

if (!class_exists('CursoModel')) {
    die('La clase CursoModel no fue encontrada. Revisa el archivo y su contenido.');
}

$cursos = (new CursoModel())->obtenerCursosPorDocente($id_docente);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = [
        'titulo' => $_POST['titulo'] ?? '',
        'descripcion' => $_POST['descripcion'] ?? '',
        'fecha_limite' => $_POST['fecha_limite'] ?? '',
        'id_curso' => $_POST['id_curso'] ?? 0,
        'id_docente' => $id_docente
    ];

    // Validación de fecha
    $fecha_limite = $data['fecha_limite'];
    $hoy = date('Y-m-d');
    if ($fecha_limite < $hoy) {
        $mensaje = "❌ La fecha límite no puede ser menor a la fecha actual. Por favor, cámbiala.";
    } else {
        if ($controller->asignarDesafio($data)) {
            $mensaje = "✅ Desafío asignado exitosamente.";
        } else {
            $mensaje = "❌ Error al asignar desafío.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asignar Desafío</title>
    <link rel="stylesheet" href="../CSS/asignarDesafio.css">
</head>
<body>
    <div class="container">
        <h1>Asignar Nuevo Desafío</h1>

        <?php if (!empty($mensaje)): ?>
            <div class="mensaje"><?= htmlspecialchars($mensaje) ?></div>
        <?php endif; ?>

        <form method="POST" action="asignar_desafios.php">
            <label for="titulo">Título:</label>
            <input type="text" name="titulo" required>

            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" required></textarea>

            <label for="fecha_limite">Fecha Límite:</label>
            <input type="date" name="fecha_limite" required>

            <label for="id_curso">Curso:</label>
            <select name="id_curso" required>
                <option value="">Seleccione un curso</option>
                <?php foreach ($cursos as $curso): ?>
                    <option value="<?= $curso['id_curso'] ?>"><?= htmlspecialchars($curso['nombre']) ?></option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Asignar</button>
        </form>

        <a href="../../Model/crud/desafios_crud.php" class="btn">Ver Desafíos</a>
        <a href="docente.php" class="btn">Volver al Panel</a>
    </div>
</body>
</html>
