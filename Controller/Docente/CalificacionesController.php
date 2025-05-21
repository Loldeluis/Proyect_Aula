<?php
require_once __DIR__ . '/../model/EntregaModel.php';

class CalificacionesController {

    public function mostrarCalificaciones() {
        session_start();
        
        // Asegúrate de que el docente haya iniciado sesión
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'docente') {
            header("Location: ../index.php");
            exit();
        }

        $id_docente = $_SESSION['usuario']['id_usuario'];

        // Cargar las entregas del docente desde el modelo
        $entregaModel = new EntregaModel();
        $entregas = $entregaModel->obtenerEntregasPorDocente($id_docente);

        include __DIR__ . '/../view/docente/calificaciones.php';
    }

    public function guardarCalificacion() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_entrega = $_POST['id_entrega'];
            $calificacion = $_POST['calificacion'];
            $retroalimentacion = $_POST['retroalimentacion'];

            // Validaciones mínimas
            if (is_numeric($calificacion) && $calificacion >= 0 && $calificacion <= 5) {
                $entregaModel = new EntregaModel();
                $entregaModel->guardarCalificacion($id_entrega, $calificacion, $retroalimentacion);
            }
        }

        // Redirigir nuevamente a la vista de calificaciones para mostrar cambios
        header("Location: index.php?controlador=calificaciones&accion=mostrarCalificaciones");
        exit();
    }
}
