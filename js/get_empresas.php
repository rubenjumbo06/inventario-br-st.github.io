<?php
include '../conexion.php';

$sql = "SELECT id_empresa, nombre FROM tbl_empresa";
$result = $conn->query($sql);

$empresa = [];
while ($row = $result->fetch_assoc()) {
    $empresa[] = $row;
}

echo json_encode($empresa);
?>
