<?php
require_once __DIR__ . '/../../Model/Admin/AccesoModel.php';

class AccesoController {
    private $modelo;

    public function __construct() {
        $this->modelo = new AccesoModel();
    }

    public function verAccesos() {
        $accesos = $this->modelo->obtenerAccesos();
        require_once __DIR__ . '/../../View/panel_admin/ver_accesos.php';
    }
}
