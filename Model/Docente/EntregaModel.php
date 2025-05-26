<?php
require_once __DIR__ . '/../utilidades/bd/ConexionBD.php';

class EntregaModel {
    private $conn;

    public function __construct() {
        $conexion = new ConexionBD();
        $this->conn = $conexion->conectar();
    }

    public function obtenerEntregasPorDocente($id_docente) {
        $sql = "SELECT ed.id_entrega, u.nombre_usuario AS nombre_estudiante, d.titulo AS titulo_desafio,
                ed.contenido, ed.fecha_entrega, ed.calificacion, ed.retroalimentacion, ed.archivo
                FROM entregas_desafios ed
                JOIN desafios d ON ed.id_desafio = d.id_desafio
                JOIN usuarios u ON ed.id_estudiante = u.id_usuario
                WHERE d.id_docente = ?
                ORDER BY ed.fecha_entrega DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id_docente);
        $stmt->execute();
        $result = $stmt->get_result();

        $entregas = [];
        while ($row = $result->fetch_assoc()) {
            $entregas[] = $row;
        }

        return $entregas;
    }

    public function calificarEntrega($id_entrega, $calificacion, $retroalimentacion) {
        $sql = "UPDATE entregas_desafios SET calificacion = ?, retroalimentacion = ? WHERE id_entrega = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("dsi", $calificacion, $retroalimentacion, $id_entrega);
        return $stmt->execute();
    }
}
?>
