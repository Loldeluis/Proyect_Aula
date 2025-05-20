<?php
require_once '../../Model/Docente/DesafioModel.php';   // Modelo


class DesafioController {
    private $model;

    public function __construct() {
        $this->model = new DesafioModel();
    }

    public function asignarDesafio($data) {
        $desafio = new Desafio();
        $desafio->setTitulo(trim($data['titulo']));
        $desafio->setDescripcion(trim($data['descripcion']));
        $desafio->setFechaLimite($data['fecha_limite']);
        $desafio->setIdCurso($data['id_curso']);
        $desafio->setIdDocente($data['id_docente']);

        return $this->model->guardar($desafio);
    }
}