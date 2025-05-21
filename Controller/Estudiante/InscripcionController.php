<?php
session_start();
if (!isset($_SESSION['nombre_usuario']) || $_SESSION['rol'] !== 'estudiante') {
    header('Location: ../../View/login.html');
    exit();
}

require_once __DIR__ . '/../../Model/Estudiante/InscripcionModel.php';

$model = new InscripcionModel();
$mensaje = "";

$idEstudiante = $_SESSION['usuario_id'];
$nombreEstudiante = $_SESSION['nombre_usuario'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_curso'])) {
    $idCurso = $_POST['id_curso'];

    if ($model->yaInscrito($idEstudiante, $idCurso)) {
        $mensaje = "Ya estás inscrito en este curso.";
    } else {
        $exito = $model->inscribir($idEstudiante, $idCurso);
        $mensaje = $exito ? "Inscripción exitosa." : "Error al inscribirse.";
    }
}

$cursos = $model->obtenerCursos();


// Línea corregida
require_once __DIR__ . '/../../View/Panel_estudiante/inscribirse_curso.php';

