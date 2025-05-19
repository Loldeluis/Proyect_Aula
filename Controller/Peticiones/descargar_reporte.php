<?php
require('../../libs/fpdf.php');
require_once __DIR__ . '/../../Model/utilidades/bd/ConexionBD.php';

$conexion = new ConexionBD();
$conn = $conexion->conectar();


$tipo = $_GET['tipo'] ?? null;
$id = $_GET['id'] ?? null;

if ($tipo === 'estudiante' && $id) {
    $sql = "SELECT e.id_entrega, d.titulo, u.nombre_usuario AS estudiante, e.calificacion, e.retroalimentacion
            FROM entregas_desafios e
            JOIN desafios d ON e.id_desafio = d.id_desafio
            JOIN usuarios u ON e.id_estudiante = u.id_usuario
            WHERE e.id_estudiante = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
} elseif ($tipo === 'curso' && $id) {
    $sql = "SELECT e.id_entrega, d.titulo, u.nombre_usuario AS estudiante, c.nombre AS curso, e.calificacion, e.retroalimentacion
            FROM entregas_desafios e
            JOIN desafios d ON e.id_desafio = d.id_desafio
            JOIN cursos c ON d.id_curso = c.id_curso
            JOIN usuarios u ON e.id_estudiante = u.id_usuario
            WHERE c.id_curso = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
} elseif ($tipo === 'general') {
    $sql = "SELECT e.id_entrega, d.titulo, u.nombre_usuario AS estudiante, c.nombre AS curso, e.calificacion, e.retroalimentacion
            FROM entregas_desafios e
            JOIN desafios d ON e.id_desafio = d.id_desafio
            JOIN cursos c ON d.id_curso = c.id_curso
            JOIN usuarios u ON e.id_estudiante = u.id_usuario";
    $stmt = mysqli_prepare($conn, $sql);
} else {
    die("Parametros inválidos.");
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'Reporte de Desempeno', 0, 1, 'C');
        $this->Ln(5);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo(), 0, 0, 'C');
    }

    function FancyTable($header, $data) {
        $this->SetFillColor(200, 220, 255);
        $this->SetTextColor(0);
        $this->SetDrawColor(180, 180, 180);
        $this->SetLineWidth(.3);
        $this->SetFont('Arial', 'B', 10);
        
        foreach ($header as $col) {
            $this->Cell(38, 7, $col, 1, 0, 'C', true);
        }
        $this->Ln();

        $this->SetFont('Arial', '', 9);
        foreach ($data as $row) {
            foreach ($row as $col) {
                $texto = mb_convert_encoding($col, 'ISO-8859-1', 'UTF-8');
                $this->Cell(38, 6, substr($texto, 0, 35), 1);
            }
            $this->Ln();
        }
    }
}

$pdf = new PDF('L');
$pdf->AddPage();

if (mysqli_num_rows($result) > 0) {
    $header = array_keys(mysqli_fetch_assoc($result));
    mysqli_data_seek($result, 0);
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    $pdf->FancyTable($header, $data);
} else {
    $pdf->SetFont('Arial', 'I', 12);
    $pdf->Cell(0, 10, 'No hay resultados.', 0, 1, 'C');
}

$pdf->Output();
exit;
?>
<a href="descargar_reporte.php?tipo=<?php echo urlencode($tipo); ?>&id=<?php echo $_GET['id'] ?? ''; ?>" class="btn">Descargar PDF</a>
