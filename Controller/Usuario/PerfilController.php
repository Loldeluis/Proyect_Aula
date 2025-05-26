<?php
require_once __DIR__ . '/../../Model/Usuario/PerfilModel.php';

class PerfilController {
    private $model;

    public function __construct() {
        $this->model = new PerfilModel();
    }

    public function mostrarPerfil($idUsuario) {
        $usuario = $this->model->obtenerUsuarioPorId($idUsuario);
        require '../../View/Usuario/perfil.php';
    }

public function actualizarPerfil($datos) {
    $resultado = $this->model->actualizarUsuario($datos);

    if ($resultado) {
        // Actualiza la variable de sesión con el nuevo nombre
        $_SESSION['nombre_usuario'] = $datos['nombre'];
        header('Location: ../../View/login.php');
    } else {
        header('Location: ../../View/principal.php?msg=error_actualizar');
    }
}

    public function eliminarCuenta($idUsuario, $password) {
        if ($this->model->verificarPassword($idUsuario, $password)) {
            $this->model->eliminarUsuario($idUsuario);
            session_destroy();
            header('Location: ../../View/login.php?msg=cuenta_eliminada');
        } else {
            header('Location: ../../View/Usuario/confirmar_eliminar.php?error=clave_incorrecta');
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controlador = new PerfilController();

    if ($_POST['accion'] === 'actualizar') {
        $controlador->actualizarPerfil($_POST);
    }

    if ($_POST['accion'] === 'eliminar') {
        $controlador->eliminarCuenta($_POST['id_usuario'], $_POST['password']);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['mostrar'])) {
        $controlador = new PerfilController();
        $controlador->mostrarPerfil($_GET['mostrar']);
    }
}
