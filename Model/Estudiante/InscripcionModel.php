<?php
require_once __DIR__ . '/../utilidades/bd/ConexionBD.php';

class InscripcionModel {
    private $conn;

    public function __construct() {
        $this->conn = (new ConexionBD())->conectar();
    }

    public function obtenerCursos() {
        $sql = "SELECT * FROM cursos";
        return mysqli_query($this->conn, $sql);
    }

    public function yaInscrito($idEstudiante, $idCurso) {
        $sql = "SELECT * FROM estudiantes_cursos WHERE id_estudiante = ? AND id_curso = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $idEstudiante, $idCurso);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        return mysqli_stmt_num_rows($stmt) > 0;
    }

    public function inscribir($idEstudiante, $idCurso) {
        $sql = "INSERT INTO estudiantes_cursos (id_estudiante, id_curso) VALUES (?, ?)";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $idEstudiante, $idCurso);
        return mysqli_stmt_execute($stmt);
    }

    
public function obtenerCursosPorEstudiante($idEstudiante) {
    $sql = "SELECT c.* 
            FROM cursos c
            INNER JOIN estudiantes_cursos ec ON c.id_curso = ec.id_curso
            WHERE ec.id_estudiante = ?";
    $stmt = mysqli_prepare($this->conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $idEstudiante);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $cursos = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $cursos[] = $row;
    }
    return $cursos;
}
}
