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

    $titulo = $desafio->getTitulo();
    $descripcion = $desafio->getDescripcion();
    $fecha_limite = $desafio->getFechaLimite();
    $id_curso = $desafio->getIdCurso();
    $id_docente = $desafio->getIdDocente();

    $stmt->bind_param(
        "sssii",
        $titulo,
        $descripcion,
        $fecha_limite,
        $id_curso,
        $id_docente
    );

    return $stmt->execute();
}

}
