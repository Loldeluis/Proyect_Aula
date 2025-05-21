<?php
require_once __DIR__ . '/../utilidades/bd/ConexionBD.php';

class CursoModel {
    private $conn;

    public function __construct() {
        $this->conn = (new ConexionBD())->conectar();
    }

public function obtenerCursosPorDocente($id_docente) {
$stmt = $this->conn->prepare("SELECT id_curso, nombre, codigo, nivel FROM cursos WHERE id_docente = ?");

    if ($stmt === false) {
        die('Error en la preparación de la consulta: ' . htmlspecialchars($this->conn->error));
    }
    
    $stmt->bind_param("i", $id_docente);
    $stmt->execute();
    $result = $stmt->get_result();

    $cursos = [];
    while ($row = $result->fetch_assoc()) {
        $cursos[] = $row;
    }

    $stmt->close();  // Liberar recurso
    return $cursos;
}

}
