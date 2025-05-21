<?php
session_start();

if (!isset($_SESSION['nombre_usuario']) || $_SESSION['rol'] !== 'docente') {
    header('Location: ../../login.html');
    exit();
}

require_once __DIR__ . '/../../Model/Docente/UsuarioModel.php';

$nombre_docente = $_SESSION['nombre_usuario'];

$model = new UsuarioModel();
$estudiantes = $model->obtenerEstudiantes();

include __DIR__ . '/../../View/Panel_docente/ver_estudiantes.php';
