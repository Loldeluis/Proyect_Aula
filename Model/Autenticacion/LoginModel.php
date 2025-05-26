<?php
class LoginModel {
    private $conexion;

    public function __construct() {
        require_once(__DIR__ . '/../entity/Conexion.php'); // Verifica que esta ruta es correcta
        $this->conexion = Conexion::obtenerConexion(); // Usa Singleton
    }

  
public function verificarCredenciales($email, $password) {
    $query = "SELECT id_usuario, clave, nombre_usuario, rol, estado, cedula FROM usuarios WHERE correo = ?";
    $stmt = mysqli_prepare($this->conexion, $query);

    if (!$stmt) {
        return ['error' => 'Error en prepare: ' . $this->conexion->error];
    }

    mysqli_stmt_bind_param($stmt, "s", $email);

    if (!mysqli_stmt_execute($stmt)) {
        return ['error' => 'Error en execute: ' . mysqli_stmt_error($stmt)];
    }

    mysqli_stmt_bind_result($stmt, $id_usuario, $clave_hash, $nombre_usuario, $rol, $estado, $cedula);

    if (mysqli_stmt_fetch($stmt)) {
        // Solo permite usuarios con estado = 1
        if ($estado == 0) {
            return ['error' => 'Usuario inactivo o eliminado'];
        }

        if (password_verify($password, $clave_hash)) {
            return [
                'id_usuario' => $id_usuario,
                'nombre_usuario' => $nombre_usuario,
                'rol' => $rol,
                'cedula' => $cedula
            ];
        } else {
            return ['error' => 'Contraseña incorrecta'];
        }
    }

    return ['error' => 'Usuario no encontrado'];
}

   public function registrarAcceso($id_usuario) {
    $fecha = date("Y-m-d H:i:s");

    // Asegúrate de insertar solo en columnas que permiten valores no nulos
    $query = "INSERT INTO accesos_usuario (id_usuario, fecha_entrada, estado_acceso) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($this->conexion, $query);

    if (!$stmt) {
        die("Error en prepare de registrarAcceso: " . $this->conexion->error);
    }

    $estado = 'Éxito';

    mysqli_stmt_bind_param($stmt, "iss", $id_usuario, $fecha, $estado);

    if (!mysqli_stmt_execute($stmt)) {
        die("Error en execute de registrarAcceso: " . mysqli_stmt_error($stmt));
    }
}

}
