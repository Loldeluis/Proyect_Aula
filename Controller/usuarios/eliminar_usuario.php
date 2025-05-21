<?php
session_start();
require_once '../../Model/entity/Conexion.php';
require_once '../../Model/crud/Usuario_crud.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../View/perfil.php?error=sin_sesion');
    exit;
}

if (!isset($_POST['password']) || empty(trim($_POST['password']))) {
    header('Location: ../../View/perfil.php?error=contrasena_requerida');
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$password = trim($_POST['password']);

$crud = new Usuario_crud();
$usuario = $crud->obtenerUsuarioPorId($usuario_id);

if (!$usuario) {
    header('Location: ../../View/perfil.php?error=usuario_no_encontrado');
    exit;
}

if (!password_verify($password, $usuario['clave'])) {
    header('Location: ../../View/perfil.php?error=contrasena_incorrecta');
    exit;
}

$eliminado = $crud->eliminarUsuarioPorId($usuario_id);

if (!$eliminado) {
    header('Location: ../../View/perfil.php?error=eliminacion_fallida');
    exit;
}

session_destroy();
header('Location: ../../View/despedida.php');
exit;