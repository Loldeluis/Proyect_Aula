<?php
session_start();

// Verifica que el usuario sea Estudiante y que la sesión esté iniciada
if (!isset($_SESSION['nombre_usuario']) || $_SESSION['rol'] !== 'Estudiante') {
    header('Location: ../login.php');
    exit();
}

$nombre_estudiante = $_SESSION['nombre_usuario'];
// Inicializamos la variable (opcional) para evitar avisos
$resultadoEvaluacion = "";
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Ejercicios java</title>
  <link rel="stylesheet" href="../CSS/ejercicios.css">
</head>
<body>
  <header>
    <h1>Lista de Ejercicios java</h1>
  </header>

  <main id="contenedor-ejercicios" class="contenedor-ejercicios">
    <!-- Los botones se generarán dinámicamente con JavaScript -->
  </main>

  <!-- Modal para la subida del archivo -->
  <div id="modal" class="modal oculto">
    <div class="modal-contenido">
      <span id="cerrarModal" class="cerrar">&times;</span>
      <p id="descripcion-ejercicio"></p>
      <!-- El formulario envía el número de ejercicio y el archivo. La cédula se obtiene de la sesión -->
      <form id="form-subida" action="../../Controller/Ejercicio_cargados/upload-java.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" id="numero-ejercicio" name="numero_ejercicio">
        <label for="archivo">Sube tu archivo (.java):</label>
        <input type="file" id="archivo" name="archivo" accept=".java" required>
        <button type="submit">Enviar</button>
        <div id="resultado-evaluacion" style="margin-top: 10px">
          <?php if ($resultadoEvaluacion): ?>
            <?= $resultadoEvaluacion ?>
          <?php endif; ?>
        </div>
      </form>
    </div>
  </div>

  <script src="../JS/ejercicios-java.js"></script>
  <a href="aprendizaje.php">Regresar</a>
</body>
</html>
