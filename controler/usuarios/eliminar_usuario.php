<?php
session_start();
header('Content-Type: application/json');
$baseDir = dirname(dirname(__DIR__));
require_once($baseDir . '/Model/entity/Conexion.php');
require_once($baseDir . '/Model/crud/Usuario_crud.php');

$response = ['success' => false, 'message' => ''];

try {
    if (!isset($_SESSION['usuario_id'])) {
        throw new Exception('Sesión no iniciada');
    }

    if (!isset($_POST['password']) || empty(trim($_POST['password']))) {
        throw new Exception('Debes ingresar tu contraseña');
    }

    $usuario_id = $_SESSION['usuario_id'];
    $password = trim($_POST['password']);

    $crud = new Usuario_crud();
    $usuario = $crud->obtenerUsuarioPorId($usuario_id);

    if (!$usuario) {
        throw new Exception('Usuario no encontrado');
    }

    if (!password_verify($password, $usuario['password'])) {
        throw new Exception('Contraseña incorrecta');
    }

    $eliminado = $crud->eliminarUsuarioPorId($usuario_id);

    if (!$eliminado) {
        throw new Exception('No se pudo eliminar la cuenta');
    }

    session_destroy();

    $response['success'] = true;
    $response['message'] = 'Cuenta eliminada correctamente';
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
exit;