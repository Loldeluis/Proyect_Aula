<?php
$baseDir = dirname(dirname(__DIR__));
require_once($baseDir . '/Model/entity/Conexion.php');  
require_once($baseDir . '/Model/crud/Usuario_crud.php');

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        if (
            empty($_POST['nombre']) ||
            empty($_POST['cedula']) ||
            empty($_POST['email']) ||
            empty($_POST['password']) ||
            empty($_POST['rol']) ||
            empty($_POST['institucion'])
        ) {
            throw new Exception("Todos los campos son obligatorios.");
        }
        $claveHash = password_hash($_POST['password'], PASSWORD_DEFAULT);
        // Crear objeto Usuario 
        $usuario = new Usuario($_POST['nombre'],
            $_POST['cedula'],
            $_POST['email'],
            $claveHash,
            $_POST['rol'],
            $_POST['institucion']
        );

        $crud = new Usuario_crud();

        // Intentar registrar usuario
        if ($crud->crearUsuario($usuario)) {
            // Registro exitoso - guardamos mensaje en sesión y redirigimos
            $_SESSION['mensaje_exito'] = 'Usuario registrado correctamente';
            error_log("Redirigiendo a login...");
            header('Location: ' .BASE_URL. '/View/login.php');
            exit();
        } else {
            throw new Exception("No se pudo registrar el usuario.");
        }

    } catch (Exception $e) {
        $mensaje = $e->getMessage();

        // Detectar qué campo falló
        if (strpos($mensaje, 'cédula') !== false) {
            $campoError = 'cedula';
        } elseif (strpos($mensaje, 'correo') !== false || strpos($mensaje, 'email') !== false) {
            $campoError = 'email';
        } else {
            $campoError = null;
        }

        // Guardar datos del formulario y error
        $_SESSION['form_data'] = $_POST;
        $_SESSION['error_registro'] = $mensaje;
        $_SESSION['campo_error'] = $campoError;

        header('Location: ' . BASE_URL . '/View/formulario_registro.php');
        exit();
    }
}

?>