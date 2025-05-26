<?php
require_once __DIR__ . '/../utilidades/bd/ConexionBD.php';

class DesafioModel {
    private $conn;

    public function __construct() {
        $conexion = new ConexionBD();
        $this->conn = $conexion->conectar();
    }

    public function obtenerDesafiosPorEstudiante($idEstudiante) {
        $sql = "
            SELECT 
                d.id_desafio AS id_desafio,
                d.titulo, 
                d.descripcion, 
                d.fecha_limite, 
                d.fecha_creacion,
                c.nombre AS nombre_curso,
                ed.id_entrega IS NOT NULL AS entregado
            FROM desafios d
            JOIN cursos c ON d.id_curso = c.id_curso
            JOIN estudiantes_cursos ec ON c.id_curso = ec.id_curso
            LEFT JOIN entregas_desafios ed ON ed.id_desafio = d.id_desafio AND ed.id_estudiante = ?
            WHERE ec.id_estudiante = ?
            GROUP BY d.id_desafio, d.titulo, d.descripcion, d.fecha_limite, d.fecha_creacion, c.nombre, ed.id_entrega
            ORDER BY d.fecha_limite ASC
        ";

        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $idEstudiante, $idEstudiante);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $desafios = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $desafios[] = $row;
        }

        return $desafios;
    }
}
