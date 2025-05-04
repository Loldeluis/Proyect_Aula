<?php
require_once 'Conexion.php';

class Usuario {
    private $nombre;
    private $cedula;
    private $email;
    private $password;
    private $rol;
    private $institucion;
    private $conexion;

    public function __construct($nombre, $cedula, $email, $password, $rol, $institucion) {
        $this->nombre = $nombre;
        $this->cedula = $cedula;
        $this->email = $email;
        $this->password = password_hash($password, PASSWORD_DEFAULT);
        $this->rol = $rol;
        $this->institucion = $institucion;
        
        try {
            $this->conexion = Conexion::getConexion();
        } catch (Exception $e) {
            throw new Exception("Error al conectar con la base de datos: " . $e->getMessage());
        }
    }

    public function insertar() {
        try {
            // Verificar cédula duplicada
            if ($this->campoExiste('cedula', $this->cedula)) {
                throw new Exception("La cédula {$this->cedula} ya está registrada", 1001);
            }

            // Verificar email duplicado
            if ($this->campoExiste('correo', $this->email)) {
                throw new Exception("El correo {$this->email} ya está registrado", 1002);
            }

            // Insertar usuario
            $sql = "INSERT INTO usuarios 
                    (nombre_usuario, correo, clave, cedula, rol, estado, fecha_registro, id_institucion) 
                    VALUES (?, ?, ?, ?, ?, 1, NOW(), ?)";

            $stmt = $this->conexion->prepare($sql);
            
            if ($stmt === false) {
                throw new Exception("Error al preparar la consulta: " . $this->conexion->error);
            }

            $stmt->bind_param("sssssi", 
                $this->nombre, 
                $this->email, 
                $this->password, 
                $this->cedula, 
                $this->rol, 
                $this->institucion
            );

            if (!$stmt->execute()) {
                throw new Exception("Error al registrar usuario: " . $stmt->error);
            }

            $stmt->close();
            return true;

        } catch (Exception $e) {
            // Cerrar statement si está abierto
            if (isset($stmt) && $stmt instanceof mysqli_stmt) {
                $stmt->close();
            }
            throw $e;
        }
    }

    private function campoExiste($campo, $valor) {
        $query = "SELECT id_usuario FROM usuarios WHERE $campo = ?";
        $stmt = $this->conexion->prepare($query);
        
        if ($stmt === false) {
            throw new Exception("Error al preparar consulta de verificación: " . $this->conexion->error);
        }

        $stmt->bind_param("s", $valor);
        
        if (!$stmt->execute()) {
            throw new Exception("Error al verificar campo único: " . $stmt->error);
        }

        $stmt->store_result();
        $existe = $stmt->num_rows > 0;
        $stmt->close();
        
        return $existe;
    }
}
?>