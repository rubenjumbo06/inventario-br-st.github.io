<?php
require '../vendor/autoload.php';
require '../conexion.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

// Crear una nueva hoja de cálculo
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Definir encabezados y estilos
$encabezados = ['ID', 'Fecha Creación', 'Items', 'Titulo', 'Cuerpo', 'Usuario'];
$columnas = range('A', 'F');

// Aplicar estilos a los encabezados
$sheet->getStyle('A1:F1')->applyFromArray([
    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], // Letras blancas
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '0073E6']], // Fondo azul
    'alignment' => ['horizontal' => 'center', 'vertical' => 'center'] // Centrado
]);

// Insertar encabezados
foreach ($encabezados as $index => $nombre) {
    $sheet->setCellValue($columnas[$index] . '1', $nombre);
}

// Obtener datos de la BD
$sql = "SELECT * FROM tbl_reg_entradas";
$result = $conn->query($sql);
$fila = 2;

while ($row = $result->fetch_assoc()) {
    $sheet->setCellValue('A' . $fila, $row['id_entradas']);
    $sheet->setCellValue('B' . $fila, $row['fecha_creacion']);
    $sheet->setCellValue('C' . $fila, $row['items']);
    $sheet->setCellValue('D' . $fila, $row['titulo']);
    $sheet->setCellValue('E' . $fila, $row['body']);
    $sheet->setCellValue('F' . $fila, $row['id_user']);
    $fila++;
}

// Aplicar bordes a la tabla
$ultimaFila = $fila - 1;
$sheet->getStyle("A1:F$ultimaFila")->applyFromArray([
    'borders' => [
        'allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']]
    ]
]);

// Ajustar tamaño automático de las columnas
foreach ($columnas as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Descargar el archivo Excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="reporte_entradas.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
