<?php
$nombre_archivo = $_GET['nombre'] ?? '';

if ($nombre_archivo) {
    $ruta = "../archivos_entregas/" . basename($nombre_archivo); // ajusta si tu ruta es diferente

    if (file_exists($ruta)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($ruta) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($ruta));
        readfile($ruta);
        exit();
    } else {
        echo "Archivo no encontrado.";
    }
} else {
    echo "Nombre de archivo no especificado.";
}
?>
