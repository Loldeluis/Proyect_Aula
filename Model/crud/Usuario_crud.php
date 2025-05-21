<?php
$baseDir = dirname(dirname(__DIR__));
require_once($baseDir . '../Model/entity/Conexion.php');
require_once($baseDir . '../Model/entity/Usuario.php');

$_SESSION['error_registro'] = $mensaje ?? null;
$_SESSION['campo_error'] = $campoError ?? null; 
$_SESSION['form_data'] = $_POST;
class Usuario_crud {
    private $conexion;
    public function __construct() {
        try {
            $this->conexion = Conexion::obtenerConexion();
        } catch (Exception $e) {
            error_log("Error al obtener conexión en Usuario_crud: " . $e->getMessage());
            throw new Exception("Error interno. Intente más tarde.");
        }
    }

    public function crearUsuario(Usuario $usuario) {
    if (
        empty($usuario->getNombre()) ||
        empty($usuario->getCedula()) ||
        empty($usuario->getEmail()) ||
        empty($usuario->getPassword())
    ) {
        throw new Exception("Todos los campos obligatorios deben estar completos.");
    }

    $cedula = $usuario->getCedula();
    $email = $usuario->getEmail();

    $existencia = $this->verificarExistencia($cedula, $email);

    if ($existencia['cedula']) {
        throw new Exception("Ya existe un usuario registrado con esa cédula.");
    }

    if ($existencia['correo']) {
        throw new Exception("El correo ya está registrado. Por favor usa uno diferente.");
    }

    $sql = "INSERT INTO usuarios (nombre_usuario, correo, clave, cedula, rol, estado, fecha_registro, id_institucion)
            VALUES (?, ?, ?, ?, ?, 1, NOW(), ?)";

    $stmt = $this->conexion->prepare($sql);

    if ($stmt === false) {
        error_log("Error al preparar consulta de inserción: " . $this->conexion->error);
        throw new Exception("No se pudo registrar el usuario.");
    }

    $nombre = $usuario->getNombre();
    $email = $usuario->getEmail();
    $password = $usuario->getPassword();
    $cedula = $usuario->getCedula();
    $rol = $usuario->getRol();
    $institucion = $usuario->getInstitucion();

    $stmt->bind_param(
    "sssssi",
    $nombre,
    $email,
    $password,
    $cedula,
    $rol,
    $institucion
    );

    if (!$stmt->execute()) {
        error_log("Error al ejecutar inserción de usuario: " . $stmt->error);
        throw new Exception("Error al insertar el usuario.");
    }

    $stmt->close();
    return true;
}

public function iniciarSesion($email, $password) {
    $sql = "SELECT id_usuario, nombre_usuario, clave, rol FROM usuarios WHERE correo = ? AND estado = 1 LIMIT 1";
    $stmt = $this->conexion->prepare($sql);

    if (!$stmt) {
        error_log("Error al preparar consulta de login: " . $this->conexion->error);
        throw new Exception("Error interno. Intente más tarde.");
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 0) {
        throw new Exception("Correo no registrado o usuario inactivo.");
    }

    $usuario = $resultado->fetch_assoc();

    // Verificar el hash de la contraseña
    if (!password_verify($password, $usuario['clave'])) {
        throw new Exception("Contraseña incorrecta.");
    }

    // Autenticación exitosa
    return [
        'id' => $usuario['id_usuario'],
        'nombre' => $usuario['nombre_usuario'],
        'rol' => $usuario['rol']
    ];
}
public function obtenerUsuarioPorId($id) {
    $conexion = Conexion::obtenerConexion();
    $sql = "SELECT u.nombre_usuario, u.correo, u.cedula, u.rol, u.clave, i.nombre AS institucion 
        FROM usuarios u 
        JOIN instituciones i ON u.id_institucion = i.id_institucion 
        WHERE u.id_usuario = ?";
    $stmt = $conexion->prepare($sql);
    
    if (!$stmt) {
        throw new Exception("Error en prepare: " . $conexion->error);
    }

    $stmt->bind_param("i", $id);  // "i" indica que el parámetro es un entero
    $stmt->execute();
    
    $resultado = $stmt->get_result();
    return $resultado->fetch_assoc();
}

public function actualizarPerfil($id_usuario, $nombre, $email) {
    $conexion = Conexion::obtenerConexion();
    $sql = "UPDATE usuarios SET nombre_usuario = ?, correo = ? WHERE id_usuario = ?";
    $stmt = $conexion->prepare($sql);

    if (!$stmt) {
        error_log("Error en prepare: " . $conexion->error);
        return false;
    }

    $stmt->bind_param("ssi", $nombre, $email, $id_usuario);
    $resultado = $stmt->execute();
    $stmt->close();
    
    return $resultado;
}

public function actualizarContrasena($id, $nuevaContrasenaHash) {
    $id = (int)$id;
    if ($id <= 0) {
        error_log("ID inválido para actualizar contraseña: " . $id);
        return false;
    }

    try {
        $sql = "UPDATE usuarios SET clave = ? WHERE id_usuario = ?";
        $stmt = $this->conexion->prepare($sql);

        if (!$stmt) {
            error_log("Error al preparar la consulta: " . $this->conexion->error);
            return false;
        }

        $stmt->bind_param('si', $nuevaContrasenaHash, $id);
        $resultado = $stmt->execute();
        
        if (!$resultado) {
            error_log("Error al ejecutar la consulta: " . $stmt->error);
            return false;
        }

        // Verificar si realmente se actualizó alguna fila
        if ($stmt->affected_rows === 0) {
            error_log("No se actualizó ninguna fila para el ID: " . $id);
            return false;
        }

        return true;
    } catch (Exception $e) {
        error_log("Excepción al actualizar contraseña: " . $e->getMessage());
        return false;
    }
}

public function eliminarUsuarioPorId($id){
    try {
        $sql = "DELETE FROM usuarios WHERE id_usuario = ?";
        $stmt = $this->conexion->prepare($sql);

        if (!$stmt) {
            error_log('Error al preparar la consulta: ' . $this->conexion->error);
            return false;
        }

        $stmt->bind_param('i', $id); 

        if ($stmt->execute()) {
            return true;
        } else {
            error_log('Error al ejecutar la consulta: ' . $stmt->error);
            return false;
        }
    } catch (Exception $e) {
        error_log('Error al eliminar usuario: ' . $e->getMessage());
        return false;
    }
}
    public function verificarExistencia($cedula, $correo) {
    $sql = "SELECT cedula, correo FROM usuarios WHERE cedula = ? OR correo = ?";
    $stmt = $this->conexion->prepare($sql);

    if ($stmt === false) {
        error_log("Error al preparar consulta de existencia: " . $this->conexion->error);
        throw new Exception("No se pudo verificar la existencia.");
    }

    $stmt->bind_param("ss", $cedula, $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    $existeCedula = false;
    $existeCorreo = false;

    while ($row = $resultado->fetch_assoc()) {
        if ($row['cedula'] === $cedula) {
            $existeCedula = true;
        }
        if ($row['correo'] === $correo) {
            $existeCorreo = true;
        }
    }$stmt->close();

    return ['cedula' => $existeCedula, 'correo' => $existeCorreo];

    }
    
    }

?>