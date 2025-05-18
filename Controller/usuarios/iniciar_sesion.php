<?php
define('BASE_URL', 'http://localhost/ProyectoAula');
$baseDir = dirname(dirname(__DIR__));
require_once($baseDir . '/Model/entity/Conexion.php');
require_once($baseDir . '/Model/crud/Usuario_crud.php');

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (empty($email) || empty($password)) {
            throw new Exception("Debes ingresar el correo y la contraseña.");
        }

        $crud = new Usuario_crud();
        $usuario = $crud->iniciarSesion($email, $password);

        // Guardar en sesión
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nombre'] = $usuario['nombre'];
        $_SESSION['usuario_rol'] = $usuario['rol'];

        header('Location: ' . BASE_URL . '/View/aprendizaje.php');
        exit();

    } catch (Exception $e) {
        $_SESSION['error_login'] = $e->getMessage();
        $_SESSION['form_login'] = $_POST;
        header('Location: ' . BASE_URL . '/View/login.php');
        exit();
    }
}
?>