<?php
session_start();

if (!isset($_SESSION['nombre_usuario']) || $_SESSION['rol'] !== 'docente') {
    header('Location: ../../login.html');
    exit();
}

require_once __DIR__ . '/../../Model/Docente/CursoModel.php';

$nombre_docente = $_SESSION['nombre_usuario'];
$id_docente = $_SESSION['usuario_id'];

$model = new CursoModel();
$cursos = $model->obtenerCursosPorDocente($id_docente);

// Llama a la vista correcta (verifica que la ruta sea la correcta)
include __DIR__ . '/../../View/Panel_docente/ver_cursos.php';
