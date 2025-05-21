<?php
session_start();
if (!defined('BASE_URL')) {
    define('BASE_URL', 'http://localhost/ProyectoAula');
}
require_once '../../Model/entity/Conexion.php';
require_once '../../Model/crud/Usuario_crud.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: " . BASE_URL . "/View/login.php?error=sin_sesion");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $actual = trim($_POST['actual'] ?? '');
    $nueva = trim($_POST['password'] ?? '');
    $confirmar = trim($_POST['confirm_password'] ?? '');

    // Validaciones
    if (empty($actual) || empty($nueva) || empty($confirmar)) {
        header("Location: " . BASE_URL . "/View/perfil.php?error=campos_vacios");
        exit;
    }

    if ($nueva !== $confirmar) {
        header("Location: " . BASE_URL . "/View/perfil.php?error=confirmacion_incorrecta");
        exit;
    }

    if (strlen($nueva) < 6) {
        header("Location: " . BASE_URL . "/View/perfil.php?error=contrasena_corta");
        exit;
    }

    $crud = new Usuario_crud();
    $usuario = $crud->obtenerUsuarioPorId($_SESSION['usuario_id']);
    
    if (!$usuario) {
        header("Location: " . BASE_URL . "/View/perfil.php?error=usuario_no_encontrado");
        exit;
    }

    if (!password_verify($actual, $usuario['clave'])) {
        header("Location: " . BASE_URL . "/View/perfil.php?error=contrasena_actual_incorrecta");
        exit;
    }

    $nuevaHash = password_hash($nueva, PASSWORD_DEFAULT);
    $actualizado = $crud->actualizarContrasena((int)$_SESSION['usuario_id'], $nuevaHash);

    if ($actualizado) {
        header("Location: " . BASE_URL . "/View/perfil.php?exito_password=1");
    } else {
        header("Location: " . BASE_URL . "/View/perfil.php?error=error_actualizacion");
    }
    exit;
} else {
    header("Location: " . BASE_URL . "/View/perfil.php");
    exit;
}