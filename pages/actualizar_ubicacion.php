<?php
include '../conexion.php'; // Asegúrate de que la ruta sea correcta
$conexion = $conn;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_h = $_POST['id_h'];
    $ubi_herramientas = $_POST['ubi_herramientas']; // 'almacen' o 'campo'

    $sql = "UPDATE tbl_herramientas SET ubi_herramientas = ? WHERE id_h = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("si", $ubi_herramientas, $id_h);

    if ($stmt->execute()) {
        echo "Ubicación actualizada correctamente.";
    } else {
        echo "Error al actualizar ubicación: " . $stmt->error;
    }

    $stmt->close();
    $conexion->close();
}
?>
