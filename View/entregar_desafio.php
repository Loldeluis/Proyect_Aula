<?php
session_start();
if (!isset($_SESSION['nombre_usuario']) || $_SESSION['rol'] !== 'estudiante') {
    header('Location: login.html');
    exit();
}



$id_estudiante = $_SESSION['usuario_id'];
$id_desafio = isset($_GET['id_desafio']) ? $_GET['id_desafio'] : null;



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
    <form action="procesar_entrega.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id_desafio" value="<?php echo $id_desafio; ?>">
        <textarea name="contenido" placeholder="Escribe tu respuesta..." rows="6" cols="50"></textarea><br><br>
        <label>Adjuntar archivo (opcional):</label>
        <input type="file" name="archivo"><br><br>
        <button type="submit">Enviar</button>
    </form>
</body>
</html>
