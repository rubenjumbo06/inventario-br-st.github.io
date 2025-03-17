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
$encabezados = ['ID', 'Nombre', 'Cantidad', 'Empresa', 'Estado', 'Utilidad', 'Ubicacion', 'Ingreso'];
$columnas = range('A', 'H');

// Aplicar estilos a los encabezados
$sheet->getStyle('A1:H1')->applyFromArray([
    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], // Letras blancas
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '0073E6']], // Fondo azul
    'alignment' => ['horizontal' => 'center', 'vertical' => 'center'] // Centrado
]);

// Insertar encabezados
foreach ($encabezados as $index => $nombre) {
    $sheet->setCellValue($columnas[$index] . '1', $nombre);
}

// Obtener datos de la BD
$sql = "SELECT * FROM tbl_herramientas";
$result = $conn->query($sql);
$fila = 2;

while ($row = $result->fetch_assoc()) {
    $sheet->setCellValue('A' . $fila, $row['id_herramientas']);
    $sheet->setCellValue('B' . $fila, $row['nombre_herramientas']);
    $sheet->setCellValue('C' . $fila, $row['cantidad_herramientas']);
    $sheet->setCellValue('D' . $fila, $row['id_empresa']);
    $sheet->setCellValue('E' . $fila, $row['estado_herramientas']);
    $sheet->setCellValue('F' . $fila, $row['utilidad_herramientas']);
    $sheet->setCellValue('G' . $fila, $row['ubicacion_herramientas']);
    $sheet->setCellValue('H' . $fila, $row['fecha_ingreso']);
    $fila++;
}

// Aplicar bordes a la tabla
$ultimaFila = $fila - 1;
$sheet->getStyle("A1:H$ultimaFila")->applyFromArray([
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
header('Content-Disposition: attachment; filename="reporte_herramientas.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
