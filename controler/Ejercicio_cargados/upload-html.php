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
    die("Error al subir el archivo. Código de error: " . $archivo['error']);
}

$extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
if (strtolower($extension) !== 'html') {
    die("El archivo debe tener extensión .html");
}

$contenido = file_get_contents($archivo['tmp_name']);
if (trim($contenido) === "") {
    die("El archivo .html está vacío.");
}

// Ruta del JSON
$jsonPath = __DIR__ . "/html-json/ejercicio_$numeroEjercicio.json";
if (!file_exists($jsonPath)) {
    die("No se encontró el archivo JSON del ejercicio.");
}
$data = json_decode(file_get_contents($jsonPath), true);
$salidaEsperada = trim($data['salida_esperada'] ?? "");

if ($salidaEsperada === "") {
    die("No se definió la salida esperada en el archivo JSON.");
}

// Crear carpeta de entregas
$destino = __DIR__ . "/entregas-html/ejercicio_$numeroEjercicio/";
if (!is_dir($destino)) {
    mkdir($destino, 0777, true);
}

$nombreBase = pathinfo($archivo['name'], PATHINFO_FILENAME);
$rutaHTML = $destino . $nombreBase . ".html";
file_put_contents($rutaHTML, $contenido);

// Comparar contenido
$contenidoReal = trim($contenido);

// Limpieza básica para comparar (ignorando espacios, tabulaciones y mayúsculas/minúsculas)
$normalizar = function($html) {
    return preg_replace('/\s+/', '', strtolower($html));
};

if ($normalizar($contenidoReal) === $normalizar($salidaEsperada)) {
    echo "✅ ¡Ejercicio $numeroEjercicio correcto!<br><strong>Contenido HTML válido.</strong>";
} else {
    echo "❌ Contenido incorrecto.<br><strong>Tu HTML:</strong><pre>$contenidoReal</pre><strong>Esperado:</strong><pre>$salidaEsperada</pre>";
}
?>
