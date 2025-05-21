<?php
require_once '/../utilidades/bd/ConexionBD.php';
require_once '/../entity/Desafio.php';


class DesafioModel {
    private $conn;

    public function __construct() {
        $this->conn = (new ConexionBD())->conectar();
    }

    public function guardar(Desafio $desafio) {
        $stmt = $this->conn->prepare("INSERT INTO desafios (titulo, descripcion, fecha_limite, id_curso, id_docente) VALUES (?, ?, ?, ?, ?)");

        $stmt->bind_param(
            "sssii",
            $desafio->getTitulo(),
            $desafio->getDescripcion(),
            $desafio->getFechaLimite(),
            $desafio->getIdCurso(),
            $desafio->getIdDocente()
        );

        return $stmt->execute();
    }

    public function obtenerPorDocente($id_docente) {
        $stmt = $this->conn->prepare("SELECT d.*, c.nombre AS nombre_curso FROM desafios d JOIN cursos c ON d.id_curso = c.id_curso WHERE d.id_docente = ?");
        $stmt->bind_param("i", $id_docente);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function eliminar($id_desafio) {
        $stmt = $this->conn->prepare("DELETE FROM desafios WHERE id_desafio = ?");
        $stmt->bind_param("i", $id_desafio);
        return $stmt->execute();
    }

    public function actualizar(Desafio $desafio) {
        $stmt = $this->conn->prepare("UPDATE desafios SET titulo=?, descripcion=?, fecha_limite=?, id_curso=? WHERE id_desafio=?");

        $stmt->bind_param(
            "sssii",
            $desafio->getTitulo(),
            $desafio->getDescripcion(),
            $desafio->getFechaLimite(),
            $desafio->getIdCurso(),
            $desafio->getIdDesafio()
        );

        return $stmt->execute();
    }

    public function obtenerPorId($id_desafio) {
        $stmt = $this->conn->prepare("SELECT * FROM desafios WHERE id_desafio = ?");
        $stmt->bind_param("i", $id_desafio);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}