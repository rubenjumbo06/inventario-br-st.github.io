<?php
include '../conexion.php'; // Ajusta la ruta según la ubicación real
$conexion = $conn;
$sql = "SELECT id_h, nombre_herramientas, ubi_herramientas FROM tbl_herramientas";
$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de salidas</title>
    <link rel="stylesheet" href="assets/CSS/reg_sal.css">
    <style>
        .parent {
            display: grid;
            grid-template-columns: repeat(8, 1fr);
            grid-template-rows: repeat(10, 1fr);
            gap: 2px;
        }
        .div1 { grid-column: span 2 / span 2; grid-row: span 4 / span 4; grid-column-start: 3; grid-row-start: 2; }
        .div2 { grid-column: span 2 / span 2; grid-row: span 4 / span 4; grid-column-start: 6; grid-row-start: 2; }
        .div3 { grid-column: span 2 / span 2; grid-row: span 3 / span 3; grid-column-start: 3; grid-row-start: 7; }
        .div4 { grid-column: span 2 / span 2; grid-row: span 2 / span 2; grid-column-start: 6; grid-row-start: 7; }
        .div5 { grid-column-start: 5; grid-row-start: 10; }
    </style>
    <script>
        function actualizarUbicacion(id_h, checked) {
            let nuevaUbicacion = checked ? 'campo' : 'almacen';
            fetch('actualizar_ubicacion.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `id_h=${id_h}&ubi_herramientas=${nuevaUbicacion}`
            })
            .then(response => response.text())
            .then(data => {
                console.log(data);
                location.reload();
            })
            .catch(error => console.error("Error:", error));
        }
    </script>
</head>
<body class="bg-[var(--beige)]">
    <?php include 'header.php'; ?>
    <div class="parent">
        <strong><h1 class="text-xl font-bold text-shadow text-white">Registro de salidas</h1></strong>
        <div class="div1">
            <h3 class="mb-4 font-semibold text-gray-900 dark:text-white text-shadow">Herramientas Disponibles</h3>
            <ul class="w-64 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                <?php while ($fila = $resultado->fetch_assoc()): ?>
                    <li class="w-full border-b border-gray-200 rounded-t-lg dark:border-gray-600">
                        <div class="flex items-center ps-3">
                            <input type="checkbox"
                                id="herramienta-<?php echo $fila['id_h']; ?>"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500"
                                onchange="actualizarUbicacion(<?php echo $fila['id_h']; ?>, this.checked)"
                                <?php echo ($fila['ubi_herramientas'] == 'campo') ? 'checked' : ''; ?>>
                            <label for="herramienta-<?php echo $fila['id_h']; ?>" 
                                class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                <?php echo $fila['nombre_herramientas']; ?>
                            </label>
                        </div>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>
        <div class="div2">2</div>
        <div class="div3">3</div>
        <div class="div4">4</div>
        <div class="div5">5</div>
    </div>
</body>
</html>
<?php $conexion->close(); ?>
