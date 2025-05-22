<?php
session_start();
date_default_timezone_set('America/Bogota');

if ($_SESSION['rol'] !== 'admin') {
    header("Location: ../login.html");
    exit();
}

require_once __DIR__ . '/../Controller/Admin/UsuarioController.php';

$controller = new UsuarioController();

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Validación mínima
        $nombre = trim($_POST['nombre']);
        $cedula = trim($_POST['cedula']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $rol = $_POST['rol'];

        if (empty($nombre) || empty($cedula) || empty($email) || empty($password) || empty($rol)) {
            throw new Exception("Todos los campos son obligatorios.");
        }

        $datos = [
            'nombre' => $nombre,
            'cedula' => $cedula,
            'email' => $email,
            'password' => $password,
            'rol' => $rol
        ];

        // Intenta registrar y captura si hay errores internos
        $exito = $controller->registrarUsuario($datos);

        if ($exito) {
            header('Location: ../View/Panel_admin/usuarios.php?success=Usuario+registrado');
            exit();
        } else {
            throw new Exception("No se pudo registrar el usuario.");
        }
    }
} catch (Exception $e) {
    // Puedes loguear el error si estás en producción
    error_log("Error al registrar usuario: " . $e->getMessage());

    // En desarrollo, puedes ver el error completo
    header('Location: ../View/Panel_admin/registrar_usuario.php?error=' . urlencode("Error: " . $e->getMessage()));
    exit();
}
