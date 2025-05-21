<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'docente') {
    header('Location: ../../login.html');
    exit();
}

require_once __DIR__ . '/../../Model/Docente/EntregaModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_entrega = $_POST['id_entrega'];
    $calificacion = $_POST['calificacion'];
    $retroalimentacion = $_POST['retroalimentacion'];

    $model = new EntregaModel();
    $ok = $model->calificarEntrega($id_entrega, $calificacion, $retroalimentacion);

    if ($ok) {
        header("Location: ../../View/Panel_docente/calificaciones.php?ok=1");
    } else {
        echo "Error al guardar la calificación.";
    }
    exit();
}
?>
