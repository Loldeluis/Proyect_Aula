<?php
require_once __DIR__ . '/../utilidades/bd/ConexionBD.php';

class CursoModel {
    private $conn;

    public function __construct() {
        $this->conn = (new ConexionBD())->conectar();
    }

    public function obtenerCursosPorDocente($id_docente) {
        $stmt = $this->conn->prepare("SELECT id_curso, nombre FROM cursos WHERE id_docente = ?");
        $stmt->bind_param("i", $id_docente);
        $stmt->execute();
        $result = $stmt->get_result();

        $cursos = [];
        while ($row = $result->fetch_assoc()) {
            $cursos[] = $row;
        }

        return $cursos;
    }
}
