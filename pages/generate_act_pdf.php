<?php
require('../fpdf/fpdf.php');
require('../conexion.php'); // Asegúrate de que el archivo conexion.php está en la misma carpeta

// Si se presiona el botón, generar el PDF
if (isset($_POST['generar_pdf'])) {
    class PDF extends FPDF {
        function Header() {
            $this->SetFont('Arial', 'B', 14);
            $this->Cell(0, 10, 'Reporte de Activos', 0, 1, 'C');
            $this->Ln(5);
        }
        function Footer() {
            $this->SetY(-15);
            $this->SetFont('Arial', 'I', 8);
            $this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
        }
    }

    $pdf = new PDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 10);
    
    // Encabezados de la tabla
    $pdf->Cell(15, 10, 'ID', 1);
    $pdf->Cell(30, 10, 'Nombre', 1);
    $pdf->Cell(15, 10, 'Cant.', 1);
    $pdf->Cell(15, 10, 'Estado', 1);
    $pdf->Cell(15, 10, 'Emp', 1);
    $pdf->Cell(30, 10, 'IP', 1);
    $pdf->Cell(40, 10, 'MAC', 1);
    $pdf->Cell(30, 10, 'SN', 1);
    $pdf->Cell(40, 10, 'Ingreso', 1);
    $pdf->Ln();

    // Obtener datos de la base de datos
    $sql = "SELECT * FROM tbl_act";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(15, 10, $row['id_act'], 1);
        $pdf->Cell(30, 10, utf8_decode($row['nm_act']), 1);
        $pdf->Cell(15, 10, $row['cant_act'], 1);
        $pdf->Cell(15, 10, $row['est_act'], 1);
        $pdf->Cell(15, 10, $row['emp'], 1);
        $pdf->Cell(30, 10, $row['ip'], 1);
        $pdf->Cell(40, 10, $row['mac'], 1);
        $pdf->Cell(30, 10, $row['sn'], 1);
        $pdf->Cell(40, 10, $row['ingr_at'], 1);
        $pdf->Ln();
    }

    $pdf->Output();
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar PDF</title>
</head>
<body>
    <h2>Generar PDF de Activos</h2>
    <form method="post">
        <button type="submit" name="generar_pdf">Generar PDF</button>
    </form>
</body>
</html>
