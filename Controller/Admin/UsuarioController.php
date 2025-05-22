<?php
require_once __DIR__ . '/../../Model/Admin/UsuarioModel.php';
require_once __DIR__ . '/../../Model/entity/Usuario.php';

class UsuarioController {
    private $model;

    public function __construct() {
        $this->model = new UsuarioModel();
    }

    public function registrarUsuario($datos) {
        $usuario = new Usuario(
            $datos['nombre'],
            $datos['cedula'],
            $datos['email'],
            $datos['password'],
            $datos['rol']
        );

        return $this->model->registrar($usuario);
    }
}
