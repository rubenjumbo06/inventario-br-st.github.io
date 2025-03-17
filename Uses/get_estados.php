<?php
include '../conexion.php';

$sql = "SELECT id_estado, nombre_estado FROM tbl_estados";
$result = $conn->query($sql);

$estados = [];
while ($row = $result->fetch_assoc()) {
    $estados[] = $row;
}

echo json_encode($estados);
?>
