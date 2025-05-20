<?php
require_once 'utilidades/bd/ConexionBD.php';
require_once 'entity/Desafio.php';

class DesafioModel {
    private $conn;

    public function __construct() {
        $this->conn = (new ConexionBD())->conectar();
    }

    public function guardarDesafio(Desafio $desafio) {
        $stmt = $this->conn->prepare("INSERT INTO desafíos (titulo, descripcion, fecha_limite, id_docente) VALUES (?, ?, ?, ?)");
        $stmt->bind_param(
            "sssi",
            $desafio->getTitulo(),
            $desafio->getDescripcion(),
            $desafio->getFechaLimite(),
            $desafio->getIdDocente()
        );
        return $stmt->execute();
    }

    public function obtenerDesafiosPorDocente($id_docente) {
        $stmt = $this->conn->prepare("SELECT * FROM desafíos WHERE id_docente = ?");
        $stmt->bind_param("i", $id_docente);
        $stmt->execute();
        $result = $stmt->get_result();

        $desafios = [];
        while ($row = $result->fetch_assoc()) {
            $desafio = new Desafio();
            $desafio->setId($row['id_desafio']);
            $desafio->setTitulo($row['titulo']);
            $desafio->setDescripcion($row['descripcion']);
            $desafio->setFechaLimite($row['fecha_limite']);
            $desafio->setIdDocente($row['id_docente']);
            $desafios[] = $desafio;
        }
        return $desafios;
    }

    public function obtenerDesafioPorId($id_desafio) {
        $stmt = $this->conn->prepare("SELECT * FROM desafíos WHERE id_desafio = ?");
        $stmt->bind_param("i", $id_desafio);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $desafio = new Desafio();
            $desafio->setId($row['id_desafio']);
            $desafio->setTitulo($row['titulo']);
            $desafio->setDescripcion($row['descripcion']);
            $desafio->setFechaLimite($row['fecha_limite']);
            $desafio->setIdDocente($row['id_docente']);
            return $desafio;
        }
        return null;
    }

    public function actualizarDesafio(Desafio $desafio) {
        $stmt = $this->conn->prepare("UPDATE desafíos SET titulo = ?, descripcion = ?, fecha_limite = ? WHERE id_desafio = ?");
        $stmt->bind_param(
            "sssi",
            $desafio->getTitulo(),
            $desafio->getDescripcion(),
            $desafio->getFechaLimite(),
            $desafio->getId()
        );
        return $stmt->execute();
    }

    public function eliminarDesafio($id_desafio) {
        $stmt = $this->conn->prepare("DELETE FROM desafíos WHERE id_desafio = ?");
        $stmt->bind_param("i", $id_desafio);
        return $stmt->execute();
    }
}
