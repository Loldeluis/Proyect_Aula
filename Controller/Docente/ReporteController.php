<?php
require_once __DIR__ . '/../../Model/Docente/ReporteModel.php';

class ReporteController {
    private $modelo;

    public function __construct() {
        $this->modelo = new ReporteModel();
    }

    public function manejarReporte($tipo, $id = null) {
        switch ($tipo) {
            case 'estudiante':
                return $this->modelo->obtenerPorEstudiante((int)$id);
            case 'curso':
                return $this->modelo->obtenerPorCurso((int)$id);
            case 'general':
                return $this->modelo->obtenerGeneral();
            default:
                return [];
        }
    }

    public function obtenerEstudiantes() {
        return $this->modelo->obtenerEstudiantes();
    }

    public function obtenerCursos() {
        return $this->modelo->obtenerCursos();
    }
}
