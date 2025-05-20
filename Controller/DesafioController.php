<?php
require_once '/../Model/Desafio.php';      // Modelo
require_once '/../Model/entity/Desafio.php';  // Entidad

class DesafioController {

    private $modelo;

    public function __construct() {
        $this->modelo = new DesafioModel();
    }

    public function asignar($titulo, $descripcion, $fecha_limite, $id_docente) {
        $desafio = new Desafio();
        $desafio->setTitulo($titulo);
        $desafio->setDescripcion($descripcion);
        $desafio->setFechaLimite($fecha_limite);
        $desafio->setIdDocente($id_docente);

        return $this->modelo->guardarDesafio($desafio);
    }

    public function obtenerDesafiosPorDocente($id_docente) {
        return $this->modelo->obtenerDesafiosPorDocente($id_docente);
    }

    public function actualizarDesafio($id_desafio, $titulo, $descripcion, $fecha_limite) {
        $desafio = $this->modelo->obtenerDesafioPorId($id_desafio);
        if ($desafio) {
            $desafio->setTitulo($titulo);
            $desafio->setDescripcion($descripcion);
            $desafio->setFechaLimite($fecha_limite);
            return $this->modelo->actualizarDesafio($desafio);
        }
        return false;
    }

    public function eliminarDesafio($id_desafio) {
        return $this->modelo->eliminarDesafio($id_desafio);
    }
}
