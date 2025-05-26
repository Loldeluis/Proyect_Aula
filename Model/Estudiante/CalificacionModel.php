<?php
require_once __DIR__ . '/../utilidades/bd/ConexionBD.php';

class CalificacionModel {
    private $conn;

    public function __construct() {
        $this->conn = (new ConexionBD())->conectar();
    }

    public function obtenerCalificacionesPorEstudiante($id_estudiante) {
        $sql = "SELECT d.titulo, e.calificacion, e.retroalimentacion
                FROM entregas_desafios e
                INNER JOIN desafios d ON e.id_desafio = d.id_desafio
                WHERE e.id_estudiante = ?";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Error en la consulta: " . $this->conn->error);
        }

        $stmt->bind_param("i", $id_estudiante);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
