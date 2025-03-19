<?php
require_once("../conexion.php");

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if (isset($_GET['id_herramientas']) && is_numeric($_GET['id_herramientas'])) {
    $id_herramientas = intval($_GET['id_herramientas']);
    $sql = "SELECT * FROM tbl_herramientas WHERE id_herramientas = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_herramientas);
    $stmt->execute();
    $result = $stmt->get_result();
    $herramienta = $result->fetch_assoc();

    if (!$herramienta) {
        die("Herramienta no encontrada.");
    }
} else {
    die("ID inválido.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los valores del formulario
    $nombre_herramientas = $_POST['nombre_herramientas'] ?? null;
    $cantidad_herramientas = $_POST['cantidad_herramientas'] ?? null;
    $id_empresa = $_POST['id_empresa'] ?? null;
    $estado_herramientas = $_POST['estado_herramientas'] ?? null;
    $utilidad_herramientas = $_POST['utilidad_herramientas'] ?? null;
    $ubicacion_herramientas = $_POST['ubicacion_herramientas'] ?? null;

    // Construir la consulta SQL dinámicamente
    $sql = "UPDATE tbl_herramientas SET ";
    $params = [];
    $types = "";

    if (!empty($nombre_herramientas)) {
        $sql .= "nombre_herramientas=?, ";
        $params[] = $nombre_herramientas;
        $types .= "s";
    }
    if (!empty($cantidad_herramientas)) {
        $sql .= "cantidad_herramientas=?, ";
        $params[] = $cantidad_herramientas;
        $types .= "s"; // Es varchar en la tabla
    }
    if (!empty($id_empresa)) {
        $sql .= "id_empresa=?, ";
        $params[] = $id_empresa;
        $types .= "i";
    }
    if (!empty($estado_herramientas)) {
        $sql .= "estado_herramientas=?, ";
        $params[] = $estado_herramientas;
        $types .= "i";
    }
    if (!empty($utilidad_herramientas)) {
        $sql .= "utilidad_herramientas=?, ";
        $params[] = $utilidad_herramientas;
        $types .= "i";
    }
    if (!empty($ubicacion_herramientas)) {
        $sql .= "ubicacion_herramientas=?, ";
        $params[] = $ubicacion_herramientas;
        $types .= "s";
    }

    // Eliminar la última coma y espacio
    $sql = rtrim($sql, ", ");

    // Agregar la condición WHERE
    $sql .= " WHERE id_herramientas=?";
    $params[] = $id_herramientas;
    $types .= "i";

    // Preparar y ejecutar la consulta
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);

    if ($stmt->execute()) {
        echo "<script>window.location.href='../pages/herramientas.php';</script>";
    } else {
        echo "<script>alert('Error al actualizar la herramienta');</script>";
        echo $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Herramienta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/CSS/agg.css">
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">
    <div class="p-10 rounded-lg shadow-lg">
        <div class="flex flex-wrap gap-5 items-center w-full max-md:max-w-full mb-10">
            <div class="flex flex-wrap flex-1 shrink gap-5 items-center self-stretch my-auto basis-0 min-w-[240px] max-md:max-w-full">
                <div class="flex flex-col self-stretch my-auto min-w-[240px]">
                    <strong>
                        <div class="text-base text-[var(--verde-oscuro)]">Editar Herramienta</div>
                    </strong>
                    <div class="mt-2 text-sm text-[var(--verde-oscuro)]">
                        Editando tabla: Herramientas
                    </div>
                </div>
            </div>
        </div>

        <form method="POST">
            <div class="grid grid-cols-2 gap-6 mb-10">
                <!-- Nombre -->
                <div id="input" class="relative">
                    <input type="text" id="nombre_herramientas" name="nombre_herramientas" value="<?= htmlspecialchars($herramienta['nombre_herramientas']) ?>"
                        class="block w-full text-sm h-[50px] px-4 text-slate-900 bg-white rounded-[8px] border border-violet-200 appearance-none focus:border-transparent focus:outline focus:outline-primary focus:ring-0 hover:border-brand-500-secondary peer invalid:border-error-500 invalid:focus:border-error-500 overflow-ellipsis overflow-hidden text-nowrap pr-[48px]"
                        placeholder="Nombre"/>
                    <label for="nombre_herramientas"
                        class="peer-placeholder-shown:-z-10 peer-focus:z-10 absolute text-[14px] leading-[150%] text-primary peer-focus:text-primary peer-invalid:text-error-500 focus:invalid:text-error-500 duration-300 transform -translate-y-[1.2rem] scale-75 top-2 z-10 origin-[0] bg-white disabled:bg-gray-50-background- px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-[1.2rem] start-1">
                        Nombre
                    </label>
                </div>

                <!-- Cantidad -->
                <div id="input" class="relative">
                    <input type="text" id="cantidad_herramientas" name="cantidad_herramientas" value="<?= htmlspecialchars($herramienta['cantidad_herramientas']) ?>"
                        class="block w-full text-sm h-[50px] px-4 text-slate-900 bg-white rounded-[8px] border border-violet-200 appearance-none focus:border-transparent focus:outline focus:outline-primary focus:ring-0 hover:border-brand-500-secondary peer invalid:border-error-500 invalid:focus:border-error-500 overflow-ellipsis overflow-hidden text-nowrap pr-[48px]"
                        placeholder="Cantidad"/>
                    <label for="cantidad_herramientas"
                        class="peer-placeholder-shown:-z-10 peer-focus:z-10 absolute text-[14px] leading-[150%] text-primary peer-focus:text-primary peer-invalid:text-error-500 focus:invalid:text-error-500 duration-300 transform -translate-y-[1.2rem] scale-75 top-2 z-10 origin-[0] bg-white disabled:bg-gray-50-background- px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-[1.2rem] start-1">
                        Cantidad
                    </label>
                </div>

                <!-- Empresa -->
                <div id="input" class="relative">
                    <select name="id_empresa" id="empresa_select" class="block w-full text-sm h-[50px] px-4 text-slate-900 bg-white rounded-[8px] border border-violet-200 appearance-none focus:border-transparent focus:outline focus:outline-primary focus:ring-0 hover:border-brand-500-secondary peer invalid:border-error-500 invalid:focus:border-error-500 overflow-hidden pr-[48px]">
                        <option value="" disabled selected>Selecciona una Empresa</option>
                    </select>
                    <label for="id_empresa"
                        class="absolute text-[14px] leading-[150%] text-primary peer-focus:text-primary peer-invalid:text-error-500 focus:invalid:text-error-500 duration-300 transform -translate-y-[1.2rem] scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-[1.2rem] start-1">
                        Empresa
                    </label>
                </div>

                <!-- Estado -->
                <div id="input" class="relative">
                    <select name="estado_herramientas" id="estado_select" class="block w-full text-sm h-[50px] px-4 text-slate-900 bg-white rounded-[8px] border border-violet-200 appearance-none focus:border-transparent focus:outline focus:outline-primary focus:ring-0 hover:border-brand-500-secondary peer invalid:border-error-500 invalid:focus:border-error-500 overflow-hidden pr-[48px]">
                        <option value="" disabled selected>Selecciona un Estado</option>
                    </select>
                    <label for="estado_herramientas"
                        class="absolute text-[14px] leading-[150%] text-primary peer-focus:text-primary peer-invalid:text-error-500 focus:invalid:text-error-500 duration-300 transform -translate-y-[1.2rem] scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-[1.2rem] start-1">
                        Estado
                    </label>
                </div>

                <!-- Utilidad -->
                <div id="input" class="relative">
                    <select name="utilidad_herramientas" id="utilidad_select" class="block w-full text-sm h-[50px] px-4 text-slate-900 bg-white rounded-[8px] border border-violet-200 appearance-none focus:border-transparent focus:outline focus:outline-primary focus:ring-0 hover:border-brand-500-secondary peer invalid:border-error-500 invalid:focus:border-error-500 overflow-hidden pr-[48px]">
                        <option value="" disabled selected>Selecciona una Utilidad</option>
                    </select>
                    <label for="utilidad_herramientas"
                        class="absolute text-[14px] leading-[150%] text-primary peer-focus:text-primary peer-invalid:text-error-500 focus:invalid:text-error-500 duration-300 transform -translate-y-[1.2rem] scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-[1.2rem] start-1">
                        Utilidad
                    </label>
                </div>

                <!-- Ubicación -->
                <div id="input" class="relative">
                    <select name="ubicacion_herramientas" id="ubicacion_herramientas"
                        class="block w-full text-sm h-[50px] px-4 text-slate-900 bg-white rounded-[8px] border border-violet-200 appearance-none focus:border-transparent focus:outline focus:outline-primary focus:ring-0 hover:border-brand-500-secondary peer invalid:border-error-500 invalid:focus:border-error-500 overflow-hidden pr-[48px]">
                        <option value="" disabled selected>Selecciona una Ubicación</option>
                        <option value="En instalacion" <?= $herramienta['ubicacion_herramientas'] === 'En instalacion' ? 'selected' : '' ?>>En instalación</option>
                        <option value="En oficina" <?= $herramienta['ubicacion_herramientas'] === 'En oficina' ? 'selected' : '' ?>>En oficina</option>
                        <option value="En almacen" <?= $herramienta['ubicacion_herramientas'] === 'En almacen' ? 'selected' : '' ?>>En almacén</option>
                        <option value="Instalado" <?= $herramienta['ubicacion_herramientas'] === 'Instalado' ? 'selected' : '' ?>>Instalado</option>
                    </select>
                    <label for="ubicacion_herramientas"
                        class="absolute text-[14px] leading-[150%] text-primary peer-focus:text-primary peer-invalid:text-error-500 focus:invalid:text-error-500 duration-300 transform -translate-y-[1.2rem] scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-[1.2rem] start-1">
                        Ubicación
                    </label>
                </div>
            </div>

            <div class="sm:flex sm:flex-row-reverse flex gap-4">
                <!-- Botón Guardar -->
                <button type="submit"
                    class="w-fit rounded-lg text-sm px-6 py-3 h-[50px] border border-[var(--verde-oscuro)] bg-[var(--verde-claro)] text-white font-semibold shadow-md hover:bg-green-900 transition-all duration-300">
                    <div class="flex gap-2 items-center">Guardar</div>
                </button>
                <!-- Botón Cancelar -->
                <button type="reset"
                    class="w-fit rounded-lg text-sm px-6 py-3 h-[50px] border border-[var(--verde-oscuro)] text-[var(--verde-oscuro)] font-semibold shadow-md hover:bg-red-500 hover:text-white transition-all duration-300"
                    onclick="window.history.back();">
                    <div class="flex gap-2 items-center">Cancelar</div>
                </button>
            </div>
        </form>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        function cargarDatos(endpoint, selectId, selectedValue) {
            fetch(endpoint)
                .then(response => response.json())
                .then(data => {
                    if (!Array.isArray(data)) {
                        console.error("Error: Respuesta no válida", data);
                        return;
                    }
                    let select = document.getElementById(selectId);
                    let placeholderText = "";
                    switch (selectId) {
                        case "empresa_select":
                            placeholderText = "Selecciona una Empresa";
                            break;
                        case "estado_select":
                            placeholderText = "Selecciona un Estado";
                            break;
                        case "utilidad_select":
                            placeholderText = "Selecciona una Utilidad";
                            break;
                        default:
                            placeholderText = "Selecciona una opción";
                    }
                    select.innerHTML = `<option value="" disabled selected>${placeholderText}</option>`;

                    data.forEach(item => {
                        let option = document.createElement("option");
                        option.value = item.id_empresa || item.id_estado || item.id_utilidad;
                        option.textContent = item.nombre || item.nombre_estado || item.nombre_utilidad;
                        if (option.value == selectedValue) {
                            option.selected = true;
                        }
                        select.appendChild(option);
                    });
                })
                .catch(error => console.error("Error cargando los datos:", error));
        }

        cargarDatos("get_empresas.php", "empresa_select", "<?= $herramienta['id_empresa'] ?>");
        cargarDatos("get_estados.php", "estado_select", "<?= $herramienta['estado_herramientas'] ?>");
        cargarDatos("get_utilidades.php", "utilidad_select", "<?= $herramienta['utilidad_herramientas'] ?>");
    });
    </script>
</body>
</html>