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
if (strtolower($extension) !== 'py') {
    die("El archivo debe tener extensión .py");
}

$contenido = file_get_contents($archivo['tmp_name']);
if (trim($contenido) === "") {
    die("El archivo .py está vacío.");
}

// Ruta del JSON
$jsonPath = __DIR__ . "/python-json/ejercicio_$numeroEjercicio.json";
if (!file_exists($jsonPath)) {
    die("No se encontró el archivo JSON del ejercicio.");
}
$data = json_decode(file_get_contents($jsonPath), true);
$salidaEsperada = trim($data['salida_esperada'] ?? "");

if ($salidaEsperada === "") {
    die("No se definió la salida esperada en el archivo JSON.");
}

// Crear carpeta de entregas
$destino = __DIR__ . "/entregas-python/ejercicio_$numeroEjercicio/";
if (!is_dir($destino)) {
    mkdir($destino, 0777, true);
}

$nombreBase = pathinfo($archivo['name'], PATHINFO_FILENAME);
$rutaPython = $destino . $nombreBase . ".py";
file_put_contents($rutaPython, $contenido);

// Ejecutar el script Python
$comandoEjecutar = "python3 " . escapeshellarg($rutaPython);
exec($comandoEjecutar, $outputEjecutar, $codigoEjecucion);

if ($codigoEjecucion !== 0) {
    die("❌ Error al ejecutar el archivo Python.<br><pre>" . implode("\n", $outputEjecutar) . "</pre>");
}

$salidaReal = trim(implode("\n", $outputEjecutar));

// Comparar salida
if ($salidaReal === $salidaEsperada) {
    echo "✅ ¡Ejercicio $numeroEjercicio correcto!<br><strong>Salida:</strong><pre>$salidaReal</pre>";
} else {
    echo "❌ Resultado incorrecto.<br><strong>Tu salida:</strong><pre>$salidaReal</pre><strong>Esperado:</strong><pre>$salidaEsperada</pre>";
}
?>
