<?php
// UsuarioModel.php
require_once __DIR__ . '/../entity/Conexion.php';

class RegistrarModel {
    private $conexion;

    public function __construct() {
        $this->conexion = Conexion::obtenerConexion();
    }

    public function insertarUsuario($nombre, $cedula, $rol, $institucion, $email, $password) {
        // Hashear contraseña
        $clave_hash = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO usuarios (nombre_usuario, cedula, rol, institucion, correo, clave, estado) VALUES (?, ?, ?, ?, ?, ?, 1)";

        $stmt = mysqli_prepare($this->conexion, $query);
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . mysqli_error($this->conexion));
        }

        mysqli_stmt_bind_param($stmt, "ssssss", $nombre, $cedula, $rol, $institucion, $email, $clave_hash);

        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Error al insertar usuario: " . mysqli_stmt_error($stmt));
        }

        mysqli_stmt_close($stmt);
        return true;
    }
}
?>
