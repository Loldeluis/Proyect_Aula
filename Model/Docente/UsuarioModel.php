<?php
require_once __DIR__ . '/../utilidades/bd/ConexionBD.php';

class UsuarioModel {
    private $conn;

    public function __construct() {
        $this->conn = (new ConexionBD())->conectar();
    }

    public function obtenerEstudiantes() {
        $sql = "SELECT id_usuario, nombre_usuario, correo, cedula, estado FROM usuarios WHERE rol = 'estudiante'";
        $result = $this->conn->query($sql);

        $estudiantes = [];
        while ($row = $result->fetch_assoc()) {
            $estudiantes[] = $row;
        }

        return $estudiantes;
    }
}
