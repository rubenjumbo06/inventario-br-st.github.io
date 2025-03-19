<?php
include '../conexion.php';
$conexion = $conn;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'] ?? null;
    $tipo = $data['tipo'] ?? null;
    $ubicacion = $data['ubicacion'] ?? null;
    if ($tipo === 'herramienta' && $id !== null && $ubicacion !== null) {
        $sql = "UPDATE tbl_herramientas SET ubicacion_herramientas = ? WHERE id_herramientas = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("si", $ubicacion, $id);
        if ($stmt->execute()) {
            echo "Ubicación de herramientas actualizada.";
        } else {
            echo "Error en herramientas: " . $stmt->error;
        }
        $stmt->close();
    }
    if ($tipo === 'activo' && $id !== null && $ubicacion !== null) {
        $sql2 = "UPDATE tbl_activos SET ubicacion_activos = ? WHERE id_activos = ?";
        $stmt2 = $conexion->prepare($sql2);
        $stmt2->bind_param("si", $ubicacion, $id);
        if ($stmt2->execute()) {
            echo "Ubicación de activos actualizada.";
        } else {
            echo "Error en activos: " . $stmt2->error;
        }
        $stmt2->close();
    }
    $conexion->close();
}
?>