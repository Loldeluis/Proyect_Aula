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
if (strtolower($extension) !== 'java') {
    die("El archivo debe tener extensión .java");
}

$contenido = file_get_contents($archivo['tmp_name']);
if (trim($contenido) === "") {
    die("El archivo .java está vacío.");
}

// Ruta del JSON
$jsonPath = __DIR__ . "/java-json/ejercicio_$numeroEjercicio.json";
if (!file_exists($jsonPath)) {
    die("No se encontró el archivo JSON del ejercicio.");
}
$data = json_decode(file_get_contents($jsonPath), true);
$salidaEsperada = trim($data['salida_esperada'] ?? "");

// Crear carpeta de entregas
$destino = __DIR__ . "/entregas-java/ejercicio_$numeroEjercicio/";
if (!is_dir($destino)) {
    mkdir($destino, 0777, true);
}

$nombreBase = pathinfo($archivo['name'], PATHINFO_FILENAME);
$rutaJava = $destino . $nombreBase . ".java";
file_put_contents($rutaJava, $contenido);

// Compilar
$comandoCompilar = "javac " . escapeshellarg($rutaJava);
exec($comandoCompilar, $outputCompilar, $codigoCompilacion);

if ($codigoCompilacion !== 0) {
    die("❌ Error al compilar el archivo.<br><pre>" . implode("\n", $outputCompilar) . "</pre>");
}

// Ejecutar (desde el mismo directorio)
$comandoEjecutar = "java -cp " . escapeshellarg($destino) . " " . escapeshellarg($nombreBase);
exec($comandoEjecutar, $outputEjecutar, $codigoEjecucion);

if ($codigoEjecucion !== 0) {
    die("❌ Error al ejecutar el archivo.<br><pre>" . implode("\n", $outputEjecutar) . "</pre>");
}

$salidaReal = trim(implode("\n", $outputEjecutar));

// Comparar salida
if ($salidaReal === $salidaEsperada) {
    echo "✅ ¡Ejercicio $numeroEjercicio correcto!<br><strong>Salida:</strong><pre>$salidaReal</pre>";
} else {
    echo "❌ Resultado incorrecto.<br><strong>Tu salida:</strong><pre>$salidaReal</pre><strong>Esperado:</strong><pre>$salidaEsperada</pre>";
}
?>
