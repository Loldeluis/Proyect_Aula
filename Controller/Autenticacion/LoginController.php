<?php
session_start();
date_default_timezone_set('America/Bogota');
require_once __DIR__ . '/../../Model/Autenticacion/LoginModel.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        echo "<script>alert('Complete todos los campos'); window.location.href='../../View/login.php';</script>";
        exit();
    }

    $loginModel = new LoginModel();
    $usuario = $loginModel->verificarCredenciales($email, $password);

    if (isset($usuario['error'])) {
        echo "<script>alert('" . $usuario['error'] . "'); window.location.href='../../View/login.php';</script>";
        exit();
    }

    $_SESSION['usuario_id'] = $usuario['id_usuario'];
    $_SESSION['correo'] = $email;
    $_SESSION['nombre_usuario'] = $usuario['nombre_usuario'];
    $_SESSION['rol'] = $usuario['rol'];
    $_SESSION['cedula'] = $usuario['cedula'];

    $loginModel->registrarAcceso($usuario['id_usuario']); // Asegúrate que este método existe

    switch ($usuario['rol']) {
        case 'admin':
            header("Location: ../../View/panel_admin/paneladmin.php");
            break;
        case 'docente':
            header("Location: ../../View/Panel_docente/docente.php");
            break;
        default:
            header("Location: ../../View/Principal.php");
            break;
    }
    exit();
}
?>
