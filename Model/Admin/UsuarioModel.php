<?php
require_once __DIR__ . '/../utilidades/bd/ConexionBD.php';
require_once __DIR__ . '/../entity/Usuario.php';

class UsuarioModel {
    private $conn;

    public function __construct() {
        // Usa ConexionBD en vez del Singleton
        $this->conn = (new ConexionBD())->conectar();
    }

    public function registrar(Usuario $usuario) {
        $sql = "INSERT INTO usuarios (cedula, nombre_usuario, correo, clave, rol, estado) VALUES (?, ?, ?, ?, ?, 1)";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            throw new Exception("Error preparando la consulta: " . $this->conn->error);
        }

        $cedula = $usuario->getCedula();
        $nombre = $usuario->getNombre();
        $email = $usuario->getEmail();
        $hashedPassword = password_hash($usuario->getPassword(), PASSWORD_DEFAULT);
        $rol = $usuario->getRol();

        if (!$stmt->bind_param("sssss", $cedula, $nombre, $email, $hashedPassword, $rol)) {
            throw new Exception("Error al enlazar parámetros: " . $stmt->error);
        }

        if (!$stmt->execute()) {
            throw new Exception("Error al ejecutar: " . $stmt->error);
        }

        return true;
    }

    public function obtenerUsuarios() {
        $sql = "SELECT id_usuario, cedula, nombre_usuario, correo, rol, estado FROM usuarios";
        $result = $this->conn->query($sql);

        if (!$result) {
            throw new Exception("Error al ejecutar la consulta: " . $this->conn->error);
        }

        $usuarios = [];
        while ($row = $result->fetch_assoc()) {
            $usuarios[] = $row;
        }

        return $usuarios;
    }

    public function inactivarUsuario($id) {
        $sql = "UPDATE usuarios SET estado = 0 WHERE id_usuario = ?";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            throw new Exception("Error preparando la consulta: " . $this->conn->error);
        }

        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function editarUsuario($datos) {
        $sql = "UPDATE usuarios SET cedula = ?, nombre_usuario = ?, correo = ?, rol = ?, estado = ? WHERE id_usuario = ?";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            throw new Exception("Error preparando la consulta: " . $this->conn->error);
        }

        $stmt->bind_param(
            "ssssii",
            $datos['cedula'],
            $datos['nombre'],
            $datos['email'],
            $datos['rol'],
            $datos['estado'],
            $datos['id']
        );

        return $stmt->execute();
    }
}
