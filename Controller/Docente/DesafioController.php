<?php
require_once '../../Model/Docente/DesafioModel.php';   // Modelo

class DesafioController {
    private $modelo;

    public function __construct() {
        $this->modelo = new DesafioModel();
    }

        public function asignarDesafio($data) {
        $desafio = new Desafio();
        $desafio->setTitulo(trim($data['titulo']));
        $desafio->setDescripcion(trim($data['descripcion']));
        $desafio->setFechaLimite($data['fecha_limite']);
        $desafio->setIdCurso($data['id_curso']);
        $desafio->setIdDocente($data['id_docente']);

        return $this->modelo->guardar($desafio);
    }

    public function obtenerDesafiosPorDocente($id_docente) {
        return $this->modelo->obtenerPorDocente($id_docente);
    }

    public function eliminarDesafio($id_desafio) {
        return $this->modelo->eliminar($id_desafio);
    }

    public function obtenerDesafio($id_desafio) {
        return $this->modelo->obtenerPorId($id_desafio);
    }

    public function actualizarDesafio($desafio) {
        return $this->modelo->actualizar($desafio);
    }

    public function guardarDesafio($desafio) {
        return $this->modelo->guardar($desafio);
    }
}