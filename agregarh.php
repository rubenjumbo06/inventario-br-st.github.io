<?php
include 'conexion.php';

// Inicializar variables del formulario
$nombre_herramientas = $cantidad_herramientas = $id_empresa = $estado_herramientas = $utilidad_herramientas = $ubicacion_herramientas = "";
$mensaje = "";

// Procesar el formulario cuando se envíe
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_herramientas = htmlspecialchars($_POST['nombre_herramientas']);
    $cantidad_herramientas = htmlspecialchars($_POST['cantidad_herramientas']);
    $id_empresa = intval($_POST['id_empresa']); // Guardar ID
    $estado_herramientas = intval($_POST['estado_herramientas']); // Guardar ID
    $utilidad_herramientas = intval($_POST['utilidad_herramientas']); // Guardar ID
    $ubicacion_herramientas = htmlspecialchars($_POST['ubicacion_herramientas']);

    if (!empty($nombre_herramientas) && !empty($cantidad_herramientas) && !empty($id_empresa) && !empty($estado_herramientas) && !empty($utilidad_herramientas) && !empty($ubicacion_herramientas)) {
        $sql = "INSERT INTO tbl_herramientas (nombre_herramientas, cantidad_herramientas, id_empresa, estado_herramientas, utilidad_herramientas, ubicacion_herramientas) VALUES (?, ?, ?, ?, ?, ?)";
        
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("siisss", $nombre_herramientas, $cantidad_herramientas, $id_empresa, $estado_herramientas, $utilidad_herramientas, $ubicacion_herramientas);
            if ($stmt->execute()) {
                $mensaje = "¡Datos guardados correctamente!";
            } else {
                $mensaje = "Error al guardar los datos: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $mensaje = "Error al preparar la consulta: " . $conn->error;
        }
    } else {
        $mensaje = "Todos los campos son obligatorios.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Herramienta</title>
</head>
<body>

<?php if (!empty($mensaje)) { echo "<p>$mensaje</p>"; } ?>

<form action="agregarh.php" method="POST">
    <label>Nombre de la Herramienta:</label>
    <input type="text" name="nombre_herramientas" required>

    <label>Cantidad:</label>
    <input type="number" name="cantidad_herramientas" required>

    <label>Empresa:</label>
    <select name="id_empresa" id="empresa_select" required>
        <option value="" disabled selected>Selecciona una Empresa</option>
    </select>

    <label>Estado:</label>
    <select name="estado_herramientas" id="estado_select" required>
        <option value="" disabled selected>Selecciona un Estado</option>
    </select>

    <label>Utilidad:</label>
    <select name="utilidad_herramientas" id="utilidad_select" required>
        <option value="" disabled selected>Selecciona una Utilidad</option>
    </select>

    <label>Ubicación:</label>
    <input type="text" name="ubicacion_herramientas" required>

    <button type="submit">Guardar</button>
</form>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        function cargarDatos(endpoint, selectId) {
            fetch(endpoint)
                .then(response => response.json())
                .then(data => {
                    let select = document.getElementById(selectId);
                    data.forEach(item => {
                        let option = document.createElement("option");
                        option.value = item.id_empresa || item.id_estado || item.id_utilidad;
                        option.textContent = item.nombre || item.nombre_estado || item.nombre_utilidad;
                        select.appendChild(option);
                    });
                })
                .catch(error => console.error("Error cargando los datos:", error));
        }

        cargarDatos("get_empresas.php", "empresa_select");
        cargarDatos("get_estados.php", "estado_select");
        cargarDatos("get_utilidades.php", "utilidad_select");
    });
</script>

</body>
</html>
