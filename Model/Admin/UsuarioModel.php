<?php
require_once __DIR__ . '/../utilidades/bd/ConexionBD.php';

class UsuarioModel {
    private $conn;

    public function __construct() {
        $this->conn = (new ConexionBD())->conectar();
    }

    public function registrar(Usuario $usuario) {
    $sql = "INSERT INTO usuarios (cedula, nombre_usuario, correo, clave, rol, estado) VALUES (?, ?, ?, ?, ?, 1)";
    $stmt = $this->conn->prepare($sql);

    if (!$stmt) {
        // Error al preparar la consulta
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
        // Error al ejecutar la consulta
        throw new Exception("Error al ejecutar: " . $stmt->error);
    }

    return true;
}

}
