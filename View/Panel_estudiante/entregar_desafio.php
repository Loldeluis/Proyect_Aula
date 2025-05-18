<?php
session_start();
if (!isset($_SESSION['nombre_usuario']) || $_SESSION['rol'] !== 'estudiante') {
    header('Location: login.html');
    exit();
}



$id_estudiante = $_SESSION['usuario_id'];
$id_desafio = filter_input(INPUT_POST, 'id_desafio', FILTER_VALIDATE_INT);




if (!$id_desafio) {
    echo "ID del desafío no especificado.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Entregar Desafío</title>
</head>
<body>
    <h2>Entregar Desafío</h2>
    <form action="../../Controller/Peticiones/procesar_entrega.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id_desafio" value="<?php echo $id_desafio; ?>">
                  <label for="contenido">Contenido de la entrega:</label><br><br>
            <textarea id="contenido" name="contenido" placeholder="Escribe tu respuesta..." rows="6" required></textarea>
        <label>Adjuntar archivo (opcional):</label><br><br>
        <input type="file" name="archivo"><br><br>
        <button type="submit">Enviar</button>
    </form>
    <a href="ver_desafios.php">
    ← Volver
</a>

</body>
</html>
