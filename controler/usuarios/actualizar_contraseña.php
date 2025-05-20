<?php
session_start();
$baseDir = dirname(dirname(__DIR__));
require_once($baseDir . '/Model/entity/Conexion.php');
require_once($baseDir . '/Model/crud/Usuario_crud.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['usuario_id'])) {
        header('Location: ../view/login.php');
        exit;
    }

    $usuario_id = $_SESSION['usuario_id'];
    $actual = $_POST['actual'] ?? '';
    $nueva = $_POST['nueva'] ?? '';
    $confirmar = $_POST['confirmar'] ?? '';

    if (empty($actual) || empty($nueva) || empty($confirmar)) {
        header('Location: ' . BASE_URL . '/view/perfil.php?error=empty_password_fields');
        exit;
    }

    if ($nueva !== $confirmar) {
        header('Location: ' . BASE_URL . '/view/perfil.php?error=password_mismatch');
        exit;
    }

    $crud = new Usuario_crud();
    $usuario = $crud->obtenerUsuarioPorId($usuario_id);

    if (!$usuario) {
        header('Location: ' . BASE_URL . '/view/perfil.php?error=user_not_found');
        exit;
    }

    // Verificar la contraseña actual con password_verify
    if (!password_verify($actual, $usuario['password'])) {
        header('Location: ' . BASE_URL . '/view/perfil.php?error=wrong_current_password');
        exit;
    }

    // Hashear la nueva contraseña
    $hashNueva = password_hash($nueva, PASSWORD_DEFAULT);

    // Actualizar en la BD
    $actualizado = $crud->actualizarContrasena($usuario_id, $hashNueva);

    if ($actualizado) {
        header('Location:' . BASE_URL . '/view/perfil.php?exito_password=1');
    } else {
        header('Location: ' . BASE_URL . '/view/perfil.php?error=update_failed');
    }
    exit;
} else {
    header('Location: ' . BASE_URL . '/view/perfil.php');
    exit;
}