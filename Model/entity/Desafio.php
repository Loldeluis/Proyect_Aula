<?php
class Desafio {
    private $id, $titulo, $descripcion, $fecha_limite, $id_curso, $id_docente;

    public function getId() { return $this->id; }
    public function getTitulo() { return $this->titulo; }
    public function getDescripcion() { return $this->descripcion; }
    public function getFechaLimite() { return $this->fecha_limite; }
    public function getIdCurso() { return $this->id_curso; }
    public function getIdDocente() { return $this->id_docente; }

    public function setId($id) { $this->id = $id; }
    public function setTitulo($titulo) { $this->titulo = $titulo; }
    public function setDescripcion($descripcion) { $this->descripcion = $descripcion; }
    public function setFechaLimite($fecha_limite) { $this->fecha_limite = $fecha_limite; }
    public function setIdCurso($id_curso) { $this->id_curso = $id_curso; }
    public function setIdDocente($id_docente) { $this->id_docente = $id_docente; }
}
