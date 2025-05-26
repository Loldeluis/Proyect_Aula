<?php
require_once __DIR__ . '/../../Model/Estudiante/CalificacionModel.php';

class CalificacionController {
    private $model;

    public function __construct() {
        $this->model = new CalificacionModel();
    }

    public function verCalificaciones($id_estudiante) {
        return $this->model->obtenerCalificacionesPorEstudiante($id_estudiante);
    }
}
