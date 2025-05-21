<?php
session_start();

if (!isset($_SESSION['nombre_usuario']) || $_SESSION['rol'] !== 'estudiante') {
    header('Location: ../../login.html');
    exit();
}

// Controller/Estudiante/DesafioController.php
require_once __DIR__ . '/../../Model/Estudiante/DesafioModel.php';

$idEstudiante = $_SESSION['usuario_id'];

$model = new DesafioModel();
$desafios = $model->obtenerDesafiosPorEstudiante($idEstudiante);

// DEBUG
// var_dump($desafios); exit;

require_once __DIR__ . '/../../View/Panel_estudiante/ver_desafios.php';

