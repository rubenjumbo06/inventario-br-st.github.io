<?php
require_once("../conexion.php");

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if (isset($_GET['id_consumibles']) && is_numeric($_GET['id_consumibles'])) {
    $id_consumibles = intval($_GET['id_consumibles']);
    $sql = "SELECT * FROM tbl_consumibles WHERE id_consumibles = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_consumibles);
    $stmt->execute();
    $result = $stmt->get_result();
    $consumible = $result->fetch_assoc();

    if (!$consumible) {
        die("Consumible no encontrado.");
    }
} else {
    die("ID inválido.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los valores del formulario
    $nombre_consumibles = $_POST['nombre_consumibles'] ?? null;
    $cantidad_consumibles = $_POST['cantidad_consumibles'] ?? null;
    $id_empresa = $_POST['id_empresa'] ?? null;
    $estado_consumibles = $_POST['estado_consumibles'] ?? null;
    $utilidad_consumibles = $_POST['utilidad_consumibles'] ?? null;
    $id_user = $_POST['id_user'] ?? null;

    // Construir la consulta SQL dinámicamente
    $sql = "UPDATE tbl_consumibles SET ";
    $params = [];
    $types = "";

    if (!empty($nombre_consumibles)) {
        $sql .= "nombre_consumibles=?, ";
        $params[] = $nombre_consumibles;
        $types .= "s";
    }
    if (!empty($cantidad_consumibles)) {
        $sql .= "cantidad_consumibles=?, ";
        $params[] = $cantidad_consumibles;
        $types .= "i";
    }
    if (!empty($id_empresa)) {
        $sql .= "id_empresa=?, ";
        $params[] = $id_empresa;
        $types .= "i";
    }
    if (!empty($estado_consumibles)) {
        $sql .= "estado_consumibles=?, ";
        $params[] = $estado_consumibles;
        $types .= "i";
    }
    if (!empty($utilidad_consumibles)) {
        $sql .= "utilidad_consumibles=?, ";
        $params[] = $utilidad_consumibles;
        $types .= "s";
    }
    if (!empty($id_user)) {
        $sql .= "id_user=?, ";
        $params[] = $id_user;
        $types .= "i";
    }

    // Si no hay campos para actualizar
    if (empty($params)) {
        echo "<script>alert('No se realizaron cambios'); window.location.href='../pages/consumibles.php';</script>";
        exit();
    }

    // Eliminar la última coma y espacio
    $sql = rtrim($sql, ", ");
    $sql .= " WHERE id_consumibles=?";
    $params[] = $id_consumibles;
    $types .= "i";

    // Preparar y ejecutar la consulta
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);

    if ($stmt->execute()) {
        echo "<script>window.location.href='../pages/consumibles.php';</script>";
    } else {
        echo "<script>alert('Error al actualizar el consumible: " . $stmt->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Consumible</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/CSS/agg.css">
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">
    <div class="p-10 rounded-lg shadow-lg">
        <div class="flex flex-wrap gap-5 items-center w-full max-md:max-w-full mb-10">
            <div class="flex flex-wrap flex-1 shrink gap-5 items-center self-stretch my-auto basis-0 min-w-[240px] max-md:max-w-full">
                <div class="flex flex-col self-stretch my-auto min-w-[240px]">
                    <strong>
                        <div class="text-base text-[var(--verde-oscuro)]">Editar Consumible</div>
                    </strong>
                    <div class="mt-2 text-sm text-[var(--verde-oscuro)]">
                        Editando tabla: Consumibles (ID: <?php echo $id_consumibles; ?>)
                    </div>
                </div>
            </div>
        </div>

        <form method="POST">
            <div class="grid grid-cols-2 gap-6 mb-10">
                <!-- Nombre -->
                <div id="input" class="relative">
                    <input type="text" id="nombre_consumibles" name="nombre_consumibles" value="<?php echo htmlspecialchars($consumible['nombre_consumibles']); ?>"
                        class="block w-full text-sm h-[50px] px-4 text-slate-900 bg-white rounded-[8px] border border-violet-200 appearance-none focus:border-transparent focus:outline focus:outline-primary focus:ring-0 hover:border-brand-500-secondary peer invalid:border-error-500 invalid:focus:border-error-500 overflow-ellipsis overflow-hidden text-nowrap pr-[48px]"
                        placeholder="Nombre"/>
                    <label for="nombre_consumibles"
                        class="peer-placeholder-shown:-z-10 peer-focus:z-10 absolute text-[14px] leading-[150%] text-primary peer-focus:text-primary peer-invalid:text-error-500 focus:invalid:text-error-500 duration-300 transform -translate-y-[1.2rem] scale-75 top-2 z-10 origin-[0] bg-white disabled:bg-gray-50-background- px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-[1.2rem] rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">
                        Nombre
                    </label>
                </div>

                <!-- Cantidad -->
                <div id="input" class="relative">
                    <input type="number" id="cantidad_consumibles" name="cantidad_consumibles" value="<?php echo htmlspecialchars($consumible['cantidad_consumibles']); ?>"
                        class="block w-full text-sm h-[50px] px-4 text-slate-900 bg-white rounded-[8px] border border-violet-200 appearance-none focus:border-transparent focus:outline focus:outline-primary focus:ring-0 hover:border-brand-500-secondary peer invalid:border-error-500 invalid:focus:border-error-500 overflow-ellipsis overflow-hidden text-nowrap pr-[48px]"
                        placeholder="Cantidad"/>
                    <label for="cantidad_consumibles"
                        class="peer-placeholder-shown:-z-10 peer-focus:z-10 absolute text-[14px] leading-[150%] text-primary peer-focus:text-primary peer-invalid:text-error-500 focus:invalid:text-error-500 duration-300 transform -translate-y-[1.2rem] scale-75 top-2 z-10 origin-[0] bg-white disabled:bg-gray-50-background- px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-[1.2rem] rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">
                        Cantidad
                    </label>
                </div>

                <!-- Empresa -->
                <div id="input" class="relative">
                    <select name="id_empresa" id="empresa_select" class="block w-full text-sm h-[50px] px-4 text-slate-900 bg-white rounded-[8px] border border-violet-200 appearance-none focus:border-transparent focus:outline focus:outline-primary focus:ring-0 hover:border-brand-500-secondary peer invalid:border-error-500 invalid:focus:border-error-500 overflow-hidden pr-[48px]">
                        <option value="" disabled>Selecciona una Empresa</option>
                        <!-- Opciones se cargan dinámicamente con JavaScript -->
                    </select>
                    <label for="id_empresa"
                        class="absolute text-[14px] leading-[150%] text-primary peer-focus:text-primary peer-invalid:text-error-500 focus:invalid:text-error-500 duration-300 transform -translate-y-[1.2rem] scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-[1.2rem] start-1">
                        Empresa
                    </label>
                </div>

                <!-- Estado -->
                <div id="input" class="relative">
                    <select name="estado_consumibles" id="estado_select" class="block w-full text-sm h-[50px] px-4 text-slate-900 bg-white rounded-[8px] border border-violet-200 appearance-none focus:border-transparent focus:outline focus:outline-primary focus:ring-0 hover:border-brand-500-secondary peer invalid:border-error-500 invalid:focus:border-error-500 overflow-hidden pr-[48px]">
                        <option value="" disabled>Selecciona un Estado</option>
                        <!-- Opciones se cargan dinámicamente con JavaScript -->
                    </select>
                    <label for="estado_consumibles"
                        class="absolute text-[14px] leading-[150%] text-primary peer-focus:text-primary peer-invalid:text-error-500 focus:invalid:text-error-500 duration-300 transform -translate-y-[1.2rem] scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-[1.2rem] start-1">
                        Estado
                    </label>
                </div>

                <!-- Utilidad -->
                <div id="input" class="relative">
                    <select name="utilidad_consumibles" id="utilidad_select" class="block w-full text-sm h-[50px] px-4 text-slate-900 bg-white rounded-[8px] border border-violet-200 appearance-none focus:border-transparent focus:outline focus:outline-primary focus:ring-0 hover:border-brand-500-secondary peer invalid:border-error-500 invalid:focus:border-error-500 overflow-hidden pr-[48px]">
                        <option value="" disabled>Selecciona una Utilidad</option>
                        <!-- Opciones se cargan dinámicamente con JavaScript -->
                    </select>
                    <label for="utilidad_consumibles"
                        class="absolute text-[14px] leading-[150%] text-primary peer-focus:text-primary peer-invalid:text-error-500 focus:invalid:text-error-500 duration-300 transform -translate-y-[1.2rem] scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-[1.2rem] start-1">
                        Utilidad
                    </label>
                </div>

                <!-- User -->
                <div id="input" class="relative">
                    <select name="id_user" id="users_select" class="block w-full text-sm h-[50px] px-4 text-slate-900 bg-white rounded-[8px] border border-violet-200 appearance-none focus:border-transparent focus:outline focus:outline-primary focus:ring-0 hover:border-brand-500-secondary peer invalid:border-error-500 invalid:focus:border-error-500 overflow-hidden pr-[48px]">
                        <option value="" disabled>Selecciona un Usuario</option>
                        <!-- Opciones se cargan dinámicamente con JavaScript -->
                    </select>
                    <label for="id_user"
                        class="absolute text-[14px] leading-[150%] text-primary peer-focus:text-primary peer-invalid:text-error-500 focus:invalid:text-error-500 duration-300 transform -translate-y-[1.2rem] scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-[1.2rem] start-1">
                        Usuario
                    </label>
                </div>
            </div>

            <div class="sm:flex sm:flex-row-reverse flex gap-4">
                <!-- Botón Guardar -->
                <button type="submit"
                    class="w-fit rounded-lg text-sm px-6 py-3 h-[50px] border border-[var(--verde-oscuro)] bg-[var(--verde-claro)] text-white font-semibold shadow-md hover:bg-green-900 transition-all duration-300">
                    <div class="flex gap-2 items-center">Actualizar</div>
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
        // Obtener los valores actuales del consumible desde PHP
        const idEmpresaActual = "<?php echo $consumible['id_empresa']; ?>";
        const estadoActual = "<?php echo $consumible['estado_consumibles']; ?>";
        const utilidadActual = "<?php echo $consumible['utilidad_consumibles']; ?>";
        const idUserActual = "<?php echo $consumible['id_user'] ?? ''; ?>";

        function cargarDatos(endpoint, selectId, valorActual) {
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
                        case "users_select":
                            placeholderText = "Selecciona un Usuario";
                            break;
                        default:
                            placeholderText = "Selecciona una opción";
                    }
                    // Limpiar y agregar el texto predeterminado
                    select.innerHTML = `<option value="" disabled>${placeholderText}</option>`;

                    data.forEach(item => {
                        let option = document.createElement("option");
                        option.value = item.id_empresa || item.id_estado || item.id_utilidad || item.id_user;
                        option.textContent = item.nombre || item.nombre_estado || item.nombre_utilidad || item.username;
                        // Seleccionar la opción si coincide con el valor actual
                        if (option.value == valorActual) {
                            option.selected = true;
                        }
                        select.appendChild(option);
                    });
                })
                .catch(error => console.error("Error cargando los datos:", error));
        }

        // Cargar datos y preseleccionar las opciones
        cargarDatos("get_empresas.php", "empresa_select", idEmpresaActual);
        cargarDatos("get_estados.php", "estado_select", estadoActual);
        cargarDatos("get_utilidades.php", "utilidad_select", utilidadActual);
        cargarDatos("get_users.php", "users_select", idUserActual);
    });
    </script>
</body>
</html>