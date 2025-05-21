<?php
require_once __DIR__ . '/../utilidades/bd/ConexionBD.php';

class ReporteModel {
    private $conn;

    public function __construct() {
        $conexion = new ConexionBD();
        $this->conn = $conexion->conectar();
    }

    public function obtenerPorEstudiante($id_estudiante) {
        $sql = "SELECT e.id_entrega, d.titulo, u.nombre_usuario AS estudiante, e.calificacion, e.retroalimentacion
                FROM entregas_desafios e
                JOIN desafios d ON e.id_desafio = d.id_desafio
                JOIN usuarios u ON e.id_estudiante = u.id_usuario
                WHERE e.id_estudiante = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id_estudiante);
        mysqli_stmt_execute($stmt);
        return mysqli_stmt_get_result($stmt);
    }

    public function obtenerPorCurso($id_curso) {
        $sql = "SELECT e.id_entrega, d.titulo, u.nombre_usuario AS estudiante, c.nombre AS curso, e.calificacion, e.retroalimentacion
                FROM entregas_desafios e
                JOIN desafios d ON e.id_desafio = d.id_desafio
                JOIN cursos c ON d.id_curso = c.id_curso
                JOIN usuarios u ON e.id_estudiante = u.id_usuario
                WHERE c.id_curso = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id_curso);
        mysqli_stmt_execute($stmt);
        return mysqli_stmt_get_result($stmt);
    }

    public function obtenerGeneral() {
        $sql = "SELECT e.id_entrega, d.titulo, u.nombre_usuario AS estudiante, c.nombre AS curso, e.calificacion, e.retroalimentacion
                FROM entregas_desafios e
                JOIN desafios d ON e.id_desafio = d.id_desafio
                JOIN cursos c ON d.id_curso = c.id_curso
                JOIN usuarios u ON e.id_estudiante = u.id_usuario";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_execute($stmt);
        return mysqli_stmt_get_result($stmt);
    }

    public function obtenerEstudiantes() {
        return mysqli_query($this->conn, "SELECT id_usuario, nombre_usuario FROM usuarios WHERE rol = 'estudiante'");
    }

    public function obtenerCursos() {
        return mysqli_query($this->conn, "SELECT id_curso, nombre FROM cursos");
    }
}
