<?php
define('BASE_URL', 'http://localhost/ProyectoAula/');
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre'], $_POST['email'])) {
    $baseDir = dirname(dirname(__DIR__));
    require_once($baseDir . '../Model/crud/Usuario_crud.php'); 
    $crud = new Usuario_crud();

    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);

    if (!empty($nombre) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $crud->actualizarPerfil($_SESSION['usuario_id'], $nombre, $email);
        
        // Actualizar los datos en la sesión
        $_SESSION['nombre_usuario'] = $nombre;
        $_SESSION['correo'] = $email;
        
        header('Location: ' . BASE_URL . 'View/perfil.php?exito=1');
        exit;
    } else {
        header('Location: ' . BASE_URL . 'View/perfil.php?error=1');
        exit;
    }
} else {
    
    header('Location: ' . BASE_URL . 'View/perfil.php?error=1');
    exit;
}