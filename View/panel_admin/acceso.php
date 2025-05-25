// acceso.php
<?php
require_once __DIR__ . '/../../Controller/Admin/AccesoController.php';

$controlador = new AccesoController();
$controlador->verAccesos();
