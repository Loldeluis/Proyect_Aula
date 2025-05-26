<?php
session_start();
require_once __DIR__ . '/../../Model/Autenticacion/RegistrarModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $cedula = trim($_POST['cedula']);
    $rol = trim($_POST['rol']);
    $institucion = trim($_POST['institucion']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmar_password = trim($_POST['confirmar_password']);

    // Validar campos vacíos
    if (empty($nombre) || empty($cedula) || empty($rol) || empty($institucion) || empty($email) || empty($password) || empty($confirmar_password)) {
        echo "<script>alert('Complete todos los campos'); window.location.href='../../View/formulario_registro.php';</script>";
        exit();
    }

    // Validar que las contraseñas coincidan
    if ($password !== $confirmar_password) {
        echo "<script>alert('Las contraseñas no coinciden'); window.location.href='../../View/formulario_registro.php';</script>";
        exit();
    }

    try {
        $usuarioModel = new RegistrarModel();
        $usuarioModel->insertarUsuario($nombre, $cedula, $rol, $institucion, $email, $password);

        echo "<script>alert('Usuario registrado correctamente'); window.location.href='../../View/login.php';</script>";
        exit();

    } catch (Exception $e) {
        echo "<script>alert('Error: " . addslashes($e->getMessage()) . "'); window.location.href='../../View/formulario_registro.php';</script>";
        exit();
    }
} else {
    header('Location: ../../View/registrar.php');
    exit();
}
