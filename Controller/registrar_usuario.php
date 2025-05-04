<?php
require_once '../Model/Usuario.php';

$resultado = null;
$mensaje = '';
$esExito = false;
$campoError = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $usuario = new Usuario(
            $_POST['nombre'],
            $_POST['cedula'],
            $_POST['email'],
            $_POST['password'],
            $_POST['rol'],
            $_POST['institucion']
        );
        
        if ($usuario->insertar()) {
            $resultado = true;
            $mensaje = 'Usuario registrado correctamente';
            $esExito = true;
        }
    } catch (Exception $e) {
        $resultado = false;
        $mensaje = $e->getMessage();
        $esExito = false;
        
        // Determinar el campo con error
        if (strpos($mensaje, 'cédula') !== false) {
            $campoError = 'cedula';
        } elseif (strpos($mensaje, 'correo') !== false) {
            $campoError = 'correo';
        }
    }
}

// Almacenar mensajes en sesión para mostrarlos después de la redirección
session_start();
$_SESSION['resultado'] = $resultado;
$_SESSION['mensaje'] = $mensaje;
$_SESSION['esExito'] = $esExito;
$_SESSION['campoError'] = $campoError;

// Redirigir de vuelta al formulario
header('Location: ../View/formularioinsertar.php');
exit;
?>