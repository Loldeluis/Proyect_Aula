<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Acceso no permitido");
}

if (!isset($_FILES['archivo']) || !isset($_POST['numero_ejercicio'])) {
    die("Faltan datos del formulario.");
}

$archivo = $_FILES['archivo'];
$numeroEjercicio = intval($_POST['numero_ejercicio']);

if ($archivo['error'] !== UPLOAD_ERR_OK) {
    die("Error al subir el archivo.");
}

// Validar extensión
$extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
if (strtolower($extension) !== 'java') {
    die("El archivo debe tener extensión .java");
}

// Validar que el JSON del ejercicio exista
$jsonPath = __DIR__ . "../java-json/ejercicio_$numeroEjercicio.json";
if (!file_exists($jsonPath)) {
    die("No se encontró el archivo JSON del ejercicio.");
}

// Validar contenido del archivo .java
$contenido = file_get_contents($archivo['tmp_name']);
if (trim($contenido) === "") {
    die("El archivo .java está vacío.");
}

// Puedes agregar aquí más validaciones específicas si lo deseas
// Por ejemplo: comprobar si contiene una clase, o una palabra clave

// Mover el archivo a una carpeta de entregas (ejemplo)
$destino = __DIR__ . "/entregas/ejercicio_$numeroEjercicio/";
if (!is_dir($destino)) {
    mkdir($destino, 0777, true);
}
$nombreFinal = $destino . basename($archivo['name']);
if (move_uploaded_file($archivo['tmp_name'], $nombreFinal)) {
    echo "Archivo recibido y validado correctamente.";
} else {
    echo "No se pudo guardar el archivo.";
}
?>
