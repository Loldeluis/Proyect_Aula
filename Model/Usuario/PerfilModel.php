<?php
require_once __DIR__ . '/../utilidades/bd/ConexionBD.php';

class PerfilModel {
    private $db;

    public function __construct() {
        $conexion = new ConexionBD();
        $this->db = $conexion->conectar();
    }

    public function obtenerUsuarioPorId($id) {
        $sql = "SELECT id_usuario, nombre_usuario, correo FROM usuarios WHERE id_usuario = ?";
        $stmt = $this->db->prepare($sql);
        if (!$stmt) {
            die("Error en prepare: " . $this->db->error);
        }

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc();
    }

  


public function actualizarUsuario($datos) {
    if (empty($datos['nombre']) || empty($datos['correo']) || empty($datos['id_usuario'])) {
        die("Faltan datos obligatorios para actualizar el usuario.");
    }

    $sql = "UPDATE usuarios SET nombre_usuario = ?, correo = ? WHERE id_usuario = ?";
    $stmt = $this->db->prepare($sql);

    if (!$stmt) {
        die("Error en prepare: " . $this->db->error);
    }

    $stmt->bind_param("ssi", $datos['nombre'], $datos['correo'], $datos['id_usuario']);

    if (!$stmt->execute()) {
        die("Error en execute: " . $stmt->error);
    }

    echo "Filas afectadas: " . $stmt->affected_rows;

    if ($stmt->affected_rows === 0) {
        return false;
    }

    return true;
}


public function verificarPassword($id, $password) {
    $sql = "SELECT clave FROM usuarios WHERE id_usuario = ?";
    $stmt = $this->db->prepare($sql);
    if (!$stmt) {
        die("Error en prepare: " . $this->db->error);
    }

    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $usuario = $resultado->fetch_assoc();

    return $usuario && $password === $usuario['clave'];
}

    public function eliminarUsuario($id) {
        $sql = "DELETE FROM usuarios WHERE id_usuario = ?";
        $stmt = $this->db->prepare($sql);
        if (!$stmt) {
            die("Error en prepare: " . $this->db->error);
        }

        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
