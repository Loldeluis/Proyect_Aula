<?php
require_once __DIR__ . '/../utilidades/bd/ConexionBD.php';

class AccesoModel {
    private $conn;

    public function __construct() {
        $conexion = new ConexionBD();
        $this->conn = $conexion->conectar();
    }

    public function obtenerAccesos() {
        $query = "SELECT u.nombre_usuario, a.fecha_entrada, a.fecha_salida, a.estado_acceso
                  FROM accesos_usuario a
                  INNER JOIN usuarios u ON a.id_usuario = u.id_usuario
                  ORDER BY a.fecha_entrada DESC";

        $result = mysqli_query($this->conn, $query);
        $accesos = [];

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $accesos[] = $row;
            }
        }

        return $accesos;
    }

    public function __destruct() {
        if ($this->conn) {
            mysqli_close($this->conn);
        }
    }
}
