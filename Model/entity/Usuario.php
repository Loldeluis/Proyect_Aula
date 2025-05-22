<?php
$baseDir = dirname(dirname(__DIR__));
require_once($baseDir . '../Model/entity/Conexion.php'); 


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
        $this->password = $password;
        $this->rol = $rol;
        $this->institucion = $institucion;
        
        try {
            $this->conexion = Conexion::obtenerConexion();
        } catch (Exception $e) {
            throw new Exception("Error al conectar con la base de datos: " . $e->getMessage());
        }
    }

     // Getters
    public function getNombre() {
        return $this->nombre;
    }

    public function getCedula() {
        return $this->cedula;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getRol() {
        return $this->rol;
    }

    public function getInstitucion() {
        return $this->institucion;
    }

    
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

   public function setPassword($password) {
    $this->password = $password; // <- sin hash
}
    public function setRol($rol) {
        $this->rol = $rol;
    }

    public function setInstitucion($institucion) {
        $this->institucion = $institucion;
    }
}    
?>