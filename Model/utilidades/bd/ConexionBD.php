<?php
// Model/utilidades/bd/ConexionBD.php
require_once 'IConexionBD.php';

class ConexionBD implements IConexionBD {
    private $host = "localhost";
    private $usuario = "root";
    private $password = "root";
    private $basedatos = "bd_sistemaeducativo";
    private $conexion;

    public function conectar() {
        $this->conexion = new mysqli($this->host, $this->usuario, $this->password, $this->basedatos);

        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }

        // Opcional: configurar charset utf8
        $this->conexion->set_charset("utf8");

        return $this->conexion;
    }

    public function desconectar() {
        if ($this->conexion) {
            $this->conexion->close();
        }
    }
}
