<?php
session_start();

// Verificar que la cédula esté en la sesión.
$cedula = $_SESSION['cedula'] ?? die("No se encontró la cedula en la sesión.");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Acceso no permitido");
}

// Validar que se envíen los demás datos (archivo y número de ejercicio)
if (!isset($_FILES['archivo']) || !isset($_POST['numero_ejercicio'])) {
    die("Faltan datos del formulario.");
}

$archivo = $_FILES['archivo'];
$numeroEjercicio = intval($_POST['numero_ejercicio']);

// Ya no se necesita $_POST['cedula_usuario'] ya que usamos la variable de sesión $cedula

$baseDir = dirname(dirname(__DIR__));
require_once($baseDir . '/Model/crud/EjercicioCrud.php');

$crud = new EjercicioCrud();
$resultado = $crud->procesarArchivo("python", $numeroEjercicio, $archivo);

// Actualizar estado en la base de datos según resultado
if (strpos($resultado, '✅') === 0) {
    $estado = 'hecho';
} else {
    $estado = 'fallido';
}

// Actualizamos filtrando por el número de ejercicio y la cédula del usuario
$crud->actualizarEstadoEjercicio("python",$numeroEjercicio, $estado, $cedula);

// Mostrar resultado
echo $resultado;
?>
